<?php

namespace Database\Factories;

use App\Models\Sale;
use Illuminate\Database\Eloquent\Factories\Factory;

class AddSalesFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Sale::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $user = \DB::table('users')
                ->where('name', 'LIKE', "%seller%" )
                ->inRandomOrder()
                ->first();
        $product = \DB::table('products')
                ->where('created_by_user', $user->id  )
                ->where('availability', 1 )
                ->inRandomOrder()
                ->first();

        return [
            'product_id' => $product->id,
            'sale_price' => $product->price,
            'was_on_sale' => $this->faker->randomElement([1,0]),
        ];
    }
}
