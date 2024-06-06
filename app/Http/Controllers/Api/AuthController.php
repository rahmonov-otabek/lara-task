<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;  
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest; 


use App\Models\User;

class AuthController extends Controller
{  
    public function login(LoginRequest $request)
    {
        $validated = $request->validated();

        if(!Auth::attempt($validated)){
            return response()->json([
                'message' => 'Login information invalid',
            ], 401);
        }

        $user = User::where('email', $validated['email'])->first();

        return response()->json([
            'access_token' => $user->createToken('api_token')->plainTextToken,
            'token_type' => 'Bearer'
        ]);
    }

    public function logout(Request $request)
    {
        auth()->user()->tokens()->delete();

        return response()->json([
          "message"=>"logged out"
        ]);
    }
}
