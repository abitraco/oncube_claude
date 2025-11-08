<?php 

// Global variables not used by createBasicOauthToken, so removed.

function createBasicOauthToken($clientID = null, $certID = null) {     
    // $oauth_basictokenfile was unused for writing here, token is returned.

    try {
        // Use provided credentials or fall back to environment variables
        if ($clientID && $certID) {
            $credentials['client_id'] = $clientID;
            $credentials['client_secret'] = $certID;
        } else {
            // Use environment variables for credentials
            $credentials['client_id'] = getenv('EBAY_CLIENT_ID') ?: 'your-client-id-here';
            $credentials['client_secret'] = getenv('EBAY_CLIENT_SECRET') ?: 'your-client-secret-here';
        }


        $link = "https://api.ebay.com/identity/v1/oauth2/token";
        $codeAuth = base64_encode($credentials['client_id'] . ':' . $credentials['client_secret']);

        $ch = curl_init($link);
        curl_setopt_array($ch, [
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/x-www-form-urlencoded',
                'Authorization: Basic ' . $codeAuth
            ],
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYPEER => true, // Should be true in production
            CURLOPT_SSL_VERIFYHOST => 2,    // Should be 2 in production
            CURLOPT_POST => 1,
            CURLOPT_POSTFIELDS => "grant_type=client_credentials&scope=https://api.ebay.com/oauth/api_scope",
            CURLOPT_TIMEOUT => 30
        ]);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);
        curl_close($ch);

        if ($error) {
            error_log("cURL error in createBasicOauthToken: " . $error);
            throw new \RuntimeException('cURL error while generating OAuth token: ' . $error);
        }

        if ($httpCode !== 200) {
            error_log("HTTP error {$httpCode} in createBasicOauthToken: " . $response);
            throw new \RuntimeException('HTTP error while generating OAuth token: ' . $httpCode . ' - Response: ' . $response);
        }

        $responseData = json_decode($response, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            error_log("JSON decode error in createBasicOauthToken: " . json_last_error_msg() . " - Response: " . $response);
            throw new \RuntimeException('Failed to decode JSON response for OAuth token: ' . json_last_error_msg());
        }

        if (isset($responseData['access_token'])) {
            // The local $tokenData array and $oauth_basictokenfile checks were not used
            // for the function's primary purpose of returning the token string.
            // The caller (Ajax.php) handles saving the token to 'token_info.txt'.
            return $responseData['access_token'];
        } else {
            throw new \RuntimeException('Failed to generate OAuth token: ' . $response);
        }
    } catch (\Exception $e) {
        error_log('Token generation error: ' . $e->getMessage());
        throw $e;
    }
}


?>