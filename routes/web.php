<?php
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;

Route::get('/', function () {
    return view('home');
});

// Product routes
Route::get('/products/create', [ProductController::class, 'create'])->name('products.create'); // go to create product form page
Route::get('/products/{id}/edit', [ProductController::class, 'edit'])->name('products.edit'); // go to edit product form page
Route::patch('/products/{id}', [ProductController::class, 'update'])->name('products.update');
Route::post('/products', [ProductController::class, 'store'])->name('products.store'); // handle form submission
Route::get('/', [ProductController::class, 'index'])->name(name: 'home'); // home page showing products

// Cart routes
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add/{id}', [CartController::class, 'add'])->name('cart.add');
Route::post('/cart/{id}/updateQty', [CartController::class, 'updateQty'])->name('cart.updateQty');
Route::post('/cart/{id}/remove', [CartController::class, 'remove'])->name('cart.remove');
Route::get('/cart/clear', [CartController::class, 'clearCart'])->name('cart.clear');

// Dynamic cart items count route
Route::get('/cart/count', function () {
    $cart = session()->get('cart', []);
    $count = 0;

    if (!empty($cart)) {
        $count = array_sum(array_column($cart, 'quantity'));
    }

    return response()->json(['count' => $count]);
});


// Order routes
Route::post('/cart/place-order', [OrderController::class, 'placeOrder'])->name('cart.placeOrder');
Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
Route::patch('/orders/{order}/status', [OrderController::class, 'updateStatus'])->name('orders.updateStatus');
