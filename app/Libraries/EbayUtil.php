<?php 
namespace App\Libraries;
# use  App\Libraries\EbayUtil;

class EbayUtil {
    // API endpoint constants
    const API_ENDPOINT = 'https://api.ebay.com/buy/browse/v1/';
    
    // Primary credentials
    protected $devID;
    protected $appID;
    protected $certID;
    protected $clientID;
    protected $ruName;
    public $appToken;    
    
    // Fallback credentials removed - Qoo10 credentials not working (401 authentication failed)
    // Only using primary ShopKorea credentials (250K daily limit)
    
    protected $currentCredentialSet = 'primary'; // Only 'primary' available now
    protected $credentialSwitchTime = null; // Time when credentials were switched due to rate limiting
    
    // SQLite3 database for token storage
    protected $dbPath;
    protected $db;
    
    /**
     * Safe logging method that only logs if log_message function exists
     */
    private function safeLog($level, $message)
    {
        if (function_exists('log_message')) {
            log_message($level, $message);
        }
    }

    public function __construct()
    {
        // Initialize primary credentials from environment variables
        // We have increased your daily call limit for the Browse API from 100K to 250K
        $this->clientID = getenv('EBAY_CLIENT_ID') ?: 'your-client-id-here'; # App ID (Client ID)
        $this->certID = getenv('EBAY_CLIENT_SECRET') ?: 'your-client-secret-here'; # Cert ID (Client Secret)


        // Load credential state from previous sessions
        $this->loadCredentialState();
        
        try {
            // Initialize SQLite3 token database
            $this->initTokenDatabase();
            
            // Clean up expired tokens
            $this->cleanupExpiredTokens();
            
            // Try to load existing valid token from SQLite3 database
            $this->appToken = $this->loadTokenFromDatabase($this->currentCredentialSet);
            
            // If no valid token found, create a new one
            if (empty($this->appToken)) {
                $this->safeLog('info', 'No valid token found in database, creating new token');
                $this->appToken = $this->createAppToken();
                
                // Save the new token to database
                if ($this->appToken) {
                    $this->saveTokenToDatabase($this->appToken, $this->currentCredentialSet, $this->credentialSwitchTime);
                }
            } else {
                $this->safeLog('info', 'Valid token loaded from SQLite3 database');
            }

        } catch (\Exception $e) {
            $this->safeLog('error', 'Error in constructor: ' . $e->getMessage());
            // Still try to create a new token even if there's an error
            $this->appToken = $this->createAppToken();
            
            // Try to save it to database
            if ($this->appToken) {
                $this->saveTokenToDatabase($this->appToken, $this->currentCredentialSet, $this->credentialSwitchTime);
            }
        }
    }    

    /**
     * Initialize SQLite3 token database
     */
    private function initTokenDatabase()
    {
        try {
            // Set database path (handle cases where WRITEPATH is not defined)
            $writePath = defined('WRITEPATH') ? WRITEPATH : (realpath(__DIR__ . '/../../writable/') . DIRECTORY_SEPARATOR);
            $this->dbPath = $writePath . 'token_storage.db';
            
            // Create or open SQLite3 database
            $this->db = new \SQLite3($this->dbPath);
            
            // Create ebay_tokens table if it doesn't exist
            $createTableQuery = "
                CREATE TABLE IF NOT EXISTS ebay_tokens (
                    id INTEGER PRIMARY KEY AUTOINCREMENT,
                    credential_set TEXT NOT NULL,
                    token TEXT NOT NULL,
                    expires_at DATETIME NOT NULL,
                    credential_switch_time INTEGER,
                    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
                    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP
                )
            ";
            
            $this->db->exec($createTableQuery);
            
            // Create indexes for faster lookups
            $this->db->exec("CREATE INDEX IF NOT EXISTS idx_credential_set ON ebay_tokens(credential_set)");
            $this->db->exec("CREATE INDEX IF NOT EXISTS idx_expires_at ON ebay_tokens(expires_at)");
            
            $this->safeLog('info', 'SQLite3 token database initialized successfully');
            
        } catch (\Exception $e) {
            $this->safeLog('error', 'Failed to initialize SQLite3 token database: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Save token to SQLite3 database
     */
    private function saveTokenToDatabase($token, $credentialSet, $credentialSwitchTime = null)
    {
        try {
            if (!$this->db) {
                $this->initTokenDatabase();
            }
            
            // Calculate expiry time (eBay tokens expire in 2 hours)
            $expiresAt = date('Y-m-d H:i:s', time() + 7200);
            
            // First, remove any existing tokens for this credential set
            $deleteStmt = $this->db->prepare("DELETE FROM ebay_tokens WHERE credential_set = ?");
            $deleteStmt->bindValue(1, $credentialSet, SQLITE3_TEXT);
            $deleteStmt->execute();
            
            // Insert new token
            $insertStmt = $this->db->prepare("
                INSERT INTO ebay_tokens (credential_set, token, expires_at, credential_switch_time, updated_at) 
                VALUES (?, ?, ?, ?, CURRENT_TIMESTAMP)
            ");
            
            $insertStmt->bindValue(1, $credentialSet, SQLITE3_TEXT);
            $insertStmt->bindValue(2, $token, SQLITE3_TEXT);
            $insertStmt->bindValue(3, $expiresAt, SQLITE3_TEXT);
            $insertStmt->bindValue(4, $credentialSwitchTime, SQLITE3_INTEGER);
            
            $result = $insertStmt->execute();
            
            if ($result) {
                $this->safeLog('info', "Token saved to SQLite3 database for credential set: {$credentialSet}");
            } else {
                $this->safeLog('error', "Failed to save token to SQLite3 database for credential set: {$credentialSet}");
            }
            
        } catch (\Exception $e) {
            $this->safeLog('error', 'Error saving token to database: ' . $e->getMessage());
        }
    }

    /**
     * Load valid token from SQLite3 database
     */
    private function loadTokenFromDatabase($credentialSet)
    {
        try {
            if (!$this->db) {
                $this->initTokenDatabase();
            }
            
            // Get current time for expiry check
            $currentTime = date('Y-m-d H:i:s');
            
            // Load valid (non-expired) token for the credential set
            $selectStmt = $this->db->prepare("
                SELECT token, expires_at, credential_switch_time 
                FROM ebay_tokens 
                WHERE credential_set = ? AND expires_at > ? 
                ORDER BY created_at DESC 
                LIMIT 1
            ");
            
            $selectStmt->bindValue(1, $credentialSet, SQLITE3_TEXT);
            $selectStmt->bindValue(2, $currentTime, SQLITE3_TEXT);
            
            $result = $selectStmt->execute();
            $row = $result->fetchArray(SQLITE3_ASSOC);
            
            if ($row) {
                // Update credential switch time if available
                if ($row['credential_switch_time']) {
                    $this->credentialSwitchTime = (int)$row['credential_switch_time'];
                }
                
                $this->safeLog('info', "Valid token loaded from SQLite3 database for credential set: {$credentialSet}");
                return $row['token'];
            } else {
                $this->safeLog('info', "No valid token found in SQLite3 database for credential set: {$credentialSet}");
                return null;
            }
            
        } catch (\Exception $e) {
            $this->safeLog('error', 'Error loading token from database: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Clean up expired tokens from SQLite3 database
     */
    private function cleanupExpiredTokens()
    {
        try {
            if (!$this->db) {
                $this->initTokenDatabase();
            }
            
            $currentTime = date('Y-m-d H:i:s');
            
            // Delete expired tokens
            $deleteStmt = $this->db->prepare("DELETE FROM ebay_tokens WHERE expires_at <= ?");
            $deleteStmt->bindValue(1, $currentTime, SQLITE3_TEXT);
            $result = $deleteStmt->execute();
            
            $deletedCount = $this->db->changes();
            
            if ($deletedCount > 0) {
                $this->safeLog('info', "Cleaned up {$deletedCount} expired tokens from SQLite3 database");
            }
            
        } catch (\Exception $e) {
            $this->safeLog('error', 'Error cleaning up expired tokens: ' . $e->getMessage());
        }
    }

    public function refreshToken($tokenPath, $tokenType){
        $refreshedToken = $this->refreshTokenFromFile($tokenPath, $tokenType);
        if ($refreshedToken) {
            $this->appToken = $refreshedToken;
            $this->safeLog('info', "Token successfully refreshed from {$tokenType} refresh token");
            return true;
        } else {
            $this->safeLog('warning', "Failed to refresh token from {$tokenType}, trying next option");
            return false;
        }
    }



    public function createAppToken()
    {
        try {
            $link = "https://api.ebay.com/identity/v1/oauth2/token";
            
            // Get current credentials based on credential set
            $credentials = $this->getCurrentCredentialsForTokenGeneration();
            $codeAuth = base64_encode($credentials['clientID'].':'.$credentials['certID']);
            
            $ch = curl_init($link);
            curl_setopt_array($ch, [
                CURLOPT_HTTPHEADER => [
                    'Content-Type: application/x-www-form-urlencoded',
                    'Authorization: Basic '.$codeAuth
                ],
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_POST => 1,
                CURLOPT_POSTFIELDS => "grant_type=client_credentials&scope=https://api.ebay.com/oauth/api_scope",
                CURLOPT_TIMEOUT => 30
            ]);

            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            $error = curl_error($ch);
            curl_close($ch);

            if ($error) {
                $this->safeLog('error', 'cURL Error while creating token: ' . $error);
                return null;
            }

            if ($httpCode !== 200) {
                $this->safeLog('error', 'HTTP Error while creating token: ' . $httpCode . ' Response: ' . $response);
                
                // Try next credential set if current one fails
                if ($this->switchToNextCredentialSet()) {
                    $this->safeLog('info', 'Switched to ' . $this->currentCredentialSet . ' credentials, retrying token creation');
                    return $this->createAppToken();
                }
                
                return null;
            }

            $responseData = json_decode($response, true);
            if (!isset($responseData['access_token'])) {
                $this->safeLog('error', 'No access token in create response');
                return null;
            }

            // Save token data with expiration and current credential set
            $tokenData = [
                'token' => $responseData['access_token'],
                'exp' => date('Y-m-d H:i:s', time() + 7200), // Token expires in 2 hours
                'credential_set' => $this->currentCredentialSet,
                'credential_switch_time' => $this->credentialSwitchTime
            ];

            // Save token to file (legacy support)
            $writePath = defined('WRITEPATH') ? WRITEPATH : (realpath(__DIR__ . '/../../writable/') . DIRECTORY_SEPARATOR);
            file_put_contents($writePath . 'token_info.txt', json_encode($tokenData));
            $this->appToken = $responseData['access_token'];
            
            // Save to SQLite3 database
            $this->saveTokenToDatabase($responseData['access_token'], $this->currentCredentialSet, $this->credentialSwitchTime);
            
            return $responseData['access_token'];

        } catch (\Exception $e) {
            print_r('error', 'Exception while creating token: '. $e->getMessage());
            $this->safeLog('error', 'Exception while creating token: ' . $e->getMessage());
            return null;
        }
    }    
    
    private function refreshAppToken() {
        try {
            $link = "https://api.ebay.com/identity/v1/oauth2/token";
            
            // Get current credentials based on credential set
            $credentials = $this->getCurrentCredentials();
            $codeAuth = base64_encode($credentials['clientID'].':'.$credentials['certID']);
            
            $ch = curl_init($link);
            curl_setopt_array($ch, [
                CURLOPT_HTTPHEADER => [
                    'Content-Type: application/x-www-form-urlencoded',
                    'Authorization: Basic '.$codeAuth
                ],
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_POST => 1,
                CURLOPT_POSTFIELDS => "grant_type=client_credentials&scope=https://api.ebay.com/oauth/api_scope",
                CURLOPT_TIMEOUT => 30
            ]);

            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            $error = curl_error($ch);
            curl_close($ch);

            if ($error) {
                $this->safeLog('error', 'cURL Error while refreshing token: ' . $error);
                return null;
            }

            if ($httpCode !== 200) {
                $this->safeLog('error', 'HTTP Error while refreshing token: ' . $httpCode . ' Response: ' . $response);
                return null;
            }

            $responseData = json_decode($response, true);
            if (!isset($responseData['access_token'])) {
                $this->safeLog('error', 'No access token in refresh response');
                return null;
            }            // Save the new token with current credential info
            $tokenData = [
                'token' => $responseData['access_token'],
                'exp' => date('Y-m-d H:i:s', time() + 7200), // Token expires in 2 hours
                'credential_set' => $this->currentCredentialSet,
                'credential_switch_time' => $this->credentialSwitchTime
            ];
            
            // Save token to both locations
            $writePath = defined('WRITEPATH') ? WRITEPATH : (realpath(__DIR__ . '/../../writable/') . DIRECTORY_SEPARATOR);
            file_put_contents($writePath . 'token_info.txt', json_encode($tokenData));
            
            // Update SQLite3 database
            $this->saveTokenToDatabase($responseData['access_token'], $this->currentCredentialSet, $this->credentialSwitchTime);
            
            return $responseData['access_token'];

        } catch (\Exception $e) {
            $this->safeLog('error', 'Exception while refreshing token: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Refresh access token using refresh token from specified token file
     * @param string $tokenPath Path to the token file
     * @param string $tokenType Type identifier for logging
     * @return string|null New access token on success, null on failure
     */
    private function refreshTokenFromFile($tokenPath, $tokenType)
    {
        try {
            if (!file_exists($tokenPath)) {
                $this->safeLog('error', "refreshTokenFromFile: {$tokenType} file not found: {$tokenPath}");
                return null;
            }

            $tokenData = json_decode(file_get_contents($tokenPath), true);
            
            if (!$tokenData || !isset($tokenData['refresh_token'])) {
                $this->safeLog('error', "refreshTokenFromFile: No refresh token found in {$tokenType} file");
                return null;
            }

            $link = "https://api.ebay.com/identity/v1/oauth2/token";
            
            // Get current credentials for token refresh
            $credentials = $this->getCurrentCredentialsForTokenGeneration();
            $codeAuth = base64_encode($credentials['clientID'].':'.$credentials['certID']);
            
            $ch = curl_init($link);
            curl_setopt_array($ch, [
                CURLOPT_HTTPHEADER => [
                    'Content-Type: application/x-www-form-urlencoded',
                    'Authorization: Basic '.$codeAuth
                ],
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_POST => 1,
                CURLOPT_POSTFIELDS => "grant_type=refresh_token&refresh_token=" . urlencode($tokenData['refresh_token']),
                CURLOPT_TIMEOUT => 30
            ]);

            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            $error = curl_error($ch);
            curl_close($ch);

            if ($error) {
                $this->safeLog('error', "cURL Error while refreshing token from {$tokenType}: " . $error);
                return null;
            }

            if ($httpCode !== 200) {
                $this->safeLog('error', "HTTP Error while refreshing token from {$tokenType}: " . $httpCode . ' Response: ' . $response);
                return null;
            }

            $responseData = json_decode($response, true);
            if (!isset($responseData['access_token'])) {
                $this->safeLog('error', "No access token in refresh response from {$tokenType}");
                return null;
            }

            // Update token file with new token data
            $newTokenData = [
                'access_token' => $responseData['access_token'],
                'expires_in' => $responseData['expires_in'] ?? 7200,
                'token_type' => $responseData['token_type'] ?? 'User Access Token'
            ];

            // Keep the refresh token if provided, otherwise use the existing one
            if (isset($responseData['refresh_token'])) {
                $newTokenData['refresh_token'] = $responseData['refresh_token'];
                $newTokenData['refresh_token_expires_in'] = $responseData['refresh_token_expires_in'] ?? $tokenData['refresh_token_expires_in'];
            } else {
                $newTokenData['refresh_token'] = $tokenData['refresh_token'];
                $newTokenData['refresh_token_expires_in'] = $tokenData['refresh_token_expires_in'];
            }

            // Save updated token data
            if (file_put_contents($tokenPath, json_encode($newTokenData, JSON_PRETTY_PRINT))) {
                $this->safeLog('info', "Token refreshed successfully from {$tokenType} refresh token");
                
                // Update SQLite3 database
                $this->saveTokenToDatabase($newTokenData['access_token'], $this->currentCredentialSet, $this->credentialSwitchTime);
                
                return $responseData['access_token'];
            } else {
                $this->safeLog('error', "Failed to save refreshed token to {$tokenType} file");
                return null;
            }

        } catch (\Exception $e) {
            $this->safeLog('error', "Exception while refreshing token from {$tokenType}: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Legacy method for backward compatibility - redirects to refreshTokenFromFile
     * @deprecated Use refreshTokenFromFile instead
     */
    private function refreshTokenFromKmchmail()
    {
        $kmchmailTokenPath = APPPATH . 'Libraries/token_kmchmail.json';
        return $this->refreshTokenFromFile($kmchmailTokenPath, 'kmchmail');
    }



    /**
     * Try to load and refresh token from a specific token file
     * @param string $tokenPath Path to the token file
     * @param string $tokenType Type identifier for logging (e.g., 'kmchmail', 'abitraseoul')
     * @return bool True if token was successfully loaded/refreshed, false otherwise
     */
    private function tryLoadAndRefreshToken($tokenPath, $tokenType)
    {
        if (!file_exists($tokenPath)) {
            $this->safeLog('info', "Token file {$tokenType} not found: {$tokenPath}");
            return false;
        }

        $tokenData = json_decode(file_get_contents($tokenPath), true);
        if (!$tokenData || !isset($tokenData['access_token'])) {
            $this->safeLog('info', "No valid access token found in {$tokenType} file");
            return false;
        }

        // Check if token is valid (eBay tokens typically expire in 2 hours)
        $tokenCreatedTime = filemtime($tokenPath);
        $tokenExpiryTime = $tokenCreatedTime + ($tokenData['expires_in'] ?? 7200);
        $remainingTime = $tokenExpiryTime - time();
        
        // If token expires in more than 15 minutes, use it
        if ($remainingTime > 900) { // 15 minutes = 900 seconds
            $this->appToken = $tokenData['access_token'];
            $this->safeLog('info', "Token loaded from {$tokenType} (valid for " . round($remainingTime/60) . " more minutes)");
            return true;
        }
        
        // If token expires in 15 minutes or less, try to refresh it
        if ($remainingTime > 0 && isset($tokenData['refresh_token'])) {
            $this->safeLog('info', "Token from {$tokenType} expires in " . round($remainingTime/60) . " minutes, attempting refresh");
            $refreshedToken = $this->refreshTokenFromFile($tokenPath, $tokenType);
            if ($refreshedToken) {
                $this->appToken = $refreshedToken;
                $this->safeLog('info', "Token successfully refreshed from {$tokenType} refresh token");
                return true;
            } else {
                $this->safeLog('warning', "Failed to refresh token from {$tokenType}, trying next option");
                return false;
            }
        }
        
        $this->safeLog('info', "Token in {$tokenType} is expired or no refresh token available");
        return false;
    }
    

    public function getEbaySearchData($searchData){

        $perPage = $searchData['perpage'];
        $pageNumber = $searchData['pageNumber'];
        $sort = $searchData['sortOrder'];
        //$filter[] = array("Condition","Used");

        if($searchData['ListingType'] != 'AuctionWithBIN'){
            $filter[] = array("ListingType",$searchData['ListingType']);
        }

        if($searchData['itemFilter'] != ''){
            $item_filter = explode(":",$searchData['itemFilter']);
            foreach($item_filter as $item){
                $arr = explode("||", $item);
                if(isset($arr[1])){
                    $filter[] = array($arr[0], $arr[1]);
                }
            }
        }
        $filter[] = array("LocatedIn","KR");
        $filter[] = array("HideDuplicateItems", "true");
        //$filter[] = array("LocatedIn","US");
        $aspectfilter = array();
        if($searchData['aspectFilter'] != ''){

            $aspect_filter = explode(":",$searchData['aspectFilter']);
            foreach($aspect_filter as $item){
                if($item != ''){
                    $arr = explode("||", $item);
                    if(isset($arr[0])){
                        $aspectfilter[] = array($arr[0], $arr[1]);
                    }
                }
            }
        }
        $selector = array('AspectHistogram','CategoryHistogram','ConditionHistogram','PictureURLLarge','SellerInfo');

        $xmldata = $this->findItemsAdvanced($aspectfilter, $filter, $selector, $searchData);
        $newxmldata = simplexml_load_string(str_replace("http:", "https:",$xmldata->asXml() ));
        //print_r($newxmldata);
        return $newxmldata;

    }
    

    //ebay api
    public function findItemsAdvanced($aspectfilter, $filter, $selector, $searchData){
        ini_set("default_socket_timeout", 10);

        $execUrl = "https://svcs.ebay.com/services/search/FindingService/v1?";
        $baseParam = $this->getBasicParam("findItemsAdvanced");
        $itemFilter = $this->setItemFilter($filter);
        $aspectFilter = $this->setAspectFilter($aspectfilter);
        $outputSelector = $this->setOutPutSelector($selector);

        $apicall = $execUrl.$baseParam.$itemFilter.$aspectFilter.$outputSelector;
 
        //print_r($apicall);exit;    

        //$apicall .= "&paginationInput.entriesPerPage=2&categoryId=11450";
        //$apicall .= "&categoryId=$categoryId&paginationInput.pageNumber=$pageNumber&paginationInput.entriesPerPage=$perPage&keywords=$keyword&sortOrder=$sort";
        $apicall .= $this->getKeyValueUrl($searchData);
        //echo $apicall;
        $apicall = urlencode($apicall);
        $resp = simplexml_load_file($apicall);
        
        // echo "<xmp>";
        // print_r($resp);
        // echo "</xmp>";
        // exit;
        
        return $resp;
        //$this->load->view('/admin/webservice/getSingleItem');
    }

    public function getKeyValueUrl($searchData){
        $result = "";
        $cnt = 0;
        foreach($searchData as $key=>$val){
            if($val == '' || $key == 'viewTypeMenu' || $key == 'itemFilter' || $key == 'aspectFilter'){
                continue;
            }
            if($key == 'pageNumber'){
                $result .= "&paginationInput.pageNumber=".$val;
            }else if($key == 'perpage'){
                $result .= "&paginationInput.entriesPerPage=".$val;
            }else{
                $result .= "&".$key."=".$val;
            }
            //$result .= "&itemFilter($cnt).name=".$item[0]."&itemFilter($cnt).value=".$item[1];
        }
        return $result;
    }

    public function getBasicParam($operation){

        $appid = $this->clientID; // Use configured client ID
        $result = "OPERATION-NAME=".$operation;
        $result .= "&SERVICE-VERSION=1.0.0";
        $result .= "&SECURITY-APPNAME=$appid";
        $result .= "&RESPONSE-DATA-FORMAT=XML";
        $result .= "&REST-PAYLOAD";

        return $result;
    }

    public function setAspectFilter($filter){

        $result = "";
        $cnt = 0;
        foreach($filter as $item){
            $result .= "&aspectFilter($cnt).aspectName=".$this->makeUrl(urlencode($item[0]))."&aspectFilter($cnt).aspectValueName=".$this->makeUrl(urlencode($item[1]));
            $cnt++;
        }//str_replace("\'", "%27", $item[0])
        return $result;
    }


    public function setCategoryInfo($aCategoryList){

        $result = "";
        $cnt = 0;
        foreach($aCategoryList as $iCategoryNo){
            $result .= "&categoryId($cnt)=". $iCategoryNo;
            $cnt++;
        }
        return $result;
    }


    public function makeUrl($url){
        $url = str_replace("%28","(", $url);
        $url = str_replace("%29",")", $url);
        $url = str_replace("%5C","", $url);

        return $url;
    }

    public function setItemFilter($filter){

        $result = "";
        $cnt = 0;
        foreach($filter as $aItems){
            if ('Seller' == $aItems[0]) {
                foreach ($aItems as $seq => $item) {
                    if (0 == $seq) {
                        $result .= "&itemFilter(". $cnt .").name=". $item;
                        continue;
                    }

                    $result .= "&itemFilter(". $cnt .").value(". ($seq - 1) .")=".$item;
                }
            }
            else {
                $result .= "&itemFilter($cnt).name=".$aItems[0]."&itemFilter($cnt).value=".$aItems[1];
            }

            $cnt++;
        }
        return $result;
    }

    public function setOutPutSelector($selector){

        $cnt = count($selector);
        $result = "";
        for($i = 0; $i < $cnt; $i++){
            $result .= "&outputSelector(".$i.")=".$selector[$i];
        }
        return $result;
    }



    public function getSingleItem($ItemID){
        
        return("");
        
        $ch = curl_init();        
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'X-EBAY-API-IAF-TOKEN:Bearer '.$this->authToken, 
            'X-EBAY-API-SITE-ID:0',
            'X-EBAY-API-CALL-NAME:GetSingleItem',
            'X-EBAY-API-VERSION:863',
            'X-EBAY-API-REQUEST-ENCODING:xml'
            ));

        // REQUEST XML
        $request_xml  = "";
        $request_xml .= "<?xml version=\"1.0\" encoding=\"utf-8\"?>";
        $request_xml .= "<GetSingleItemRequest xmlns=\"urn:ebay:apis:eBLBaseComponents\">";
        $request_xml .= "<ItemID>$ItemID</ItemID>";
        $request_xml .= "    <DetailLevel>ReturnAll</DetailLevel>";
        $request_xml .= "    <IncludeSelector>ItemSpecifics,Details,TextDescription</IncludeSelector>";
        $request_xml .= "</GetSingleItemRequest>";

        $url = "https://open.api.ebay.com/shopping";

        //setting the curl parameters.

        curl_setopt($ch, CURLOPT_URL, $url);
        // Following line is compulsary to add as it is:
        curl_setopt($ch, CURLOPT_POSTFIELDS,
                    "xmlRequest=" . $request_xml);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 300);
        $data = curl_exec($ch);
        curl_close($ch);
        
        // print_r($token);
        // print_r("<BR><BR?");
        // print($data);
        // exit;

        if(strpos($data, "Invalid token")){
            return "@INVALIDTOKEN";             

        }else{
            return simplexml_load_string($data);
        }
    }
    


    public function getRelatedSearches($sKeywords){

        $link = "https://www.ebay.com/autosug?kwd=".$sKeywords."&callback=0";
        $ch = curl_init($link);

        $response = curl_exec($ch);
        $jsonDecoded = json_decode($response, true);
        $info = curl_getinfo($ch);
        curl_close($ch);

        //print_r($info);
        
        if($jsonDecoded != null)
        {
             return $jsonDecoded["res"];
        }


    }

    public function getPopularSearches($sKeywords,$appToken=null){

        /*-- OLD CODE => 더이상 지원 안되는 듯...*/
        // API request variables
        $sEndPoint         = 'https://open.api.ebay.com/shopping';
        $sAppID            = getenv('EBAY_LEGACY_APP_ID') ?: $this->clientID;
        $sCallName         = 'FindPopularSearches';
        $sSiteID           = '0';
        $iVersion          = 515;
        $sResponseEncoding = 'XML';

        // Construct the findItemsByKeywords HTTP GET call
        $aApiCalls = array();
        $aApiCalls[] = $sEndPoint .'?';
        $aApiCalls[] = 'callname='. $sCallName;
        $aApiCalls[] = '&responseencoding='. $sResponseEncoding;
        $aApiCalls[] = '&appid='. $sAppID;
        $aApiCalls[] = '&siteid='. $sSiteID;
        $aApiCalls[] = '&version='. $iVersion;
        $aApiCalls[] = '&QueryKeywords='. $sKeywords;
        $oResp = simplexml_load_file(implode('', $aApiCalls));
        
        // Log API call statistics
        // helper('api_stat');
        // log_api_call('shopping/FindPopularSearches', 200, $sKeywords);

        return $oResp;


        // $ch = curl_init();        
        // curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        //     'X-EBAY-API-IAF-TOKEN:Bearer '.$appToken, 
        //     'X-EBAY-API-SITE-ID:0',
        //     'X-EBAY-API-CALL-NAME:getPopularSearches',
        //     'X-EBAY-API-VERSION:515',
        //     'X-EBAY-API-REQUEST-ENCODING:xml'
        //     ));

/*         // REQUEST XML
        $request_xml  = "";
        $request_xml .= "<?xml version=\"1.0\" encoding=\"utf-8\"?>";
        $request_xml .= "<getPopularSearches xmlns=\"urn:ebay:apis:eBLBaseComponents\">";
        $request_xml .= "<QueryKeywords>$sKeywords</QueryKeywords>";
        $request_xml .= "</getPopularSearches>";

        $url = "https://open.api.ebay.com/shopping";

        //setting the curl parameters.

        curl_setopt($ch, CURLOPT_URL, $url);
        // Following line is compulsary to add as it is:
        curl_setopt($ch, CURLOPT_POSTFIELDS,
                    "xmlRequest=" . $request_xml);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 300);
        $data = curl_exec($ch);
        curl_close($ch);
        

        if(strpos($data, "Invalid token")){
            return "@TOKENREFRESHED";             
        }else{
            return simplexml_load_string($data);
        } */
    }


    public function getSimilarItem($ItemID){
        $endpoint   = 'https://svcs.ebay.com/MerchandisingService';
        $version    = '1.4.0';
        $appid      = getenv('EBAY_LEGACY_APP_ID') ?: $this->clientID;
        $dataFormat = "XML";
        $callname   = "getSimilarItems";

        $apicall  = $endpoint ."?";
        $apicall .= "OPERATION-NAME=". $callname;
        $apicall .= "&SERVICE-NAME=MerchandisingService";
        $apicall .= "&RESPONSE-DATA-FORMAT=". $dataFormat;
        $apicall .= "&CONSUMER-ID=". $appid;
        $apicall .= "&SERVICE-VERSION=". $version;
        $apicall .= "&itemId=". $ItemID;
        $apicall .= "&REST-PAYLOAD";
        $apicall .= "&maxResults=14";
        $resp = simplexml_load_file($apicall);
        //echo($apicall);
        return $resp;
    }


    public function getTopSellingItem($categoryID){
        $endpoint   = 'https://svcs.ebay.com/MerchandisingService';
        $version    = '1.1.0';
        $appid      = getenv('EBAY_LEGACY_APP_ID') ?: $this->clientID;
        $dataFormat = "XML";
        $callname   = "getMostWatchedItems";

        $apicall  = $endpoint ."?";
        $apicall .= "OPERATION-NAME=". $callname;
        $apicall .= "&SERVICE-NAME=MerchandisingService";
        $apicall .= "&RESPONSE-DATA-FORMAT=". $dataFormat;
        $apicall .= "&CONSUMER-ID=". $appid;
        $apicall .= "&SERVICE-VERSION=". $version;
        $apicall .= "&categoryId=". $categoryID;
        $apicall .= "&REST-PAYLOAD";
        $apicall .= "&maxResults=14";
        $resp = simplexml_load_file($apicall);

        return $resp;
    }





    public function getSingleItemNew($itemNo = '') {
        try {
            if (empty($itemNo)) {
                $this->safeLog('error', 'getSingleItemNew: Empty itemNo parameter');
                return (object)[
                    'error' => true,
                    'message' => 'Item ID is required'
                ];
            }

            // Handle item ID formats - for RESTful item IDs, use them directly
            $processedItemId = $itemNo;
            
            // If the item ID is in encoded format (itm=v1%7C316872073078%7C615360243271)
            if (strpos($itemNo, 'itm=') === 0) {
                $processedItemId = urldecode(substr($itemNo, 4)); // Remove 'itm=' and decode
            }
            // If it's already URL encoded format (v1%7C...)
            else if (strpos($itemNo, 'v1%7C') !== false) {
                $processedItemId = urldecode($itemNo);
            }
            // If it's already decoded format (v1|...)
            else if (strpos($itemNo, 'v1|') !== false) {
                $processedItemId = $itemNo; // Use as-is
            }
            // For plain item IDs, convert to RESTful format
            else if (ctype_digit($itemNo)) {
                $processedItemId = 'v1|' . $itemNo . '|0';
            }

            // Build API URL - item ID should be URL encoded when added to path
            $url = self::API_ENDPOINT . 'item/' . urlencode($processedItemId);
            
            // Initialize curl with required headers
            $ch = curl_init();
            curl_setopt_array($ch, [
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_HTTPHEADER => [
                    'Authorization: Bearer ' . $this->appToken,
                    'Content-Type: application/json',
                    'X-EBAY-C-MARKETPLACE-ID: EBAY-US',
                    'X-EBAY-C-ENDUSERCTX: contextualLocation=country=US,zip=10001'
                ],
                CURLOPT_SSL_VERIFYPEER => true,
                CURLOPT_CONNECTTIMEOUT => 10,
                CURLOPT_TIMEOUT => 20
            ]);

            // Execute request
            $this->safeLog('info', 'getSingleItemNew: Requesting eBay API for item ' . $processedItemId . ' (original: ' . $itemNo . ') with URL: ' . $url);

            $response = curl_exec($ch);

            // print_r($this->appToken);
            // print_r($response);
            

            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            $error = curl_error($ch);
            curl_close($ch);
            
            // Log API call statistics
            // helper('api_stat');
            // log_api_call('item (getSingleItemNew)', $httpCode, $itemNo);

            // Handle curl errors
            if ($error) {
                $this->safeLog('error', 'getSingleItemNew curl error: ' . $error);
                return (object)[
                    'error' => true,
                    'message' => 'Connection error'
                ];
            }

            // Handle empty response
            if (empty($response)) {
                $this->safeLog('error', 'getSingleItemNew: Empty response from API');
                return (object)[
                    'error' => true,
                    'message' => 'No response from eBay'
                ];
            }

            // Parse JSON response
            $result = json_decode($response);
            if (json_last_error() !== JSON_ERROR_NONE) {
                $this->safeLog('error', 'getSingleItemNew: JSON decode error: ' . json_last_error_msg() . ' Raw response: ' . substr($response, 0, 1000));
                return (object)[
                    'error' => true,
                    'message' => 'Invalid response format'
                ];
            }

            // Check for API error response
            if (isset($result->errors)) {
                $this->safeLog('error', 'getSingleItemNew: API error: ' . json_encode($result->errors));
                return (object)[
                    'error' => true,
                    'message' => is_array($result->errors) ? implode(', ', array_map(function($error) {
                        return isset($error->message) ? $error->message : 'Unknown error';
                    }, $result->errors)) : 'API Error',
                    'details' => $result->errors
                ];
            }

            return $result;

        } catch (\Exception $e) {
            $this->safeLog('error', 'Exception in getSingleItemNew: ' . $e->getMessage());
            return null;
        }
    }


    #https://api.ebay.com/buy/browse/v1/item_summary/search?q=bts&itemLocationCountry=KR&limit=10
    public function getItemSummaryAjax($searchData, $appToken = null) {
        try {
            $this->safeLog('info', '=== getItemSummaryAjax START ===');
            $this->safeLog('info', 'Input searchData: ' . json_encode($searchData, JSON_PRETTY_PRINT));
            
            // Use provided token or class token
            if (empty($appToken)) {
                $appToken = $this->appToken;
            }
            
            $this->safeLog('info', 'Using token (first 30 chars): ' . substr($appToken, 0, 30) . '...');


            // Base URL for eBay Browse API
            $url = 'https://api.ebay.com/buy/browse/v1/item_summary/search';            // Build query parameters
            $queryParams = [
                'limit' => isset($searchData['perpage']) ? (int)$searchData['perpage'] : 15
            ];

            // Handle category search
            if (!empty($searchData['categoryId'])) {
                $queryParams['category_ids'] = $searchData['categoryId'];
                $this->safeLog('info', 'Category filter added: ' . $searchData['categoryId']);
            }

            // Add keywords only if provided
            if (!empty($searchData['keywords'])) {
                $queryParams['q'] = $searchData['keywords']; // Don't urlencode - http_build_query will handle it
                $this->safeLog('info', 'Keywords added: ' . $searchData['keywords']);
            }

            // Add offset for pagination
            if (isset($searchData['pageNumber'])) {
                $queryParams['offset'] = ((int)$searchData['pageNumber'] - 1) * (int)$queryParams['limit'];
                $this->safeLog('info', 'Pagination - Page: ' . $searchData['pageNumber'] . ', Offset: ' . $queryParams['offset']);
            }            // Build filter array for other filters
            $filters = [];

            // Remove Korea location filter to search eBay US globally
            // $filters[] = 'itemLocationCountry:KR';
            // $this->safeLog('info', 'Location filter: itemLocationCountry:KR');

            // Add filters to query params if any exist
            if (!empty($filters)) {
                $queryParams['filter'] = implode(',', $filters);
                $this->safeLog('info', 'Applied filters: ' . $queryParams['filter']);
            }

            // Build complete URL
            $urlWithParams = $url . '?' . http_build_query($queryParams);
            $this->safeLog('info', 'Final API URL: ' . $urlWithParams);

            // Initialize curl
            $ch = curl_init();
            $headers = [
                'Authorization: Bearer ' . substr($appToken, 0, 30) . '...',
                'Content-Type: application/json',
                'X-EBAY-C-MARKETPLACE-ID: EBAY-US'
            ];
            
            $this->safeLog('info', 'Request headers: ' . json_encode([
                'Authorization' => 'Bearer ' . substr($appToken, 0, 30) . '...',
                'Content-Type' => 'application/json',
                'X-EBAY-C-MARKETPLACE-ID' => 'EBAY-US'
            ]));
            
            curl_setopt_array($ch, [
                CURLOPT_URL => $urlWithParams,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_HTTPHEADER => [
                    'Authorization: Bearer ' . $appToken,  // Use full token for actual request
                    'Content-Type: application/json',
                    'X-EBAY-C-MARKETPLACE-ID: EBAY-US'
                ],
                CURLOPT_SSL_VERIFYPEER => true,
                CURLOPT_CONNECTTIMEOUT => 10,
                CURLOPT_TIMEOUT => 20
            ]);
            
            // Execute request and get response
            $this->safeLog('info', 'Executing cURL request...');
            $startTime = microtime(true);
            $response = curl_exec($ch);
            $executionTime = microtime(true) - $startTime;
            
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            $err = curl_error($ch);
            $curlInfo = curl_getinfo($ch);
            curl_close($ch);
            
            $this->safeLog('info', 'cURL execution completed in ' . round($executionTime, 3) . ' seconds');
            $this->safeLog('info', 'HTTP Status Code: ' . $httpCode);
            $this->safeLog('info', 'Response size: ' . strlen($response) . ' bytes');
            
            // Log API call statistics
            // helper('api_stat');
            // $endpoint = !empty($searchData['keywords']) ? 'item_summary/search (keywords)' : 'item_summary/search (category)';
            // $keywords = isset($searchData['keywords']) ? $searchData['keywords'] : '';
            // log_api_call($endpoint, $httpCode, $keywords);
            
            if ($err) {
                $this->safeLog('error', 'cURL Error: ' . $err);
                $this->safeLog('error', 'cURL Info: ' . json_encode($curlInfo));
            }
            
            if ($httpCode !== 200) {
                $this->safeLog('error', 'Non-200 HTTP response: ' . $httpCode);
                $this->safeLog('error', 'Response body (first 1000 chars): ' . substr($response, 0, 1000));
            }

            // Decode response
            $this->safeLog('info', 'Decoding JSON response...');
            $result = json_decode($response);
            
            if ($result === null && json_last_error() !== JSON_ERROR_NONE) {
                $this->safeLog('error', 'JSON decode error: ' . json_last_error_msg());
                $this->safeLog('error', 'Raw response (first 1000 chars): ' . substr($response, 0, 1000));
                return null;
            }
            
            $this->safeLog('info', 'JSON decoded successfully');
            
            // Log response structure
            if (is_object($result)) {
                $resultVars = get_object_vars($result);
                $this->safeLog('info', 'Response object keys: ' . json_encode(array_keys($resultVars)));
                
                if (isset($result->total)) {
                    $this->safeLog('info', 'Total items available: ' . $result->total);
                }
                
                if (isset($result->itemSummaries)) {
                    $this->safeLog('info', 'Number of itemSummaries returned: ' . count($result->itemSummaries));
                } else {
                    $this->safeLog('warning', 'No itemSummaries in response!');
                }
                
                if (isset($result->errors)) {
                    $this->safeLog('error', 'API returned errors: ' . json_encode($result->errors));
                }
                
                if (isset($result->warnings)) {
                    $this->safeLog('warning', 'API returned warnings: ' . json_encode($result->warnings));
                }
            }
            
            $this->safeLog('info', '=== getItemSummaryAjax END ===');
            return $result; // Return the full decoded response


        } catch (\Throwable $e) { // Catch Throwable for broader error catching (PHP 7+)
            $this->safeLog('error', '=== getItemSummaryAjax EXCEPTION ===');
            $this->safeLog('error', 'Exception: ' . $e->getMessage());
            $this->safeLog('error', 'File: ' . $e->getFile() . ' Line: ' . $e->getLine());
            $this->safeLog('error', 'Stack trace: ' . $e->getTraceAsString());
            return ['error' => 'An unexpected error occurred: ' . $e->getMessage(), 'itemSummary' => null, 'itemFeed' => null];
        }
    }


    public function getItemSummary($searchData, $appToken = null, $retryCount = 0) {
        try {
            // Prevent infinite recursion by limiting retries
            if ($retryCount > 3) {
                $this->safeLog('error', 'Maximum retry limit reached for getItemSummary, aborting');
                return null;
            }
            
            // Use provided token or class token
            if (empty($appToken)) {
                $appToken = $this->appToken;
            }

            // Validate/refresh token
            if (empty($appToken)) {
                $this->safeLog('error', 'No valid token available');
                $appToken = $this->createAppToken();
                if (!$appToken) {
                    $this->safeLog('error', 'Failed to create token');
                    return null;
                }
            }

            // Base URL for eBay Browse API
            $url = 'https://api.ebay.com/buy/browse/v1/item_summary/search';            // Build query parameters
            $queryParams = [
                'limit' => isset($searchData['perpage']) ? (int)$searchData['perpage'] : 48
                // Remove itemLocationCountry restriction to get more results
                // 'itemLocationCountry' => 'KR' // This was limiting results to Korea only
            ];

            // Handle category search
            if (!empty($searchData['categoryId'])) {
                $queryParams['category_ids'] = $searchData['categoryId'];
            }

            // Add keywords only if provided
            if (!empty($searchData['keywords'])) {
                $queryParams['q'] = $searchData['keywords']; // Don't urlencode - http_build_query will handle it
            }

            // Add offset for pagination
            if (isset($searchData['pageNumber'])) {
                $queryParams['offset'] = ((int)$searchData['pageNumber'] - 1) * (int)$queryParams['limit'];
            }            // Build filter array for other filters
            $filters = [];

            // Remove Korea location filter to search eBay US globally
            // $filters[] = 'itemLocationCountry:KR';

            // Add item filters
            if (!empty($searchData['itemFilter'])) {
                if (is_string($searchData['itemFilter'])) {
                    $filterItems = explode(':', $searchData['itemFilter']);
                    foreach ($filterItems as $filter) {
                        if (strpos($filter, '||') !== false) {
                            list($name, $value) = explode('||', $filter);
                            switch ($name) {
                                case 'MinPrice':
                                case 'MaxPrice':
                                    $filters[] = 'price:[' . $value . ']';
                                    break;
                                case 'Condition':
                                    $filters[] = 'conditions:{' . $value . '}';
                                    break;
                                default:
                                    $filters[] = $name . ':{' . $value . '}';
                            }
                        }
                    }
                }
            }

            // Add buying options filter if specified
            if (!empty($searchData['buyingOptions'])) {
                $filters[] = 'buyingOptions:{' . $searchData['buyingOptions'] . '}';
            }

            // Add filters to query params if any exist
            if (!empty($filters)) {
                $queryParams['filter'] = implode(',', $filters);
            }

            // Add sort order only if specified
            if (!empty($searchData['sortOrder']) && $searchData['sortOrder'] !== '') {
                $mapped_sort = $this->mapSortOrder($searchData['sortOrder']);
                if ($mapped_sort !== '') {
                    $queryParams['sort'] = $mapped_sort;
                }
            }

            // Build complete URL
            $urlWithParams = $url . '?' . http_build_query($queryParams);

            // Add response group query: "fieldgroups=MATCHING_ITEMS,CATEGORY_REFINEMENTS,EXTENDED"
            // EXTENDED => shortDescription, itemLocation 추가 
            $urlWithParams .= '&fieldgroups=MATCHING_ITEMS,CATEGORY_REFINEMENTS,EXTENDED';


            // Initialize curl
            $ch = curl_init();

            // Determine marketplace ID
            $marketplaceId = 'EBAY-US'; // Default
            if (!empty($searchData['marketplace'])) {
                $marketplaceId = $searchData['marketplace'];
            }

            $headers = [
                'Authorization: Bearer ' . $appToken,
                'Content-Type: application/json',
                'X-EBAY-C-MARKETPLACE-ID: ' . $marketplaceId
            ];
            
            curl_setopt_array($ch, [
                CURLOPT_URL => $urlWithParams,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_HTTPHEADER => $headers,
                CURLOPT_SSL_VERIFYPEER => true,
                CURLOPT_CONNECTTIMEOUT => 10,
                CURLOPT_TIMEOUT => 20            ]);
            
            // Execute request and get response
            $this->safeLog('debug', 'eBay API Request - URL: ' . $urlWithParams);
            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            $err = curl_error($ch);
            $curlInfo = curl_getinfo($ch);
            curl_close($ch);
            
            // Log API call statistics
            // helper('api_stat');
            // $endpoint = !empty($searchData['keywords']) ? 'item_summary/search (Main-keywords)' : 'item_summary/search (Main-category)';
            // $keywords = isset($searchData['keywords']) ? $searchData['keywords'] : '';
            // log_api_call($endpoint, $httpCode, $keywords);
            
            // Decode response
            $result = json_decode($response);
            if ($result === null && json_last_error() !== JSON_ERROR_NONE) {
                $this->safeLog('error', 'JSON decode error: ' . json_last_error_msg());
                return null;
            }

            // Check for HTTP 429 rate limit error
            if ($httpCode === 429) {
                $this->safeLog('warning', 'HTTP 429 rate limit error detected');
                if ($this->handleRateLimit()) {
                    $this->safeLog('info', 'Successfully switched credentials for rate limit handling, retrying request');
                    return $this->getItemSummary($searchData, $this->appToken, $retryCount + 1);
                } else {
                    $this->safeLog('error', 'All credential sets exhausted due to rate limiting (HTTP 429)');
                    return null;
                }
            }

            // Check for API-level rate limit error and retry with fallback credentials if needed
            if ($this->handleApiError($result)) {
                // Retry the request with new token
                return $this->getItemSummary($searchData, $this->appToken, $retryCount + 1);
            }

            // Process itemSummaries to extract legacyItemId
            if (isset($result->itemSummaries) && is_array($result->itemSummaries)) {
                foreach ($result->itemSummaries as &$item) {
                    // Extract legacyItemId from itemId if not present
                    if (empty($item->legacyItemId) && !empty($item->itemId)) {
                        // itemId format: "v1|123456789|0" -> extract middle part
                        $parts = explode('|', $item->itemId);
                        if (isset($parts[1]) && is_numeric($parts[1])) {
                            $item->legacyItemId = $parts[1];
                        } else {
                            // Fallback: extract any numeric sequence
                            preg_match('/\d+/', $item->itemId, $matches);
                            $item->legacyItemId = $matches[0] ?? $item->itemId;
                        }
                    }
                }
                unset($item); // Break reference
            }

            // Add debug information to the response
            $result = $result ?: new \stdClass();
            $result->_debug = [
                'request_url' => $urlWithParams,
                'request_headers' => $headers,
                'http_code' => $httpCode,
                'curl_info' => $curlInfo,
                'curl_error' => $err ?: null,
                'filters' => $filters ?? [],
                'query_params' => $queryParams,
                'raw_response' => $response,
                'search_data' => $searchData
            ];

            // Log comprehensive debug information
            $this->safeLog('debug', 'eBay API Debug Info: ' . json_encode([
                'request_url' => $urlWithParams,
                'http_code' => $httpCode,
                'curl_error' => $err ?: null,
                'search_params' => $searchData,
                'raw_response' => $response
            ]));

            return $result;

        } catch (\Exception $e) {
            $this->safeLog('error', 'Exception in getItemSummary: ' . $e->getMessage());
            return null;
        }
    }

    private function mapSortOrder($sortOrder) {
        $map = [
            'BestMatch' => '-relevance',
            'CurrentPriceHighest' => '-price',
            'PricePlusShippingHighest' => '-price',
            'CurrentPriceLowest' => 'price',
            'PricePlusShippingLowest' => 'price',
            'EndTimeSoonest' => 'endingSoonest',
            'StartTimeNewest' => '-startTime'
        ];

        return isset($map[$sortOrder]) ? $map[$sortOrder] : '';
    }

    private function getToken() {
        // Check if current token is valid
        if (!empty($this->appToken)) {
            // Check if token is stored in token_info.txt
            $writePath = defined('WRITEPATH') ? WRITEPATH : (realpath(__DIR__ . '/../../writable/') . DIRECTORY_SEPARATOR);
            $tokenPath = $writePath . 'token_info.txt';
            if (file_exists($tokenPath)) {
                $tokenData = json_decode(file_get_contents($tokenPath), true);
                if ($tokenData && isset($tokenData['exp'])) {
                    // If token is not expired and not about to expire in next 5 minutes
                    if (strtotime($tokenData['exp']) > (time() + 300)) {
                        return $this->appToken;
                    }
                }
            }
        }

        // Token is expired or about to expire, refresh it
        $newToken = $this->refreshAppToken();
        if ($newToken) {
            $this->appToken = $newToken;
            return $newToken;
        }

        // If refresh failed, try creating new token
        $newToken = $this->createAppToken();
        if ($newToken) {
            $this->appToken = $newToken;
            return $newToken;
        }

        return null;
    }

    private function makeRequest($url, $token) {
        try {
            $ch = curl_init();
            curl_setopt_array($ch, [
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_HTTPHEADER => [
                    'Authorization: Bearer ' . $token,
                    'Content-Type: application/json',
                    'X-EBAY-C-MARKETPLACE-ID: EBAY-US'
                ],
                CURLOPT_SSL_VERIFYPEER => true,
                CURLOPT_CONNECTTIMEOUT => 10,
                CURLOPT_TIMEOUT => 20
            ]);

            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            $error = curl_error($ch);
            curl_close($ch);

            if ($error) {
                $this->safeLog('error', 'makeRequest curl error: ' . $error);
                return null;
            }

            if ($httpCode !== 200) {
                $this->safeLog('error', 'makeRequest HTTP error: ' . $httpCode . ' Response: ' . $response);
                if ($httpCode === 401 || $httpCode === 403) {
                    // Token might be expired, attempt refresh and retry
                    $newToken = $this->refreshAppToken();
                    if ($newToken) {
                        return $this->makeRequest($url, $newToken);
                    }
                }
                return null;
            }

            return $response;

        } catch (\Exception $e) {
            $this->safeLog('error', 'Exception in makeRequest: ' . $e->getMessage());
            return null;
        }
    }    private function handleApiError($result) {
        if (isset($result->errors)) {
            foreach ($result->errors as $error) {
                if (isset($error->errorId) && isset($error->domain)) {
                    // Check for rate limit error (error ID 2001)
                    if ($error->errorId === 2001 && 
                        $error->domain === 'ACCESS' &&
                        isset($error->message) && strpos($error->message, 'Too many requests') !== false) {
                        
                        $this->safeLog('warning', 'eBay API rate limit hit - attempting credential rotation');
                        
                        // Use the new credential rotation system
                        if ($this->handleRateLimit()) {
                            $this->safeLog('info', 'Successfully switched credentials for rate limit handling');
                            return true; // Signal that we should retry the request
                        } else {
                            $this->safeLog('error', 'All credential sets exhausted due to rate limiting');
                            return false;
                        }
                    }
                    // Check for OAuth token error (error ID 1001)
                    else if ($error->errorId === 1001 && 
                            $error->domain === 'OAuth' &&
                            (strpos($error->message, 'Invalid access token') !== false ||
                             strpos($error->message, 'Access token is invalid') !== false ||
                             strpos($error->message, 'expired') !== false)) {
                        
                        $this->safeLog('warning', 'eBay API OAuth error: ' . $error->message . ' - Attempting token refresh');
                        
                        // First try refreshing the token with current credentials
                        $newToken = $this->refreshAppToken();
                        if ($newToken) {
                            $this->appToken = $newToken;
                            $this->safeLog('info', 'Successfully refreshed token');
                            return true; // Signal that we should retry the request
                        }
                        
                        // If refresh failed, try creating a new token
                        $this->safeLog('warning', 'Token refresh failed, attempting to create new token');
                        $newToken = $this->createAppToken();
                        if ($newToken) {
                            $this->appToken = $newToken;
                            $this->safeLog('info', 'Successfully created new token');
                            return true;
                        }

                        // If current credential set failed, try switching to next credential set
                        if ($this->switchToNextCredentialSet()) {
                            $this->safeLog('info', 'Switched to ' . $this->currentCredentialSet . ' credentials due to OAuth error');
                            $newToken = $this->createAppToken();
                            if ($newToken) {
                                $this->appToken = $newToken;
                                $this->safeLog('info', 'Successfully created token with new credentials');
                                return true;
                            }
                        }

                        // If we get here, all token refresh/create attempts have failed
                        $this->safeLog('error', 'Failed to obtain valid token with all available credential sets');
                        throw new \Exception('Unable to obtain valid eBay API token');
                    }
                    // Log other types of errors for monitoring
                    else {
                        $this->safeLog('error', sprintf(
                            'eBay API error: [%d] %s - %s',
                            $error->errorId,
                            $error->domain,
                            $error->message ?? 'No message provided'
                        ));
                    }
                }
            }
        }
        return false;
    }

    /**
     * Get current credentials based on the current credential set
     * Specifically for token generation to avoid circular dependencies if constructor calls token generation.
     */
    public function getCurrentCredentialsForTokenGeneration()
    {
        // This method should ideally not rely on a fully constructed EbayUtil object
        // if the constructor itself might trigger token generation.
        // For simplicity, we'll use the existing logic, but be mindful of potential recursion.

        // If currentCredentialSet is not initialized, default to primary
        $set = $this->currentCredentialSet ?? 'primary';

        switch ($set) {
            case 'fallback':
                return [
                    // 'devID' => $this->fallbackDevID, // These might not be initialized if called too early
                    // 'appID' => $this->fallbackAppID,
                    'certID' => $this->fallbackCertID,
                    'clientID' => $this->fallbackClientID
                ];
            default: // 'primary'
                return [
                    // 'devID' => $this->devID,
                    // 'appID' => $this->appID,
                    'certID' => $this->certID,
                    'clientID' => $this->clientID
                ];
        }
    }

    /**
     * Get current credentials based on the current credential set
     */
    private function getCurrentCredentials()
    {
        // Only primary credentials available (fallback removed)
        return [
            'devID' => $this->devID ?? null,
            'appID' => $this->appID ?? null,
            'certID' => $this->certID,
            'clientID' => $this->clientID
        ];
    }

    /**
     * Switch to the next credential set - DISABLED (only primary available)
     */
    private function switchToNextCredentialSet()
    {
        // No fallback available, return false
        $this->safeLog('warning', 'No fallback credentials available - cannot switch');
        return false;
    }


    /**
     * Handle rate limiting by switching to next credential set
     * Note: No fallback credentials available - returns false
     */
    public function handleRateLimit()
    {
        // No fallback credentials available
        $this->safeLog('error', 'Rate limit reached and no fallback credentials available');
        return false;
    }

    /**
     * Load credential state from token info file
     */
    private function loadCredentialState()
    {
        // Handle cases where WRITEPATH is not defined (e.g., running outside CodeIgniter)
        $writePath = defined('WRITEPATH') ? WRITEPATH : (realpath(__DIR__ . '/../../writable/') . DIRECTORY_SEPARATOR);
        $tokenPath = $writePath . 'token_info.txt';
        if (file_exists($tokenPath)) {
            $tokenData = json_decode(file_get_contents($tokenPath), true);
            if ($tokenData) {
                // Handle new format
                if (isset($tokenData['credential_set'])) {
                    $this->currentCredentialSet = $tokenData['credential_set'];
                }
                if (isset($tokenData['credential_switch_time'])) {
                    $this->credentialSwitchTime = $tokenData['credential_switch_time'];
                }
                
                // Handle migration from old format
                else if (isset($tokenData['using_fallback'])) {
                    if ($tokenData['using_fallback']) {
                        $this->currentCredentialSet = 'fallback';
                        $this->credentialSwitchTime = time(); // Set current time for migration
                        $this->safeLog('info', 'Migrated token from old format: using fallback credentials');

                        // Update token file to new format
                        $this->saveCredentialState($tokenData['token'], $tokenData['exp']);
                    } else {
                        $this->currentCredentialSet = 'primary';
                        $this->credentialSwitchTime = null;
                        $this->safeLog('info', 'Migrated token from old format: using primary credentials');
                    }
                }
            }
        }
    }

    /**
     * Save credential state to token file (used for migration)
     */
    private function saveCredentialState($token, $exp)
    {
        $tokenData = [
            'token' => $token,
            'exp' => $exp,
            'credential_set' => $this->currentCredentialSet,
            'credential_switch_time' => $this->credentialSwitchTime
        ];
        
        $writePath = defined('WRITEPATH') ? WRITEPATH : (realpath(__DIR__ . '/../../writable/') . DIRECTORY_SEPARATOR);
        $tokenPath = $writePath . 'token_info.txt';
        file_put_contents($tokenPath, json_encode($tokenData));
        $this->safeLog('info', 'Updated token file to new credential format');
    }

    /**
     * Get the current credential set for testing purposes
     */
    public function getCurrentCredentialSet()
    {
        return $this->currentCredentialSet;
    }

    /**
     * Get the credential switch time for testing purposes
     */
    public function getCredentialSwitchTime()
    {
        return $this->credentialSwitchTime;
    }

    /**
     * Centralized token management for both Main.php and Ajax.php controllers
     * Handles loading, validating, and refreshing the token_info.txt file
     * 
     * @param int $expiryBufferMinutes Minutes before expiry to consider token as expired (default: 30)
     * @return array Returns array with 'token' and 'expDate' keys
     * @throws \RuntimeException if token cannot be obtained
     */
    public function manageTokenInfo($expiryBufferMinutes = 30)
    {
        require_once APPPATH . 'Libraries/getBasicToken.php';
        
        $writePath = defined('WRITEPATH') ? WRITEPATH : (realpath(__DIR__ . '/../../writable/') . DIRECTORY_SEPARATOR);
        $tokenPath = $writePath . 'token_info.txt';
        $needNewToken = false;
        $token = null;
        $expDate = null;
        
        if (!file_exists($tokenPath)) {
            $this->safeLog('info', 'Token file not found, creating new token');
            $needNewToken = true;
        } else {
            $tokenJson = @file_get_contents($tokenPath);
            if ($tokenJson === false) {
                $this->safeLog('error', 'Unable to read token file: ' . $tokenPath);
                $needNewToken = true;
            } else {
                $tokenData = json_decode($tokenJson, true);
                if (!$tokenData || !isset($tokenData['token']) || !isset($tokenData['exp']) || $tokenData['token'] === null) {
                    $this->safeLog('info', 'Invalid token data, creating new token');
                    $needNewToken = true;
                } else {
                    $token = $tokenData['token'];
                    $expDate = new \CodeIgniter\I18n\Time($tokenData['exp']);
                    
                    // Check if token is expiring soon
                    $currentTime = \CodeIgniter\I18n\Time::now();
                    $difference = $expDate->getTimestamp() - $currentTime->getTimestamp();
                    $minutesRemaining = $difference / 60;
                    
                    if ($minutesRemaining < $expiryBufferMinutes) {
                        $this->safeLog('info', "Token expiring in {$minutesRemaining} minutes (buffer: {$expiryBufferMinutes}), creating new token");
                        $needNewToken = true;
                    }
                }
            }
        }
        
        if ($needNewToken) {
            try {
                // Get current credentials to pass to token generation function
                $credentials = $this->getCurrentCredentialsForTokenGeneration();
                
                // Generate new token with current credentials
                $newToken = createBasicOauthToken($credentials['clientID'], $credentials['certID']);
                
                if (!$newToken) {
                    throw new \RuntimeException('createBasicOauthToken() failed to return a valid token');
                }
                
                $newExpTime = \CodeIgniter\I18n\Time::now()->addHours(2);
                $tokenData = [
                    'token' => $newToken,
                    'exp' => $newExpTime->toDateTimeString()
                ];
                
                if (file_put_contents($tokenPath, json_encode($tokenData)) === false) {
                    throw new \RuntimeException('Failed to write token file: ' . $tokenPath);
                }
                
                $token = $newToken;
                $expDate = $newExpTime;
                
                $this->safeLog('info', 'New token generated and saved via centralized management');
                
            } catch (\Exception $e) {
                $this->safeLog('error', 'Token generation error: ' . $e->getMessage());
                throw new \RuntimeException('Failed to obtain new token: ' . $e->getMessage());
            }
        }
        
        return [
            'token' => $token,
            'expDate' => $expDate
        ];
    }
    
    /**
     * Get current rate limit information from eBay API
     * 
     * @param string $apiName The API name to check (default: 'browse')
     * @return array|null Rate limit information or null on failure
     */
    public function getRateLimitInfo($apiName = 'browse')
    {
        try {
            // Check if token is available
            if (empty($this->appToken)) {
                $this->safeLog('error', 'No token available for rate limit check');
                return null;
            }
            
            // Build API URL
            $url = "https://api.ebay.com/developer/analytics/v1_beta/rate_limit?api_name={$apiName}";
            
            // Initialize curl
            $ch = curl_init();
            curl_setopt_array($ch, [
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_HTTPHEADER => [
                    'Authorization: Bearer ' . $this->appToken,
                    'Content-Type: application/json'
                ],
                CURLOPT_SSL_VERIFYPEER => true,
                CURLOPT_CONNECTTIMEOUT => 10,
                CURLOPT_TIMEOUT => 15
            ]);
            
            // Execute request
            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            $error = curl_error($ch);
            curl_close($ch);
            
            // Log API call statistics
            // helper('api_stat');
            // log_api_call('analytics/rate_limit', $httpCode, $apiName);
            
            // Handle errors
            if ($error) {
                $this->safeLog('error', 'cURL error in getRateLimitInfo: ' . $error);
                return null;
            }
            
            if ($httpCode !== 200) {
                $this->safeLog('error', 'Rate limit API returned HTTP ' . $httpCode . ': ' . substr($response, 0, 500));
                return null;
            }
            
            // Parse response
            $data = json_decode($response, true);
            if (json_last_error() !== JSON_ERROR_NONE) {
                $this->safeLog('error', 'JSON decode error in getRateLimitInfo: ' . json_last_error_msg());
                return null;
            }
            
            return $data;
            
        } catch (\Exception $e) {
            $this->safeLog('error', 'Exception in getRateLimitInfo: ' . $e->getMessage());
            return null;
        }
    }
}


