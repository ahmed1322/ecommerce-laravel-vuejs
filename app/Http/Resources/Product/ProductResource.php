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
            'color' => $this->color,
            'size' => $this->size,
            'stock_quantity' => $this->stock_quantity,
            'availability' => $this->availability,
            'seller' => SellerResource::collection($this->seller),

            // 'seller_id' => $this->seller->id,
            // 'seller_name' => $this->seller->name
        ];
    }
}
