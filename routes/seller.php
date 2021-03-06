<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register Seller routes for the application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "seller" middleware group. Now create something great!
|
*/

Route::resource('/products', ProductController::class );
Route::resource('/statistics', StatisticController::class );
