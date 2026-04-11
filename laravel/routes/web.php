<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LinkController;

Route::get('/', function () {
    return view('welcome');
})->name('welcome');
/*
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');
*/
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

//Route::post('/test', [LinkController::class, 'test'])->name('product.unlock');
//Route::post('/test', [LinkController::class, 'handleSearch'])->name('product.unlock'); // OG
//Route::post('/process-link', [LinkController::class, 'test']);
/*
Route::get('/test', function () {
    return view('product-result');
})->name('product.unlock');
*/
Route::get('/mock/products', function () {
    return response()->json([
        'products' => [
            [
                'id' => 1,
                'title' => 'Wireless Headphones',
                'price_usd' => 25.5,
                'image' => '/images/demo1.jpg'
            ],
            [
                'id' => 2,
                'title' => 'Gaming Mouse',
                'price_usd' => 12.9,
                'image' => '/images/demo2.jpg'
            ]
        ]
    ]);
});

require __DIR__.'/auth.php';

use App\Http\Controllers\OrderController;

Route::post('/orders', [OrderController::class, 'store'])
    ->middleware('auth')
    ->name('orders.store');

Route::get('/orders/{order}/payment', 
    [OrderController::class, 'payment'])
    ->middleware('auth')
    ->name('orders.payment');

use App\Http\Controllers\ChargilyPayController;

Route::post('chargilypay/redirect', [ChargilyPayController::class, "redirect"])->name("chargilypay.redirect");
Route::get('chargilypay/back', [ChargilyPayController::class, "back"])->name("chargilypay.back");
Route::post('chargilypay/webhook', [ChargilyPayController::class, "webhook"])->name("chargilypay.webhook_endpoint");

use App\Http\Controllers\ProductController;
/*
Route::get('/product/unlocked', [ProductController::class, 'showFirstProduct'])->name('product.unlock');
*/
use App\Http\Controllers\ExtractorController;

Route::post('/fetch-product', [ExtractorController::class, 'fetch'])->name('fetch.product');

Route::post('/request', [ProductController::class, 'store'])
    ->middleware('auth')
    ->name('request.store');

Route::get('/request/{id}/waiting', function ($id) {
    $request = \App\Models\Product::findOrFail($id);
    if($request->user_id !== auth()->id()){
        abort(403);
    }
    return view('waiting', compact('request'));
})->middleware('auth')
->name('request.waiting');

// Admin middleware for security
Route::middleware(['auth', 'is_admin'])->group(function () {
    Route::get('/admin/requests', [ProductController::class, 'adminIndex'])->name('admin.requests');
    Route::get('/admin/request/{id}', [ProductController::class, 'adminShow'])->name('admin.request.show');
    Route::post('/admin/request/{id}/update', [ProductController::class, 'adminUpdate'])->name('admin.request.update');
});

Route::get('/request/{id}/status', function($id) {
    $request = \App\Models\Product::findOrFail($id);
    return response()->json(['status' => $request->status]);
});

Route::get('/request/{id}/view', function ($id) {
    $product = \App\Models\Product::findOrFail($id);
    if ($product->status !== 'priced') {
        return redirect()->route('request.waiting', $id);
    }
    return view('request-view', compact('product'));
});

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [OrderController::class, 'index'])
        ->name('dashboard');
});

Route::get('/orders/create', function () {
    return redirect()->route('welcome');
})->name('orders.create');

use App\Http\Controllers\CheckoutController;

Route::post(
    '/checkout/{order}',
    [CheckoutController::class, 'process']
)->middleware('auth')->name('checkout.process');

Route::post('/orders/{order}/cancel', [OrderController::class, 'cancel'])
    ->name('orders.cancel')
    ->middleware('auth');