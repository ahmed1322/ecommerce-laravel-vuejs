<?php

namespace Tests\Feature\Seller;

use Tests\TestCase;
use Tests\Traits\ActingAsTrait;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SellerTest extends TestCase
{
    use ActingAsTrait, RefreshDatabase;

    /**
     * Seller can create product
     *
     */

    public function test_seller_can_create_new_product()
    {
        $this->withoutExceptionHandling();
        $this->actingAs($this->acting_as_seller());

        $response = $this->postJson(route('api.products.store'), [
            'name' => 'new product name',
            'color' => 'orange,red,blue',
            'size' => 'sm,lg,md',
            'stock_quantity' => 10,
            'availability' => true
        ]);

        $response
        ->assertStatus(201)
        ->assertJson([
            "msg" => "New Product Created successfully!"
        ]);

    }
}
