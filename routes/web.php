<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Redirect to login page
Route::get('/', function () {
    return redirect('login');
});

// Auth Routes
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'attemptLogin']);
Route::get('/register', [AuthController::class, 'register'])->name('register');
Route::post('/register', [AuthController::class, 'attemptRegister']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::post('/auth-ajax', [AuthController::class, 'ajax']);

Route::get('/', [HomeController::class, 'index'])->name('home');

// Product routes
Route::get('products/{id}', [ProductController::class, 'single_product'])->name('products.single');

// Cart routes
Route::get('cart', [OrderController::class, 'cart'])->name('cart');
Route::post('cart/add', [OrderController::class, 'addToCart'])->name('cart.add');
Route::patch('cart/update', [OrderController::class, 'updateCart'])->name('cart.update');
Route::delete('cart/remove', [OrderController::class, 'removeFromCart'])->name('cart.remove');

// Orders / checkout
Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    Route::get('checkout', [OrderController::class, 'checkout'])->name('checkout');

    // Admin routes
    Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => ['can:isAdmin']], function () {
        Route::get('/', [HomeController::class, 'admin_index'])->name('home');

        Route::resource('/products', ProductController::class);
        Route::resource('/orders', OrderController::class);
    });
});
