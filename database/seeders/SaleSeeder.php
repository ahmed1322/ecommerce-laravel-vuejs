<?php

namespace Database\Seeders;

use App\Models\Sale;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;

class SaleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        // $products = ( new Product )->find(100);
        // // $products = ( new Product )->categories()->whereNull('categorables.categorables_id')->count();
        // // return $this->roles()->whereIn( 'name' , $list_of_roles )->count();

        $products = \DB::table('products')
            ->leftJoin('categorables', 'products.id', '=', 'categorables.categorables_id')
            ->leftJoin('sales', 'products.id', '=', 'sales.product_id')
            ->whereNull('categorables.categorables_id')
            ->select('products.*', \DB::raw('COUNT( sales.product_id ) as sales_count'))
            ->groupBy('products.id')
            ->havingRaw('COUNT( sales.product_id ) = 0')
            ->get();

        $products->map( function($product){
            dd( Product::where( 'id', $product->id )->get() );
            dd( $product->id );

        });


        $categories = \DB::table('categories')->get()->random( 2 )->pluck('id')->toArray();

        // Sale::factory()
        //     ->count(500)
        //     ->create();
    }
}
