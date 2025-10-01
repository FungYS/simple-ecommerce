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
Route::post('/products', [ProductController::class, 'store'])->name('products.store'); // handle form submission
Route::get('/', [ProductController::class, 'index'])->name(name: 'home'); // home page showing products

// Cart routes
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add/{id}', [CartController::class, 'add'])->name('cart.add');
Route::get('/cart/clear', [CartController::class, 'clearCart'])->name('cart.clear');
// Route::get('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove'); --- IGNORE ---

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
