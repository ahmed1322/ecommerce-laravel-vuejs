<?php

use App\Models\Product;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function() {

        $products = \DB::table('products')
        ->leftJoin('categorables', 'products.id', '=', 'categorables.categorables_id')
        ->leftJoin('sales', 'products.id', '=', 'sales.product_id')
        ->whereNull('categorables.categorables_id')
        ->select('products.*', \DB::raw('COUNT( sales.product_id ) as sales_count'))
        ->groupBy('products.id')
        ->havingRaw('COUNT( sales.product_id ) = 0')
        ->first();

        // dd( $products );

        $products->map( function($product){
            dd( Product::where( 'id', $product->id )->get() );
            print_r( $product->id );

        });


        $categories = \DB::table('categories')->get()->random( 2 )->pluck('id')->toArray();

    // return view('welcome');

})->name('home');

require __DIR__.'/auth.php';
