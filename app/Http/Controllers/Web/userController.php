<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Validator;
use App\customClass\helpers;

use App\Models\User;
use App\Models\Product\Product;
use App\Models\Product\ProductImages;
use App\Models\Order\Order;

class userController extends Controller
{
    public function login(Request $request){
        $prv_url = url()->previous();
        if (str_contains($prv_url, '/api/')) {
            return response()->json([
                'message' => 'Unauthenticated'
            ], 401);
        }

        return view('user.login');
    }

    public function loginSubmit(Request $request){
        $credentials = $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
        }

        return redirect()->route('home');
    }

    public function register(Request $request){
        return view('user.register');
    }

    public function registerSubmit(Request $request){
        $validation = Validator::make($request->all(),[
            'name' => 'required',
            'username' => 'required|unique:users',
            'password' => 'required|min:8'
        ],[
            'name.required' => 'Name is Missing',
            'username.required' => 'Username is Missing',
            'username.unique' => 'Username is already existing',
            'password.required' => 'Password is Missing',
            'password.min' => 'Password should be minimum 8 characters'
        ]);

        if($validation->fails()){
            return redirect()->back()->with([
                'message' => $validation->messages()->first(),
                'alert_type' => 'danger'
            ]);
        }

        $user = new User();
        $user->name = $request->input('name');
        $user->username = $request->input('username');
        $user->password = $request->input('password');
        $user->access_level = 'user';
        $user->save();

        return redirect()->route('login')->with([
            'message' => 'User Registered',
            'alert_type' => 'success'
        ]);
    }

    public function home(Request $request){
        $products = Product::with(['category', 'images'])->orderBy('name')->paginate(9);

        return view('user.home', [
            'products' => $products
        ]);
    }

    public function orders(Request $request){
        $orders = Order::where('user_id', auth()->user()->id)->orderBy('created_at')->paginate(5);

        return view('user.orders', [
            'orders' => $orders
        ]);
    }

    public function products(Request $request){
        if(auth()->user()->access_level != 'admin'){
            return redirect()->route('home');
        }
        $products = Product::orderBy('name')->paginate(10);

        return view('user.products', [
            'products' => $products
        ]);
    }

    public function addProduct(Request $request){
        if(auth()->user()->access_level != 'admin'){
            return redirect()->route('home');
        }

        return view('user.add_product');
    }

    public function addProductSubmit(Request $request){
        $validation = Validator::make($request->all(),[
            'name' => 'required|unique:products,name,NULL,NULL,deleted_at,NULL',
            'price' => 'required|decimal:0,2',
            'quantity' => 'required|numeric'
        ],[
            'name.required' => 'Product name is missing',
            'name.unique' => 'This Product already exists',
            'price.required' => 'Product price is missing',
            'quantity.required' => 'Product stock quantity is missing',
            'price.decimal' => 'Invalid Product Price',
            'quantity.numeric' => 'Invalid Product Stock Quantity'
        ]);
        
        if($validation->fails()){
            return redirect()->route('products.add')->with([
                'message' => $validation->messages()->first(),
                'alert_type' => 'danger'
            ]);
        }

        $new_product = new Product([
            "name" => $request->input('name'),
            "slug" => helpers::slugify($request->input('name')),
            "price" => $request->input('price'),
            "stock_quantity" => $request->input('quantity')
        ]);
        $new_product->save();

        $x = new ProductImages([
            'product_id' => $new_product->id,
            'image_url' => 'image'.rand(1,5).'.jpg'
        ]);
        $x->save();

        return redirect()->route('products')->with([
            'message' => 'Product Added',
            'alert_type' => 'success'
        ]);
    }

    public function logout(Request $request){
        auth()->guard('web')->logout();

        return redirect()->route('login')->with([
            'message' => 'User Logged Out',
            'alert_type' => 'success'
        ]);
    }
}
