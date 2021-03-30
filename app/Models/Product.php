<?php

namespace App\Models;

use Spatie\Image\Manipulations;
use Illuminate\Pipeline\Pipeline;
use Spatie\MediaLibrary\HasMedia;
use App\Observers\ProductObserver;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use App\Traits\Collection\MultTitenanable;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Product extends Model implements HasMedia
{
    use HasFactory, SoftDeletes, MultTitenanable, InteractsWithMedia;
    // Spatie\Image\
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

    protected $appends = [
        'photo'
    ];

    /**
     * The event map for the model.
     *
     * @var array
     */
    protected $dispatchesEvents = [
        'saved' => ProductObserver::class,
    ];

    /**
     * The relationships that should always be loaded.
     *
     * @var array
     */
    protected $with = ['media', 'categories', 'sales' ];

    /**
     * Get all of the Salles for the Product.
     */
    public function sales()
    {
        return $this->hasMany(Sale::class, 'product_id');
    }

    /**
     * Get all of the tags for the post.
     */
    public function categories()
    {
        return $this->morphToMany(Category::class, 'categorables');
    }

    public function categoriesName()
    {
        return $this->categories->implode('name', ', ');
    }

    /**
     * Get all of the tags for the post.
     */
    public function categoriesIDS()
    {
        return $this->categories->pluck('id')->toArray();
    }

    /**
     * Get all of the tags for the post.
     */
    public function category( $category_id )
    {
        return $this->categories->where('category_id', $category_id );
    }


    /**
     * Add Product Cover sizes [ 50x50, 150x150, 300x300, 600x600 ]
     *
     */
    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb-50x50')
              ->width(50)
              ->height(50);

        $this->addMediaConversion('medium-150x150')
              ->width(150)
              ->height(150);

        $this->addMediaConversion('medium-300x300')
              ->width(150)
              ->height(150);

        $this->addMediaConversion('medium-600x600')
              ->width(600)
              ->height(600);
    }

    public function getPhotoAttribute()
    {
        $file = $this->getMedia('products')->last();

        if( $file ){
            $file->cover = $file->getUrl();
            $file->thumb = $file->getUrl('thumb-50x50');
            $file->preview = $file->getUrl('medium-150x150');
            $file->main = $file->getUrl('medium-300x300');
            // $file->cover = $file->getUrl('medium-600x600');
        }

        return $file;
    }

    public static function addPrductCoverMedia( $product )
    {
        $product->addMediaFromRequest('product_cover')->toMediaCollection('products');
    }


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
    public function scopeAvailableOnly($query, bool $availabile = true)
    {
        return $query->where('availability', true );
    }

     /**
     * Scope a query to only include availabile Products.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOrderByStockQuantity($query)
    {
        return $query->orderBy( 'stock_quantity', 'desc' );

    }

    /**
     * Get the Product availability status
     *
     * @param  string  $value
     * @return string
     */
    public function isAvailabile()
    {
        return $this->availability === 'Available' ?? false;
    }

    /**
     * Get the Product availability status
     *
     * @param  string  $value
     * @return string
     */
    public function getAvailabilityAttribute($value)
    {
        return $value ? 'Available' : 'Not Availabile';
    }

    public static function withFilteration()
    {
        return  app( Pipeline::class )
                ->send( Product::query() )
                ->through( [
                   \App\QueryFilters\ProductFilters\Availability::class,
                   \App\QueryFilters\ProductFilters\Category::class,
                   \App\QueryFilters\ProductFilters\Sales::class,
                   \App\QueryFilters\ProductFilters\Trahsed::class,
                ])
                ->thenReturn()
                ->paginate( (int) request( 'limit' ))
                ->withQueryString();
    }

}
