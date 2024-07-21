<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Product::class;
    public function definition()
    {
            return [
                'name' => $this->faker->unique(true)->word().rand(1,1000),
                'description' => $this->faker->text,
                'price' => $this->faker->numberBetween(100,1000),
                'category_id' => Category::inRandomOrder()->first()->id,
                'quantity' => $this->faker->numberBetween(1, 100),
            ];
    }
}
