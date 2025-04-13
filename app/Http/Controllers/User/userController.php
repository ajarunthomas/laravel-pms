<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Validator;
use URL;
use App\customClass\helpers;

use App\Models\User;

class userController extends Controller
{
    public function token(Request $request)
    {
        $validation = Validator::make($request->all(),[
            'username' => 'required',
            'password' => 'required'
        ],[
            'username.required' => 'Username is missing',
            'password.required' => 'Password is missing'
        ]);
        
        if($validation->fails()){
            return response()->json([
                'message' => $validation->messages()->first()
            ], 422);
        }

        $user = User::where('username', $request->username)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'The provided credentials are incorrect',
            ], 401);
        }

        if(!$user->tokens()->where('name', $request->username)->first()) {
            return response()->json([
                'token' => helpers::getToken($user->createToken($request->username, [$user->access_level])->plainTextToken)
            ]);
        }

        $user->tokens()->delete();

        return [
            'token' => helpers::getToken($user->createToken($request->username)->plainTextToken)
        ];
    }
}
