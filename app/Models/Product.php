<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        "name",
        "seller_id",
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
        return $this->belongsTo(Seller::class);
        // return $this->belongsTo(Seller::class, 'products');
    }
}
