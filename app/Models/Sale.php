<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'product_id',
        'sale_price',
        'was_on_sale',
    ];

    /**
     * Get the product that owns the sales.
     */
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
