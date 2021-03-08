<?php

namespace Tests\Feature\Product;

use Tests\TestCase;
use App\Models\Product;
use Tests\Traits\ActingAsTrait;
use Illuminate\Foundation\Testing\WithFaker;
use App\Traits\Apis\ApiResponseGenratorTrait;
use App\Http\Resources\Product\ProductResource;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductTest extends TestCase
{
    use ActingAsTrait,ApiResponseGenratorTrait, RefreshDatabase;

    private $product_data;
    private $errors_msg;
    private $http_status_code = 422;

    /**
     * cannot create product with out providing a name
     *
     * @return void
     */
    public function test_product_name_is_required()
    {
        $this->overrideProductData( [ 'name' => '' ] )
            ->errorMsgs( )
            ->createProduct();
    }

    /**
     * cannot create product with out providing a color
     *
     * @return void
     */
    public function test_product_color_is_required()
    {
        $this->overrideProductData( [ 'color' => '' ] )
            ->errorMsgs( [ "color" => [ "Product Color is Missing" ] ] )
            ->createProduct();
    }

    /**
     * cannot create product with out providing a size
     *
     * @return void
     */
    public function test_product_size_is_required()
    {
        $this->overrideProductData( [ 'size' => '' ] )
            ->errorMsgs( [ "size" => [ "Product Size is Missing" ] ] )
            ->createProduct();

    }

    /**
     * cannot create product with out providing a stock quantity
     *
     * @return void
     */
    public function test_product_stock_quantity_is_required()
    {
        $this->overrideProductData( [ 'stock_quantity' => '' ] )
            ->errorMsgs( [ "stock_quantity" => [ "Stock Quantity is Missing" ] ] )
            ->createProduct();

    }

    /**
     * cannot create product with out providing a availability
     *
     * @return void
     */
    public function test_product_availability_is_required()
    {
        $this->overrideProductData( [ 'availability' => '' ] )
            ->errorMsgs( [ "availability" => [ "Product availability is Missing" ] ] )
            ->createProduct();

    }

    public function test_return_seller_products()
    {
        $this->withoutExceptionHandling();

        $seller = $this->createSellerMultipleProducts();

        $this->json( 'GET', route('api.products.index') )->assertJson(
            [
                'data'=> $seller->products()->get()->toArray()
            ],
            200
        )->assertOk();

    }


    private function overrideProductData( array $override_current_data = [] )
    {
        $this->product_data = array_merge(
            [
                'name' => 'new product name',
                'color' => 'orange,red,blue',
                'size' => 'sm,lg,md',
                'stock_quantity' => 10,
                'availability' => true
            ],
            $override_current_data
        );

        return $this;

    }

    private function errorMsgs( array $errors = [] )
    {
        $this->errors_msg = [
            "message" => "The given data was invalid.",
            "errors" => $errors
        ];

        return $this;

    }

    private function createProduct()
    {

        $response = $this->postJson(route('api.products.store'), $this->product_data );

        $response
        ->assertStatus($this->http_status_code)
        ->assertJson( $this->errors_msg );

    }

    public function createSellerMultipleProducts()
    {
        // acting as seller
        $seller = $this->acting_as_seller();

        $this->actingAs($seller);

        // Store many prodcut
        ProductResource::collection(Product::factory()->count(3)->make())
        ->map(function ($product) use( $seller ) {

            $this->actingAs($seller);

            $response = $this->postJson(route('api.products.store'), [
                "name" => $product->name,
                "color" => $product->color,
                "size" => $product->size,
                "stock_quantity" => $product->stock_quantity,
                "availability" => $product->availability
            ]);

            $response
            ->assertStatus(201)
            ->assertJson( [
                'msg' => "New Product Created successfully!"
            ] );
        });

        return $seller;
    }
}
