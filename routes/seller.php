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

Route::post('/products/trash/bulk', [ \App\Http\Controllers\Seller\ProductController::class , 'trashBulk' ] )->name('products.trash.bulk');
Route::post('/products/trash/restore', [ \App\Http\Controllers\Seller\ProductController::class , 'trashRestore' ] )->name('products.trash.restore');
Route::post('/products/destroy/all', [ \App\Http\Controllers\Seller\ProductController::class , 'destroyAll' ] )->name('products.destroy.all');

Route::get('/products/filter', [ \App\Http\Controllers\Seller\ProductController::class , 'filter' ] )->name('products.filter');
Route::resource('/products', ProductController::class );

Route::resource('/statistics', StatisticController::class );
