<?php

namespace App\Http\Controllers;

use App\Libraries\EbayUtil;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

class EbayController extends Controller
{
    protected $ebayUtil;

    // Cache duration in seconds (1 hour = 3600, 24 hours = 86400)
    // Disabled on localhost for development
    protected $cacheDuration;

    public function __construct()
    {
        $this->ebayUtil = new EbayUtil();
        
        // Disable cache on localhost/local development
        $this->cacheDuration = config('app.env') === 'local' ? 0 : 3600;
    }

    /**
     * Generate cache key based on search parameters
     */
    private function getCacheKey(array $searchData): string
    {
        // Create a unique cache key based on search parameters
        $keyParts = [
            'ebay_search',
            $searchData['categoryId'] ?? 'all',
            $searchData['keywords'] ?? 'none',
            $searchData['pageNumber'] ?? 1,
            $searchData['perpage'] ?? 48,
            $searchData['sortOrder'] ?? 'BestMatch',
            $searchData['itemFilter'] ?? 'none',
        ];

        return implode('_', array_map(function($part) {
            // Sanitize the part to make it a valid cache key
            return preg_replace('/[^a-zA-Z0-9_-]/', '', str_replace(' ', '_', $part));
        }, $keyParts));
    }

    /**
     * Display shop page with eBay products
     */
    public function shop(Request $request)
    {
        try {
            // Get search parameters from request
            // Default to Business & Industrial category (12576) if no category specified
            $searchData = [
                'keywords' => $request->input('keywords', ''),
                'categoryId' => $request->input('categoryId', '12576'),
                'perpage' => $request->input('perpage', 48),
                'pageNumber' => $request->input('page', 1),
                'sortOrder' => $request->input('sortOrder', 'BestMatch'),
                'itemFilter' => $request->input('itemFilter', ''),
                'aspectFilter' => $request->input('aspectFilter', ''),
                'ListingType' => $request->input('ListingType', 'All')
            ];

            // If no keywords provided and using default category, show search page only
            // Allow category browsing when specific categoryId is provided
            if (empty($searchData['keywords']) && $searchData['categoryId'] === '12576') {
                return view('shop', [
                    'items' => [],
                    'total' => 0,
                    'currentPage' => 1,
                    'perPage' => 48,
                    'keywords' => '',
                    'sortOrder' => 'BestMatch',
                    'categoryName' => null,
                    'categoryDistributions' => [],
                    'currentCategoryId' => $searchData['categoryId'],
                    'hasError' => false,
                    'errorMessage' => '',
                    'isCached' => false,
                    'showSearchOnly' => true
                ]);
            }

            // Generate cache key
            $cacheKey = $this->getCacheKey($searchData);

            // Check if data is in cache
            $isCached = Cache::has($cacheKey);

            // Try to get cached result first
            $result = Cache::remember($cacheKey, $this->cacheDuration, function () use ($searchData) {
                // If not in cache or expired, fetch from eBay API
                Log::info('Fetching fresh data from eBay API for: ' . json_encode($searchData));
                return $this->ebayUtil->getItemSummary($searchData);
            });

            // Log cache status
            if ($isCached) {
                Log::info('Serving cached data for: ' . $cacheKey);
            } else {
                Log::info('Fetched and cached fresh data for: ' . $cacheKey);
            }

            // Prepare data for view
            $items = [];
            $total = 0;
            $categoryName = null;
            $categoryDistributions = [];
            $hasError = false;
            $errorMessage = '';

            if ($result && isset($result->itemSummaries)) {
                $items = $result->itemSummaries;
                $total = $result->total ?? 0;
                // Extract category data from refinement
                if (isset($result->refinement->categoryDistributions)) {
                    $categoryDistributions = $result->refinement->categoryDistributions;
                    // Get the first category name as the current category
                    if (count($categoryDistributions) > 0) {
                        $categoryName = $categoryDistributions[0]->categoryName ?? null;
                    }
                }
            } elseif ($result && isset($result->errors)) {
                $hasError = true;
                // Check for rate limit error specifically
                $isRateLimit = false;
                foreach ($result->errors as $error) {
                    if (isset($error->errorId) && $error->errorId === 2001) {
                        $isRateLimit = true;
                        break;
                    }
                }

                if ($isRateLimit) {
                    $errorMessage = 'eBay API rate limit reached. Products will be available again soon. Please check back in a few hours.';
                } else {
                    $errorMessage = is_array($result->errors)
                        ? implode(', ', array_map(fn($e) => $e->message ?? 'Unknown error', $result->errors))
                        : 'API Error';
                }
            } elseif (!$result) {
                // If result is null, it's likely a rate limit or connection error
                $hasError = true;
                $errorMessage = 'Unable to load products at this time. The eBay API may have reached its rate limit. Please try again later.';
            }

            return view('shop', [
                'items' => $items,
                'total' => $total,
                'currentPage' => $searchData['pageNumber'],
                'perPage' => $searchData['perpage'],
                'keywords' => $searchData['keywords'],
                'sortOrder' => $searchData['sortOrder'],
                'categoryName' => $categoryName,
                'categoryDistributions' => $categoryDistributions,
                'currentCategoryId' => $searchData['categoryId'],
                'hasError' => $hasError,
                'errorMessage' => $errorMessage,
                'isCached' => $isCached, // Show cache status in debug mode
                'showSearchOnly' => false
            ]);

        } catch (\Exception $e) {
            Log::error('eBay shop error: ' . $e->getMessage());

            return view('shop', [
                'items' => [],
                'total' => 0,
                'currentPage' => 1,
                'perPage' => 48,
                'keywords' => '',
                'sortOrder' => 'BestMatch',
                'categoryName' => null,
                'categoryDistributions' => [],
                'currentCategoryId' => '12576',
                'hasError' => true,
                'errorMessage' => 'An error occurred while loading products',
                'showSearchOnly' => false
            ]);
        }
    }

    /**
     * Display shop motors page with eBay Motors products
     */
    public function shopMotors(Request $request)
    {
        try {
            // Get search parameters from request
            // Default to eBay Motors Car & Truck Parts category (33615)
            $searchData = [
                'keywords' => $request->input('keywords', ''),
                'categoryId' => $request->input('categoryId', '6030'),
                'perpage' => $request->input('perpage', 48),
                'pageNumber' => $request->input('page', 1),
                'sortOrder' => $request->input('sortOrder', 'BestMatch'),
                'itemFilter' => $request->input('itemFilter', ''),
                'aspectFilter' => $request->input('aspectFilter', ''),
                'ListingType' => $request->input('ListingType', 'All'),
                'marketplace' => 'EBAY_MOTORS_US' // eBay Motors marketplace
            ];

            // If no keywords provided and using default category, show search page only
            // Allow category browsing when specific categoryId is provided
            if (empty($searchData['keywords']) && $searchData['categoryId'] === '6030') {
                return view('shop-motors', [
                    'items' => [],
                    'total' => 0,
                    'currentPage' => 1,
                    'perPage' => 48,
                    'keywords' => '',
                    'sortOrder' => 'BestMatch',
                    'categoryName' => null,
                    'categoryDistributions' => [],
                    'currentCategoryId' => $searchData['categoryId'],
                    'hasError' => false,
                    'errorMessage' => '',
                    'isCached' => false,
                    'showSearchOnly' => true
                ]);
            }

            // Generate cache key
            $cacheKey = $this->getCacheKey($searchData);

            // Check if data is in cache
            $isCached = Cache::has($cacheKey);

            // Try to get cached result first
            $result = Cache::remember($cacheKey, $this->cacheDuration, function () use ($searchData) {
                // If not in cache or expired, fetch from eBay API
                Log::info('Fetching fresh data from eBay Motors API for: ' . json_encode($searchData));
                return $this->ebayUtil->getItemSummary($searchData);
            });

            // Log cache status
            if ($isCached) {
                Log::info('Serving cached data for: ' . $cacheKey);
            } else {
                Log::info('Fetched and cached fresh data for: ' . $cacheKey);
            }

            // Prepare data for view
            $items = [];
            $total = 0;
            $categoryName = null;
            $categoryDistributions = [];
            $hasError = false;
            $errorMessage = '';

            if ($result && isset($result->itemSummaries)) {
                $items = $result->itemSummaries;
                $total = $result->total ?? 0;
                // Extract category data from refinement
                if (isset($result->refinement->categoryDistributions)) {
                    $categoryDistributions = $result->refinement->categoryDistributions;
                    // Get the first category name as the current category
                    if (count($categoryDistributions) > 0) {
                        $categoryName = $categoryDistributions[0]->categoryName ?? null;
                    }
                }
            } elseif ($result && isset($result->errors)) {
                $hasError = true;
                // Check for rate limit error specifically
                $isRateLimit = false;
                foreach ($result->errors as $error) {
                    if (isset($error->errorId) && $error->errorId === 2001) {
                        $isRateLimit = true;
                        break;
                    }
                }

                if ($isRateLimit) {
                    $errorMessage = 'eBay API rate limit reached. Products will be available again soon. Please check back in a few hours.';
                } else {
                    $errorMessage = is_array($result->errors)
                        ? implode(', ', array_map(fn($e) => $e->message ?? 'Unknown error', $result->errors))
                        : 'API Error';
                }
            } elseif (!$result) {
                $hasError = true;
                $errorMessage = 'Unable to load products at this time. The eBay API may have reached its rate limit. Please try again later.';
            }

            return view('shop-motors', [
                'items' => $items,
                'total' => $total,
                'currentPage' => $searchData['pageNumber'],
                'perPage' => $searchData['perpage'],
                'keywords' => $searchData['keywords'],
                'sortOrder' => $searchData['sortOrder'],
                'categoryName' => $categoryName,
                'categoryDistributions' => $categoryDistributions,
                'currentCategoryId' => $searchData['categoryId'],
                'hasError' => $hasError,
                'errorMessage' => $errorMessage,
                'isCached' => $isCached,
                'showSearchOnly' => false
            ]);

        } catch (\Exception $e) {
            Log::error('eBay shop motors error: ' . $e->getMessage());

            return view('shop-motors', [
                'items' => [],
                'total' => 0,
                'currentPage' => 1,
                'perPage' => 48,
                'keywords' => '',
                'sortOrder' => 'BestMatch',
                'categoryName' => null,
                'categoryDistributions' => [],
                'currentCategoryId' => '6030',
                'hasError' => true,
                'errorMessage' => 'An error occurred while loading products',
                'showSearchOnly' => false
            ]);
        }
    }

    /**
     * AJAX endpoint for search
     */
    public function searchAjax(Request $request)
    {
        try {
            $searchData = [
                'keywords' => $request->input('keywords', ''),
                'categoryId' => $request->input('categoryId', ''),
                'perpage' => $request->input('perpage', 15),
                'pageNumber' => $request->input('page', 1),
                'sortOrder' => $request->input('sortOrder', 'BestMatch'),
                'itemFilter' => $request->input('itemFilter', ''),
                'aspectFilter' => $request->input('aspectFilter', '')
            ];

            $result = $this->ebayUtil->getItemSummaryAjax($searchData);

            return response()->json([
                'success' => true,
                'data' => $result
            ]);

        } catch (\Exception $e) {
            Log::error('eBay search AJAX error: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Search failed'
            ], 500);
        }
    }

    /**
     * Get single item details
     */
    public function itemDetails($itemId)
    {
        try {
            $item = $this->ebayUtil->getSingleItemNew($itemId);

            if ($item && isset($item->error)) {
                return response()->json([
                    'success' => false,
                    'message' => $item->message ?? 'Item not found'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'data' => $item
            ]);

        } catch (\Exception $e) {
            Log::error('eBay item details error: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Failed to load item details'
            ], 500);
        }
    }

    /**
     * Clear all eBay product caches
     * Can be called manually or via scheduled task
     */
    public function clearCache()
    {
        try {
            // Clear all caches that start with 'ebay_search'
            Cache::flush(); // This clears all cache - use with caution

            // Alternative: Use cache tags if driver supports it (Redis, Memcached)
            // Cache::tags(['ebay_products'])->flush();

            return response()->json([
                'success' => true,
                'message' => 'eBay product cache cleared successfully'
            ]);

        } catch (\Exception $e) {
            Log::error('Cache clearing error: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Failed to clear cache'
            ], 500);
        }
    }
}
