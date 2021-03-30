<?php

namespace App\QueryFilters\ProductFilters;

class Category extends Filter
{
protected function applyFilter( $builder )
    {
        return $builder->Join('categorables', 'products.id', '=', 'categorables.categorables_id')
            ->join('categories', function ($join) {
                if ( request( $this->filterName() ) != 'all'  ){
                    $join->on('categories.id', '=', 'categorables.category_id')
                    ->where('categorables.category_id', '=', request( $this->filterName() ) );
                }else{
                    $join->on('categories.id', '=', 'categorables.category_id');
                }
            })
            ->select('products.*')
            ->groupBy('products.id');
    }

}
