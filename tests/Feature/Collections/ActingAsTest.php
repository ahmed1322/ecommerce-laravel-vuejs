<?php

namespace Tests\Feature\collections;

use Tests\TestCase;
use Tests\Traits\ActingAsTrait;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ActingAsTest extends TestCase
{
    use RefreshDatabase, ActingAsTrait;

    public function test_acting_as_seller()
    {
        $seller = $this->acting_as_seller();

        $this->assertRole( 'seller' );
    }

    public function test_acting_as_customer()
    {
        $customer = $this->acting_as_customer();

        $this->assertRole( 'customer' );
    }

    public function test_acting_as_admin()
    {
        $admin = $this->acting_as_admin();

        $this->assertRole( 'admin' );
    }
}
