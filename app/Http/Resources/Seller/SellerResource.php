<?php

namespace App\Http\Resources\Seller;

use Illuminate\Support\Facades\Auth;
use App\Http\Resources\Product\ProductResource;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Product\ProductCollection;

class SellerResource extends JsonResource
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
            'products' => $this->when( ! Auth::user()->canAccessSpecificArea( [ 'seller' ] ), new ProductCollection( $this->products ) ),
            'products_count' => $this->products->count()
        ];
    }
}
