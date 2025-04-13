<?php

namespace Database\Factories\Product;

use Illuminate\Database\Eloquent\Factories\Factory;

use App\customClass\helpers;
use App\Models\Product\Category;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $product_name = fake()->name;
        $product_slug = helpers::slugify($product_name);

        return [
            'name' => $product_name,
            'slug' => $product_slug,
            'price' => rand(10,100),
            'stock_quantity' => rand(1,10)
        ];
    }
}
