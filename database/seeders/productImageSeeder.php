<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Product\Product;
use App\Models\Product\ProductImages;

class productImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = Product::all();

        foreach($products as $p){
            $x = new ProductImages([
                'product_id' => $p->id,
                'image_url' => 'image'.rand(1,5).'.jpg'
            ]);
            $x->save();

            $x = new ProductImages([
                'product_id' => $p->id,
                'image_url' => 'image'.rand(1,5).'.jpg'
            ]);
            $x->save();
        }
    }
}
