<?php

namespace Tests\Traits;

use App\Models\Role;
use App\Models\User;

trait ActingAsTrait
{
    private $override_data;

    public function acting_as_admin()
    {
        return $this->acting_as( 'admin' );
    }

    public function acting_as_customer()
    {
        return $this->acting_as( 'customer' );
    }

    public function acting_as_seller()
    {
        return $this->acting_as( 'seller' );
    }

    private function override_user_data( array $override_data = [] )
    {
        $this->override_data = $override_data;
    }

    private function acting_as( $role_name )
    {
        $user = User::factory()->create($this->override_data);

        $role = Role::factory()->create([
            'name' => $role_name,
        ]);

        $user->roles()->attach( $role->id );

        return $user;
    }

    private function assertRole( $role_name )
    {
        $this->assertDatabaseHas('roles', [
            'name' => $role_name,
        ]);
    }
}
