<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use Auth;
use DB;
use App\customClass\helpers;

use App\Models\Product\Product;
use App\Models\Order\Order;
use App\Models\Order\OrderDetail;

use App\Http\Resources\orderResource;

class orderController extends Controller
{
    public function index(Request $request){
        $orders = Order::with(['details'])->where('user_id', auth()->user()->id)->orderBy('created_at', 'desc')->get();

        return orderResource::collection($orders);
    }

    public function show($order_id, Request $request){
        $order = Order::with(['details'])->find($order_id);

        if(!$order){
            return response()->json([
                'message' => "Invalid Order"
            ],404);
        }

        if($order->user_id != auth()->user()->id){
            return response()->json([
                'message' => "Access Denied"
            ],403);
        }

        return new orderResource($order);
    }

    public function store(Request $request){
        $validation = Validator::make($request->all(),[
            'items' => 'required|array'
        ],[
            'items.required' => 'Order information missing',
            'items.array' => 'Invalid Order data'
        ]);
        
        if($validation->fails()){
            return response()->json([
                'message' => $validation->messages()->first()
            ], 422);
        }

        $items = $request->input('items');

        foreach($items as $i){
            $stock_availability = Product::find($i['product_id']);
            if($stock_availability->stock_quantity < $i['total_quantity']){
                $message = "Invalid Order. Not Enough Stock available for '".$stock_availability->name."'";

                return response()->json([
                    'message' => $message
                ], 422);
            }
        }

        $new_order = new Order([
            'order_number' => helpers::generateOrdernumber(),
            'user_id' => auth()->user()->id
        ]);
        $new_order->save();

        foreach($items as $item){
            $new_order_detail = new OrderDetail([
                'order_id' => $new_order->id,
                'product_id' => $item['product_id'],
                'total_price' => $item['total_price'],
                'total_quantity' => $item['total_quantity']
            ]);
            $new_order_detail->save();

            Product::where('id', $item['product_id'])
                    ->update([
                        'stock_quantity' => DB::raw('stock_quantity-'.$item['total_quantity'])
                    ]);
        }

        return response()->json([
            'message' => "Order Submitted"
        ]);
    }
}
