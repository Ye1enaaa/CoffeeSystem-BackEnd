<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Admin;
use App\Models\GenerateKeys;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function user(){
        $user = Auth::user();
        $details = $user->details;
        return response()->json([
            'user' => $user,
            'details' => $details
        ]);
    }
    public function fetchUsers(){
        $role = 2;
        $user = User::where('role',$role)->get();
        return response() -> json([
            'user' => $user
        ]);
    }

    //update
    public function updateUser(Request $request, $id)
    {
        $user = User::where('id', $id)->first();
        // Update the user details
        $user->update($request->all());
        return response() -> json([
            'user' => $user
        ], 200);
    }

    public function getCompaniesInfo(){
        $companies = User::with('details')
                         ->where('role', 2)
                         ->get();
    
        return response()->json([
            'companies' => $companies
        ]);
    }
    public function generateRandomKey()
    {
        $length = 24; // adjust the length of the random key as needed.
        $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789!@#$%^&*()_+{}[]|;:,.<>?'; // Define the characters.

        $randomKey = '';

        for ($i = 0; $i < $length; $i++) {
            $randomKey .= $characters[random_int(0, strlen($characters) - 1)];
        }
        
        GenerateKeys::create(['special_key' => $randomKey,'user_id' => auth()->user()->id]);

        return response()->json(['random_key' => $randomKey]);
    }

    public function fetchRandomKey($user_id)
    {
        $randomKey = GenerateKeys::all();
        
        if ($randomKey) {
            return response()->json(['random_key' => $randomKey]);
        } else {
            return response()->json(['message' => 'Random key not found for this user.']);
        }
    }

    //delete
    public function deleteKey($id){
        $randomKey = GenerateKeys::findOrFail($id);
        $deleted = $randomKey->delete();
        return response() -> json([
            'deleted' => $deleted,
            'random_key' => $randomKey,
            'status' => 'Deleted',
        ], 200);
    }

}
