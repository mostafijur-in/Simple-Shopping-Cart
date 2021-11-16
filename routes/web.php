<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
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

// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes();

Route::get('/', [HomeController::class, 'index'])->name('home');

// Product routes
Route::resource('products', ProductController::class);

// Cart routes
Route::get('cart', [ProductController::class, 'cart'])->name('cart');
Route::post('cart/add', [ProductController::class, 'addToCart'])->name('cart.add');
Route::patch('cart/update', [ProductController::class, 'updateCart'])->name('cart.update');
Route::delete('cart/remove', [ProductController::class, 'removeFromCart'])->name('cart.remove');
