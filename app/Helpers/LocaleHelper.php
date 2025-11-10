<?php

if (!function_exists('detectUserLocale')) {
    /**
     * Detect user locale based on IP geolocation
     *
     * @return string
     */
    function detectUserLocale()
    {
        // Check session first
        if (session()->has('locale')) {
            return session('locale');
        }

        // Get user's real IP (considering proxies like Render)
        $userIp = request()->header('X-Forwarded-For') 
            ? explode(',', request()->header('X-Forwarded-For'))[0] 
            : request()->ip();

        // Clean the IP
        $userIp = trim($userIp);

        // For localhost/development or private IPs, try to detect anyway
        $isPrivateIp = filter_var(
            $userIp,
            FILTER_VALIDATE_IP,
            FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE
        ) === false;

        // If it's a private IP and we're in production, try the Accept-Language header
        if ($isPrivateIp && app()->environment('production')) {
            return detectFromBrowserLanguage();
        }

        try {
            // Use ip-api.com for geolocation (free, no API key needed)
            $response = @file_get_contents("http://ip-api.com/json/{$userIp}?fields=status,countryCode");

            if ($response) {
                $data = json_decode($response);

                if ($data && isset($data->countryCode) && $data->status === 'success') {
                    $countryCode = $data->countryCode;

                    // Map country codes to locales
                    $localeMap = [
                        'KR' => 'ko',  // South Korea
                        'JP' => 'ja',  // Japan
                        'CN' => 'zh',  // China
                        'TW' => 'zh',  // Taiwan
                        'HK' => 'zh',  // Hong Kong
                        'SG' => 'zh',  // Singapore (Chinese preference)
                    ];

                    if (isset($localeMap[$countryCode])) {
                        return $localeMap[$countryCode];
                    }
                }
            }
        } catch (\Exception $e) {
            // If geolocation fails, try browser language
            \Log::error('Locale detection error: ' . $e->getMessage());
        }

        // Fallback to browser language
        return detectFromBrowserLanguage();
    }
}

if (!function_exists('detectFromBrowserLanguage')) {
    /**
     * Detect locale from browser Accept-Language header
     *
     * @return string
     */
    function detectFromBrowserLanguage()
    {
        $acceptLanguage = request()->header('Accept-Language');
        
        if ($acceptLanguage) {
            // Parse Accept-Language header
            $languages = explode(',', $acceptLanguage);
            $primaryLang = strtolower(trim(explode(';', $languages[0])[0]));
            
            // Map language codes to our supported locales
            $langMap = [
                'ko' => 'ko',
                'ko-kr' => 'ko',
                'ja' => 'ja',
                'ja-jp' => 'ja',
                'zh' => 'zh',
                'zh-cn' => 'zh',
                'zh-tw' => 'zh',
                'zh-hk' => 'zh',
            ];
            
            // Check if we have a direct match
            if (isset($langMap[$primaryLang])) {
                return $langMap[$primaryLang];
            }
            
            // Check if the language code starts with our supported locales
            foreach (['ko', 'ja', 'zh'] as $locale) {
                if (str_starts_with($primaryLang, $locale)) {
                    return $locale;
                }
            }
        }
        
        return 'en'; // Default to English
    }
}

if (!function_exists('currentLocale')) {
    /**
     * Get current locale from route or app
     *
     * @return string
     */
    function currentLocale()
    {
        return request()->route('locale') ?? app()->getLocale();
    }
}
