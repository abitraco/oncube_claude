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

// Admin routes
Route::get('/admin', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('admin.dashboard');
Route::post('/admin', [App\Http\Controllers\Admin\DashboardController::class, 'index']);
Route::get('/admin/quotes', [App\Http\Controllers\Admin\QuoteRequestAdminController::class, 'index'])->name('admin.quotes');
Route::post('/admin/quotes', [App\Http\Controllers\Admin\QuoteRequestAdminController::class, 'index']);
Route::get('/admin/logout', [App\Http\Controllers\Admin\QuoteRequestAdminController::class, 'logout'])->name('admin.logout');

// Admin Quote Builder routes
Route::get('/admin/quotes/{id}/builder', [App\Http\Controllers\Admin\QuoteBuilderController::class, 'builder'])->name('admin.quote.builder');
Route::post('/admin/quotes/{id}/builder', [App\Http\Controllers\Admin\QuoteBuilderController::class, 'saveQuote'])->name('admin.quote.save');
Route::get('/admin/quotes/{id}/review', [App\Http\Controllers\Admin\QuoteBuilderController::class, 'review'])->name('admin.quote.review');
Route::post('/admin/quotes/{id}/generate-pdf', [App\Http\Controllers\Admin\QuoteBuilderController::class, 'generatePdf'])->name('admin.quote.generate-pdf');
Route::post('/admin/quotes/{id}/send', [App\Http\Controllers\Admin\QuoteBuilderController::class, 'send'])->name('admin.quote.send');

// Admin Featured Products routes
Route::get('/admin/featured-products', [App\Http\Controllers\Admin\FeaturedProductController::class, 'index'])->name('admin.featured-products');
Route::post('/admin/featured-products', [App\Http\Controllers\Admin\FeaturedProductController::class, 'index']);
Route::post('/admin/featured-products/store', [App\Http\Controllers\Admin\FeaturedProductController::class, 'store'])->name('admin.featured-products.store');
Route::post('/admin/featured-products/{id}/duplicate', [App\Http\Controllers\Admin\FeaturedProductController::class, 'duplicate'])->name('admin.featured-products.duplicate');
Route::put('/admin/featured-products/{id}', [App\Http\Controllers\Admin\FeaturedProductController::class, 'update'])->name('admin.featured-products.update');
Route::delete('/admin/featured-products/{id}', [App\Http\Controllers\Admin\FeaturedProductController::class, 'destroy'])->name('admin.featured-products.destroy');

// Admin Login Page
Route::get('/admin/login', function () {
    $redirect = request()->query('redirect', 'quotes');
    return view('admin.login', compact('redirect'));
})->name('admin.login');

// Localized routes
Route::group(['prefix' => '{locale}', 'where' => ['locale' => 'en|ko|ja|zh'], 'middleware' => 'setlocale'], function () {

    Route::get('/home', function () {
        $featuredProducts = \App\FeaturedProduct::where('is_active', true)
            ->orderBy('order')
            ->limit(6)
            ->get();
        return view('home', compact('featuredProducts'));
    })->name('home');

    Route::get('/request-quote', function () {
        return view('request-quote');
    })->name('request-quote');
    
    Route::post('/request-quote', [App\Http\Controllers\QuoteRequestController::class, 'store'])->name('request-quote.store');

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
