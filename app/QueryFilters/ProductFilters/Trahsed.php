<?php

namespace App\QueryFilters\ProductFilters;


class Trahsed extends Filter
{
    protected function applyFilter( $builder )
    {
        return $builder->onlyTrashed();
    }
}
