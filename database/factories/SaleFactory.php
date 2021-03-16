<?php

namespace Database\Factories;

use App\Models\Sale;
use App\Models\Product;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class SaleFactory extends Factory
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
        $prduct = Product::all()->random(1);
        return [
           'product_id' => $prduct->pluck('id')->first(),
            'sale_price' => $prduct->pluck('price')->first(),
            'was_on_sale' => $this->faker->randomElement([1,0]),
        ];
    }
}
