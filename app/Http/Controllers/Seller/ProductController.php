<?php

namespace App\Http\Controllers\Seller;

use Excption;
use App\Models\Seller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Support\Collection;
use App\Exceptions\NotProductOwner;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\Product\ProductCollection;
use App\QueryFilters\ProductFilters\Availability;
use App\Http\Requests\Seller\CreateProductRequest;
use App\Http\Requests\Seller\UpdateProductRequest;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view( 'dashboard.product.index', [
            'products' => Product::availableOnly()
                            ->orderByStockQuantity()
                            // ->get()
                            ->paginate(20)
                            ->withQueryString()
        ] );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view( 'dashboard.product.create' );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests\Seller\CreateProductRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateProductRequest $request)
    {

        \DB::transaction(function () use($request) {
            $product = auth()->user()->products()->create( $request->validated() );
            $product->addMediaFromRequest('image')->toMediaCollection('products');
        });

        return redirect(route('seller.products.index'))
                ->with( 'success', 'Product Created Successfully' );
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Seller  $seller
     * @return \Illuminate\Http\Response
     */
    public function show(Seller $seller)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $seller
     * @return \Illuminate\Http\Response Product
     */
    public function edit($product)
    {
        if( ! $product = Product::find($product) ){
            throw new NotProductOwner;
        }

        return view( 'dashboard.product.update', [ 'product' => $product ] );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  App\Http\Requests\Seller\UpdateProductRequest  $request
     * @param  \App\Models\Seller  $seller
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        // dd( $request->validated() );
        $product->update( $request->validated() + [ 'create_by_user' => auth()->user() ] );

        return redirect(route('seller.products.index'))
                ->with( 'success', 'Product '.$product->name.' Updated Successfully' );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Seller  $seller
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {

        \DB::transaction(function () use($product) {

            $product->sales()->delete();
            $product->clearMediaCollection('products');
            $product->forceDelete();

        });

        session()->flash( 'success', 'Product '.$product->name.' Deleted Successfully' );

        return redirect()->back();
    }

    public function filter()
    {

        return view( 'dashboard.product.index', [
            'products' => Product::withFilteration()
        ] );

    }

    public function trashBulk(Request $request)
    {
        Product::whereIn( 'id', $request->products_bluk )->each(function ($product, $key) {
            $product->delete();
        });

        session()->flash( 'Products Trashed Successfully' );

        return redirect()->back();
    }

    public function trashRestore(Request $request)
    {
        Product::onlyTrashed()
            ->whereIn( 'id', $request->products_bluk )
            ->each(function ($product, $key) { $product->restore(); });

        session()->flash( 'Products Restored Successfully' );

        return redirect()->back();
    }

    public function destroyAll(Request $request)
    {
        Product::whereIn( 'id', $request->products_bluk )->each(function ($product, $key) {

            DB::transaction(function () {
                $product->clearMediaCollection('products');
                $product->categories()->detach();
                $product->forceDelete();
            });

        });

        session()->flash( 'Products Deleted Successfully' );

        return redirect()->back();
    }
}
