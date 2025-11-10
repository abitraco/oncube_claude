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

        // Get user's country from IP
        $userIp = request()->ip();

        // For localhost/development, default to 'en'
        if ($userIp === '127.0.0.1' || $userIp === '::1') {
            return 'en';
        }

        try {
            // Use ip-api.com for geolocation (free, no API key needed)
            $response = @file_get_contents("http://ip-api.com/json/{$userIp}");

            if ($response) {
                $data = json_decode($response);

                if ($data && isset($data->countryCode)) {
                    $countryCode = $data->countryCode;

                    // Map country codes to locales
                    $localeMap = [
                        'KR' => 'ko',  // South Korea
                        'JP' => 'ja',  // Japan
                        'CN' => 'zh',  // China
                        'TW' => 'zh',  // Taiwan
                        'HK' => 'zh',  // Hong Kong
                    ];

                    return $localeMap[$countryCode] ?? 'en';
                }
            }
        } catch (\Exception $e) {
            // If geolocation fails, default to English
            \Log::error('Locale detection error: ' . $e->getMessage());
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
