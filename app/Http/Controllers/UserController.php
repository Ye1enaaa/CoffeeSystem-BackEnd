<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Admin;
use Illuminate\Support\Facades\Auth;
class UserController extends Controller
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
        
        $userCreds->save();
        $userId = $userCreds['id'];
        
        $adminCreds = Admin::create([
            'user_id' => $userId,
            'adminName' => $validate['name'],
            //'adminContactNumber' => $validate['adminContactNumber']
        ]);

        $adminCreds->save();
        return response() -> json([
            'user' => $userCreds,
            'admin' => $adminCreds
        ]);
    }

    public function user(){
        $user = Auth::user();

        return response()->json([
            'user' => $user
        ]);
    }
}
