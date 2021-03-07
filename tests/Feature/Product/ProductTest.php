<?php

namespace Tests\Feature\Product;

use Tests\TestCase;
use Tests\Traits\ActingAsTrait;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductTest extends TestCase
{
    use ActingAsTrait, RefreshDatabase;

    private $product_data;
    private $errors_msg;

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
        ->assertStatus(422)
        ->assertJson($this->errors_msg );

    }
}
