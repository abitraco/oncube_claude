<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Static HTML pages - serve directly
Route::get('/', function () {
    return view('home');
});

Route::get('/home', function () {
    return view('home');
})->name('home');

Route::get('/shop', [App\Http\Controllers\EbayController::class, 'shop'])->name('shop');

Route::get('/about', function () {
    return view('about');
})->name('about');

Route::get('/contact', function () {
    return view('contact');
})->name('contact');

// Health check for Render
Route::get('/health', function () {
    return response()->json([
        'status' => 'ok',
        'timestamp' => now()->toIso8601String()
    ], 200);
});

// Legacy HTML routes (redirect to new routes)
Route::get('/home.html', function () {
    return redirect()->route('home');
});

Route::get('/shop.html', function () {
    return redirect()->route('shop');
});

Route::get('/about.html', function () {
    return redirect()->route('about');
});

Route::get('/contact.html', function () {
    return redirect()->route('contact');
});

// eBay API routes
Route::get('/api/ebay/search', [App\Http\Controllers\EbayController::class, 'searchAjax'])->name('ebay.search');
Route::get('/api/ebay/item/{itemId}', [App\Http\Controllers\EbayController::class, 'itemDetails'])->name('ebay.item');
