<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

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
            'user_id' => 1,
            //'title' => $this->faker->text(5),
            'title' => 'لباس',
            'description' => $this->faker->text(50),
            'price' => $this->faker->numberBetween(200,300),
            'inventory' => $this->faker->numberBetween(50,60),
        ];
    }
}
