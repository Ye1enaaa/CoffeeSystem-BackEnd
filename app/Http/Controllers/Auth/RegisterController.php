<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    public function register(Request $request)
    {
        $validate = $request->validate([
            'name' => 'required|string|max:70',
            'email' => 'required|string|unique:users,email',
            'password' => 'required|string|min:6',
        ]);

        $userCreds = User::create([
            'name' => $validate['name'],
            'email' => $validate['email'],
            'password' => bcrypt($validate['password'])
        ]);
        
        return response() -> json([
            'user' => $userCreds,
            'status' => 'OK'
        ], 200);
    }
}
