<?php

namespace App\QueryFilters\ProductFilters;

use Illuminate\Support\Str;

class Sales extends Filter
{
    protected function applyFilter( $builder )
    {
        $request = Str::camel( request( 'sales' ) );

        return $this->$request($builder);
    }

    protected function onlyHasSales($builder)
    {
        return $builder->leftJoin('sales', 'products.id', '=', 'sales.product_id')
                    ->select('products.*')
                    ->groupBy('products.id')
                    ->havingRaw('COUNT( sales.product_id ) > 0')
                    ->orderByRaw( 'COUNT( sales.product_id ) desc' );
    }

    protected function hasNoSales($builder)
    {
        return $builder->leftJoin('sales', 'products.id', '=', 'sales.product_id')
                    ->select('products.*')
                    ->groupBy('products.id')
                    ->havingRaw('COUNT( sales.product_id ) = 0');
    }

}
