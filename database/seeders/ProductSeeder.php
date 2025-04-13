<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Product\Product;
use App\Models\Product\Category;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Product::factory(50)->create();

        $products = Product::all();
        $categories = Category::all();

        $products->each(function($product) use ($categories){
            $product->category()->attach(
                // array_rand($categories,2)
                $categories->random(rand(1, 3))->pluck('id')->toArray()
            );
        });
    }
}
