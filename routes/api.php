<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::post( '/products/upload/{product}' , [ App\Http\Controllers\Api\v1\ProductController::class, 'upload' ] )
->name('api.products.images.upload');
Route::apiResource('/products', ProductController::class);
// Route::get('/products/{productId}', [App\Http\Controllers\Api\v1\ProductController::class, 'singleProduct'])->name('products.single');
