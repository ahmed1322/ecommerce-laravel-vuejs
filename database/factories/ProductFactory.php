<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->unique()->name,
            'price' => rand(100,700),
            'color' => $this->faker->randomElement(['orange,red,blue','orange,red','blue,red']),
            'size' => $this->faker->randomElement(['sm,lg','lg,md','md,xl','lg,xl,xxl','md,xl,xxl']),
            'stock_quantity' => $this->faker->randomElement([10,20,30,40]),
            'availability' => $this->faker->randomElement([1,0]),
            'created_by_user' => User::where('name' , 'LIKE', '%seller%')->get()->random(1)->pluck('id')->first()
        ];
    }

}
