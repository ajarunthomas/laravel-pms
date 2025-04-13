<?php

namespace App\Models\Product;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\Product\Category;
use App\Models\Product\ProductImages;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name', 'slug', 'price', 'stock_quantity'
    ];

    public function Category()
    {
        return $this->belongsToMany(Category::class, 'product_category');
    }

    public function Images(){
        return $this->hasMany(ProductImages::class, 'product_id', 'id');
    }
}
