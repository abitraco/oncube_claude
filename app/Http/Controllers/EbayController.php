<?php

namespace App\Http\Controllers;

use App\Libraries\EbayUtil;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class EbayController extends Controller
{
    protected $ebayUtil;

    public function __construct()
    {
        $this->ebayUtil = new EbayUtil();
    }

    /**
     * Display shop page with eBay products
     */
    public function shop(Request $request)
    {
        try {
            // Get search parameters from request
            $searchData = [
                'keywords' => $request->input('keywords', ''),
                'categoryId' => $request->input('categoryId', ''),
                'perpage' => $request->input('perpage', 48),
                'pageNumber' => $request->input('page', 1),
                'sortOrder' => $request->input('sortOrder', 'BestMatch'),
                'itemFilter' => $request->input('itemFilter', ''),
                'aspectFilter' => $request->input('aspectFilter', ''),
                'ListingType' => $request->input('ListingType', 'All')
            ];

            // Get items from eBay API
            $result = $this->ebayUtil->getItemSummary($searchData);

            // Prepare data for view
            $items = [];
            $total = 0;
            $hasError = false;
            $errorMessage = '';

            if ($result && isset($result->itemSummaries)) {
                $items = $result->itemSummaries;
                $total = $result->total ?? 0;
            } elseif ($result && isset($result->errors)) {
                $hasError = true;
                $errorMessage = is_array($result->errors)
                    ? implode(', ', array_map(fn($e) => $e->message ?? 'Unknown error', $result->errors))
                    : 'API Error';
            }

            return view('shop', [
                'items' => $items,
                'total' => $total,
                'currentPage' => $searchData['pageNumber'],
                'perPage' => $searchData['perpage'],
                'keywords' => $searchData['keywords'],
                'sortOrder' => $searchData['sortOrder'],
                'hasError' => $hasError,
                'errorMessage' => $errorMessage
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
                'hasError' => true,
                'errorMessage' => 'An error occurred while loading products'
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
}
