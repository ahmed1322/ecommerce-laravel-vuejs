<?php

namespace App\Traits\Collection;

use Illuminate\Database\Eloquent\Builder;

trait MultTitenanable
{
    public static function bootMultTitenanable()
    {
        static::addGlobalScope('created_by_user', function (Builder $builder) {
            $builder->where('created_by_user', auth()->id());
        });
    }
}
