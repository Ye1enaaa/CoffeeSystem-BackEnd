<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;
use App\Models\User;
class RegisterController extends Controller
{
    public function register(Request $request)
    {
        try {
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
        } catch (ValidationException $e){
            return response() -> json([
                'error' => $e->validator->errors()->toArray(),
                'status' => 'Validation error'
            ], 422);
        } catch(\Exception $e){
            return response() -> json([
                'error' => 'Something Went Wrong'
            ], 500);
        }
    }
}
