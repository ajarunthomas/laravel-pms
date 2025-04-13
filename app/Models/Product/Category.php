<?php

namespace App\Models\Product;

use Illuminate\Database\Eloquent\Model;

use App\Models\Product\Product;

class Category extends Model
{
    public function Product()
    {
        return $this->belongsToMany(Product::class, 'product_category');
    }
}
