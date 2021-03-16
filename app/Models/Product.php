<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use App\Traits\Collection\MultTitenanable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
class Product extends Model implements HasMedia
{
    use HasFactory, MultTitenanable, InteractsWithMedia;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        "name",
        "created_by_user",
        'price',
        "color",
        "size",
        "stock_quantity",
        "availability"
    ];


    /**
     * Get the User that owns the Product.
     */
    public function seller()
    {
        return $this->belongsTo(Seller::class, 'created_by_user');
    }

    /**
     * Scope a query to only include availabile Products.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeAvailable($query, bool $availabile = true)
    {
        return $query->where('availability', true );
    }
}
