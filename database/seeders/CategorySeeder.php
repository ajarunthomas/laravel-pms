<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Product\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = ['Antivirals', 'Antibiotics', 'Sedatives'];

        for($x = 0; $x < count($categories); $x++){
            $rec = new Category();
            $rec->name = $categories[$x];
            $rec->save();
        }
    }
}
