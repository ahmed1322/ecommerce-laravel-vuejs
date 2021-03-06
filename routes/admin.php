<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register Admin routes for the application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "Admin" middleware group. Now create something great!
|
*/

Route::resource('/statistics', StatisticController::class );
Route::resource('/categories', CategoryController::class );
Route::resource('/tags', TagController::class );
Route::resource('/posts', PostController::class );
