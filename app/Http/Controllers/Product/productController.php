<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use Auth;
use App\customClass\helpers;

use App\Models\Product\Product;
use App\Models\Product\Category;

use App\Http\Resources\productResource;

class productController extends Controller
{
    public function index(Request $request){
        $products = Product::with(['category'])->where('stock_quantity', '>', 0)->orderBy('name')->paginate(10);

        return productResource::collection($products);
    }


    public function show($product_id, Request $request){
        if(!is_numeric($product_id)){
            return response()->json([
                'message' => "Invalid Product Selection"
            ], 422);
        }

        $product = Product::with(['category'])->find($product_id);
        if(!$product){
            return response()->json([
                'message' => "Product not found"
            ], 404);
        }

        return new productResource($product);
    }


    public function store(Request $request){
        $user = Auth::user();
        if ($user->tokenCant('admin')) {
            return response()->json([
                'message' => "Unauthorized Access"
            ], 403);
        }

        $validation = Validator::make($request->all(),[
            'name' => 'required|unique:products,name,NULL,NULL,deleted_at,NULL',
            'price' => 'required|decimal:0,2',
            'stock_quantity' => 'required|numeric',
            'category' => 'present|array'
        ],[
            'name.required' => 'Product name is missing',
            'name.unique' => 'This Product already exists',
            'price.required' => 'Product price is missing',
            'stock_quantity.required' => 'Product stock quantity is missing',
            'price.decimal' => 'Invalid Product Price',
            'stock_quantity.numeric' => 'Invalid Product Stock Quantity',
            'category.present' => 'Product Category Input is Missing',
            'category.array' => 'Invalid Category input'
        ]);
        
        if($validation->fails()){
            return response()->json([
                'message' => $validation->messages()->first()
            ], 422);
        }

        $new_product = new Product([
            "name" => $request->input('name'),
            "slug" => helpers::slugify($request->input('name')),
            "price" => $request->input('price'),
            "stock_quantity" => $request->input('stock_quantity')
        ]);

        $new_product->save();

        $categories = Category::whereIn('id', $request->input('category'))->pluck('id');
        $new_product->category()->attach($categories);

        return new productResource($new_product);
    }


    public function update(Request $request, $id){
        $user = Auth::user();
        if ($user->tokenCant('admin')) {
            return response()->json([
                'message' => "Unauthorized Access"
            ], 403);
        }

        $validation = Validator::make($request->all(),[
            'name' => 'required',
            'price' => 'required|decimal:0,2',
            'stock_quantity' => 'required|numeric',
            'category' => 'present|array'
        ],[
            'name.required' => 'Product name is missing',
            'price.required' => 'Product price is missing',
            'stock_quantity.required' => 'Product stock quantity is missing',
            'price.decimal' => 'Invalid Product Price',
            'stock_quantity.numeric' => 'Invalid Product Stock Quantity',
            'category.present' => 'Product Category Input is Missing',
            'category.array' => 'Invalid Category input'
        ]);
        
        if($validation->fails()){
            return response()->json([
                'message' => $validation->messages()->first()
            ], 422);
        }

        if(!is_numeric($id)){
            return response()->json([
                'message' => "Product not found"
            ], 422);
        }

        $product = Product::find($id);
        if(!$product){
            return response()->json([
                'message' => "Product not found"
            ], 404);
        }

        $product_existing = Product::where('name', $request->input('name'))
                                        ->whereNot('id', $id)
                                        ->first();

        if($product_existing){
            return response()->json([
                'message' => "This Product name is already existing for another Product"
            ], 400);
        }

        $product->name = $request->input('name');
        $product->slug = helpers::slugify($request->input('name'));
        $product->price = $request->input('price');
        $product->stock_quantity = $request->input('stock_quantity');
        $product->save();

        $categories = Category::whereIn('id', $request->input('category'))->pluck('id');

        $product->category()->detach();
        $product->category()->attach($categories);

        return new productResource($product);
    }


    public function destroy(Request $request, $id){
        $user = Auth::user();
        if ($user->tokenCant('admin')) {
            return response()->json([
                'message' => "Unauthorized Access"
            ], 403);
        }

        if(!is_numeric($id)){
            return response()->json([
                'message' => "Product not found"
            ], 422);
        }

        $product = Product::find($id);
        if(!$product){
            return response()->json([
                'message' => "Product not found"
            ], 404);
        }

        $product->delete();

        return response()->json([
            'message' => "Product Deleted"
        ]);
    }


    public function productsByCategory($category_id, Request $request){
        if(!is_numeric($category_id)){
            return response()->json([
                'message' => "Invalid Category Selection"
            ], 422);
        }

        $products = Product::whereHas('category', function($q) use ($category_id){
            $q->where('category_id', $category_id);
        })->paginate(10);

        return productResource::collection($products);
    }
}
