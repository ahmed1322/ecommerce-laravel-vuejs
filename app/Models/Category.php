<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    /**
     * Get all of the posts that are assigned this tag.
     */
    public function products()
    {
        return $this->morphedByMany(Product::class, 'categorables');
    }

    /**
     * Get the parent commentable model (post or video).
     */
    // public function categorable()
    // {
    //     return $this->morphTo();
    // }

}
