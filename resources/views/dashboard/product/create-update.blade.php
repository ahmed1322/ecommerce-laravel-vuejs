@extends('layouts.dashboard')

@section('styles')
@endsection

@section('dashboard')
    {{-- @dump($product->getMedia('product_images')) --}}
    <create-update-product
        product_route={{ route('api.products.show', $product->id) }}
        update_product_route={{ route('api.products.update', $product->id) }}
        ></seller-products>
@endsection

