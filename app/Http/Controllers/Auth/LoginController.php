<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
class LoginController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);

        $user = User::where('email' , $credentials['email'])->first();

        if(!$user||!Hash::check($credentials['password'],$user->password)){
            return response() ->json([
                'error' => 'Invalid Credentials'
            ], 401);
        }

        $token = $user->createToken('token')->plainTextToken;
        if(Auth::attempt($credentials)){
            $user = Auth::user();
            return response()->json([
                'user' => $user,
                'token' => $token
            ], 200);
        } 

        return response() -> json([
            'error' => 'Error'
        ], 401  );
    }
}
