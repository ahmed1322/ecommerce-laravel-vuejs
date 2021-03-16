<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\Seller;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\TemporaryFiles;
use Illuminate\Support\Collection;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Traits\Apis\ApiResponseGenratorTrait;
use App\Http\Resources\Product\ProductResource;
use App\Http\Resources\Product\ProductCollection;
use App\Http\Requests\APi\Products\CreateProductRequest;

class ProductController extends Controller
{
    use ApiResponseGenratorTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Product $product)
    {
        return $this->statusCode(200)
        ->retrievData( new ProductCollection(Product::with('seller')->available()->paginate(15)));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateProductRequest $request)
    {
        $request->user()->products()->create($request->validated());
        return $this->statusCode(201)->createdMsg("New Product Created successfully!");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        return $this->statusCode(200)
                    ->retrievData( new ProductResource($product) );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        // $this->validateRequest($product);

        // $product->update( $this->credentials() + [ 'create_by_user' => auth()->user() ] );

        if( ! empty( $request->product_cover ) ){
            $this->storeProductCover($product);
        }


        if( ! empty( $request->product_gallery ) ){
            $this->storeProductGallery($product);
        }

        return $this->statusCode(200)
                ->created([
                        'msg' => 'Product Updated Successfully!',
                        'route' => route('seller.products.index')
                    ]
                );

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        return $this->statusCode(200)->createdMsg("Product Deleted successfully!");
    }

    /**
     * Upldoad Product Images to temporary Dir
     * @return temporary dir name
     */

    public function upload(Request $request, Product $product)
    {
        if( $request->hasFile('product_gallery') ) {
            return $this->uploadProductGallery($product);
        }

        if( $request->hasFile('product_cover') ) {
            return $this->uploadProductCover();
        }
        return '';
    }

    private function storeProductCover($product)
    {
        $files_dir_name = TemporaryFiles::where( 'files_dir' , request()->product_cover )->first();

        if( $files_dir_name ){

            $tmp_path = storage_path( 'app/tmp/products/' . request()->product_cover . '/' . $files_dir_name->file );

            $product->addMedia( $tmp_path )->toMediaCollection('product_cover');

            rmdir( storage_path( 'app/tmp/products/' . request()->product_cover) );

            $files_dir_name->delete();
        }
    }

    private function storeProductGallery($product)
    {
        $files = TemporaryFiles::where( 'files_dir' , request()->product_gallery )->get();

        // dd($files);
        if( $files ){

            $files->map( function( $file ) use($product) {

                $tmp_path = storage_path( 'app/tmp/products/' . request()->product_gallery . '/' . $file->file );

                $product->addMedia( $tmp_path )->toMediaCollection('product_gallery');

                $file->delete();

            });

            rmdir( storage_path( 'app/tmp/products/' . request()->product_gallery) );

        }
    }


    private function uploadProductCover()
    {

        $this->validateImage();

        $file = request()->file('product_cover');
        $files_tmp_dir_name = uniqid() .'-'. now()->timestamp;

        $file_name = $file->getClientOriginalName();
        $file->storeAs( 'tmp/products/' . $files_tmp_dir_name, $file_name );

        TemporaryFiles::create( [
            'files_dir' => $files_tmp_dir_name,
            'file' => $file_name,
        ]);

        return $files_tmp_dir_name;

    }

    private function uploadProductGallery(Product $product)
    {

        // Validate each Image
        $images = request()->file('product_gallery');

        dd($product);
        // Convert into Collection
        $files = Collection::wrap( request()->file('product_gallery') );

        $file_name = $file->getClientOriginalName();

        $file->storeAs( 'tmp/products/', $file_name );

        TemporaryFiles::create( [
            // 'files_dir' => $files_tmp_dir_name,
            'file' => $file_name,
            'collection' => 'product_gallery',
            'model_id' => $product->id,
        ]);

        // Map & store each into one tmp dir
        // $files->each( function( $file ) use( $files_tmp_dir_name ) {

        //     $file_name = $file->getClientOriginalName();
        //     $file->storeAs( 'tmp/products/' . $files_tmp_dir_name, $file_name );

        //     TemporaryFiles::create( [
        //         'files_dir' => $files_tmp_dir_name,
        //         'file' => $file_name,
        //     ]);

        // });

        // return $files_tmp_dir_name;
    }

    public function validateRequest($product)
    {
        Validator::make(
            $this->credentials(),
            $this->rules($product),
            $this->messages()
        )->validate();
    }

    private function credentials()
    {
        return request()->only([
            'name',
            'price',
            'color',
            'size',
            'stock_quantity',
            'availability'
        ]);
    }

    private function rules($product)
    {
        return [
            'name' => [ 'required', "unique:products,name,$product->id", 'max:255' ],
            'price' => [ 'required', 'numeric' ,'regex:/^\d*(\.\d{2})?$/' ],
            'color' => [ 'required' ],
            'size' => [ 'required' ],
            'stock_quantity' => [ 'required', 'integer' ],
            'availability' => [ 'required', 'boolean' ]
        ];
    }

    private function messages()
    {
        return [
            'name.required' => 'Product Name is Missing',
            'name.unique' => 'Product Already Exists',
            'name.max' => 'Product Name must be 255 Charcters max',
            'price.required' => 'Product Price is Missing',
            'price.numeric' => 'Silly You :(',
            'color.required' => 'Product Color is Missing',
            'size.required' => 'Product Size is Missing',
            'stock_quantity.required' => 'Stock Quantity is Missing',
            'stock_quantity.integer' => 'Stock Quantity Must be Integer',
            'availability.required' => 'Product availability is Missing',
            'availability.boolean' => 'Silly You :('
        ];
    }

    private function validateImage()
    {
        Validator::make(request()->only('product_cover') ,[
                'product_cover' => [ 'required', 'image', 'mimes:png,jpg', 'max:2000' ],
            ],
            [
                'product_images.required' => 'Product Image is Missing',
                'product_images.image' => 'Product Image must be Image',
                'product_images.mimes' => 'Product Image must be png|jpg',
                'product_images.max' => 'Product Image size must be max 2000 MB',
            ]
        )->validate();
    }


}
