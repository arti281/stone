<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function signUp(Request $request){
        $validateUser = Validator::make($request->all(),[
            'name' => 'required|max:50',
            'email' => 'required|email|unique:users,email',
            'password' => 'required'
        ]);
        if($validateUser->fails()){
            return response()->json([
                'status' => false,
                'message' => 'Validation Error',
                'errors' => $validateUser->errors()->all()
            ],401);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password
        ]);

        return response()->json([
            'status' => true,
            'message' => 'User Created Successfully',
            'user' => $user
        ],200);
    }

    public function login(Request $request){
        $validateUser = Validator::make($request->all(),[
            'email' => 'required|email',
            'password' => 'required'
        ]);
        if($validateUser->fails()){
            return response()->json([
                'status' => false,
                'message' => 'Authentication Failed',
                'errors' => $validateUser->errors()->all()
            ],401);
        }

        if(Auth::attempt(['email' => $request->email, 'password'=>$request->password])){
            $authUser = Auth::user();
            return response()->json([
                'status' => true,
                'message' => 'User Logged in Successfully',
                'token' => $authUser->createToken("API Token")->plainTextToken,
            ],200);
        }else{
            return response()->json([
                'status' => false,
                'message' => 'Authentication Failed',
                'errors' => $validateUser->errors()->all()
            ],401);
        }
    }

    public function logout(Request $request){
        $user = $request->user();
        $user->tokens()->delete();

        return response()->json([
            'status' => true,
            'message' => 'User logged Out Successfully',
        ],200);
    }
}
