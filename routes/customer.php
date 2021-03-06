<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register Cusotmor routes for the application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "Cusotmor" middleware group. Now create something great!
|
*/

Route::resource('/orders', OrderController::class );
Route::resource('/wishlist', WishlistController::class );
