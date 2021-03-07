<?php

namespace Tests\Feature\Middleware;

use Tests\TestCase;
use App\Models\Role;
use App\Models\User;
use Tests\Traits\ActingAsTrait;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SellerMiddlewareTest extends TestCase
{
    use ActingAsTrait, RefreshDatabase;

    /**
     * unauthenticated user cannot access seller routes
     *
     * @return void
     */
    public function test_unauthenticated_user_cannot_access_seller_routes()
    {
        $this->get(route('seller.products.index'))->assertRedirect(route('login'));
    }

    /**
     * only seller which has credibility can access sellers area
     * credibility Middleware [ auth, verified, isSeller ]
     *
     * @return void
     */
    public function test_seller_can_access_seller_routes()
    {
        $this->actingAs($this->acting_as_seller())
            ->get(route('seller.products.index'))
            ->assertOk();
    }


    /**
     * non seller users cannot access sellers area
     *
     * @return void
     */
    public function test_non_seller_users_cannot_access_sellers_area()
    {
        $this->actingAs($this->acting_as_admin())
            ->get('seller/products')
            ->assertUnauthorized();
    }

    /**
     * only seller which has credibility can access sellers area
     * credibility Middleware [ auth, verified, isSeller ]
     *
     * @return void
     */
    // public function test_only_verified_seller_can_access_seller_routes()
    // {
    //     $this->withoutExceptionHandling();
    //     $this->override_user_data( ['email_verified_at' => ''] );

    //     $this->actingAs($this->acting_as_seller())
    //         ->get(route('seller.products.index'))
    //         ->assertRedirect(route('verification.notice'));
    // }


}
