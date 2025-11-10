<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Detect locale from IP and redirect to localized home
Route::get('/', function () {
    $locale = detectUserLocale();
    return redirect()->route('home', ['locale' => $locale]);
});

// Health check for Render
Route::get('/health', function () {
    return response()->json([
        'status' => 'ok',
        'timestamp' => now()->toIso8601String()
    ], 200);
});

// Localized routes
Route::group(['prefix' => '{locale}', 'where' => ['locale' => 'en|ko|ja|zh'], 'middleware' => 'setlocale'], function () {

    Route::get('/home', function () {
        return view('home');
    })->name('home');

    Route::get('/shop', [App\Http\Controllers\EbayController::class, 'shop'])->name('shop');
    Route::get('/shop/motors', [App\Http\Controllers\EbayController::class, 'shopMotors'])->name('shop.motors');

    Route::get('/about', function () {
        return view('about');
    })->name('about');

    Route::get('/contact', function () {
        return view('contact');
    })->name('contact');

});

// Legacy routes - redirect to localized versions
Route::get('/home', function () {
    $locale = detectUserLocale();
    return redirect()->route('home', ['locale' => $locale]);
});

Route::get('/shop', function () {
    $locale = detectUserLocale();
    return redirect()->route('shop', ['locale' => $locale]);
});

Route::get('/about', function () {
    $locale = detectUserLocale();
    return redirect()->route('about', ['locale' => $locale]);
});

Route::get('/contact', function () {
    $locale = detectUserLocale();
    return redirect()->route('contact', ['locale' => $locale]);
});

// Legacy HTML routes (redirect to new routes)
Route::get('/home.html', function () {
    $locale = detectUserLocale();
    return redirect()->route('home', ['locale' => $locale]);
});

Route::get('/shop.html', function () {
    $locale = detectUserLocale();
    return redirect()->route('shop', ['locale' => $locale]);
});

Route::get('/about.html', function () {
    $locale = detectUserLocale();
    return redirect()->route('about', ['locale' => $locale]);
});

Route::get('/contact.html', function () {
    $locale = detectUserLocale();
    return redirect()->route('contact', ['locale' => $locale]);
});

// eBay API routes
Route::get('/api/ebay/search', [App\Http\Controllers\EbayController::class, 'searchAjax'])->name('ebay.search');
Route::get('/api/ebay/item/{itemId}', [App\Http\Controllers\EbayController::class, 'itemDetails'])->name('ebay.item');
Route::post('/api/ebay/clear-cache', [App\Http\Controllers\EbayController::class, 'clearCache'])->name('ebay.clearCache');
