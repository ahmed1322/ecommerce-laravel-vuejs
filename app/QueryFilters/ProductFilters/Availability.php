<?php

namespace App\QueryFilters\ProductFilters;

use Closure;

class Availability extends Filter
{

    protected function applyFilter( $builder )
    {
        return $builder->where( $this->filterName() , request( $this->filterName() ) );
    }


}
