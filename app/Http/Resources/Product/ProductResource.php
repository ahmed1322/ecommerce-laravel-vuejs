<?php

namespace App\Http\Resources\Product;

use App\Http\Resources\Seller\SellerResource;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'price' => $this->price,
            'color' => $this->color,
            'size' => $this->size,
            'stock_quantity' => $this->stock_quantity,
            'availability' => $this->availability,
            'product_cover' => $this->getMedia('product_cover')->first() ? $this->getMedia('product_cover')->first()->getUrl() : NULL,
            'product_gallery' => $this->getMedia('product_gallery')
                                    ->map( function( $product_image ) {
                                        return $product_image->getUrl();
                                    }),
            'edit_route' => route('seller.products.edit', $this->id),
            'delete_route' => route('api.products.destroy', $this->id),
            'update_route' => route('api.products.update', $this->id),
            'seller' => [
                'name' => $this->seller->name,
            ]
        ];
    }
}
