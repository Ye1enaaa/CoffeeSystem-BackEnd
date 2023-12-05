<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Admin;
use App\Models\GenerateKeys;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Contracts\Encryption\DecryptException;
use App\Mail\SendKeyMail;
use Mail;
use Illuminate\Support\Facades\Hash;

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

    public function disabledUser(Request $request, $id)
    {
        $user = User::findOrFail($id);

        // Check if 'disabled' is present in the request
        if ($request->has('disabled')) {
            // Disable the user
            $user->disabled = $request->boolean('disabled');
            $user->save();

            // Check if the user is disabled and return an error response
            // if ($user->disabled) {
            //     return response()->json(['error' => 'User is disabled'], 404);
            // }
        }

        // Update other user details if needed
        $user->update($request->except('disabled'));

        // Return success response
        return response()->json(['user' => $user], 200);
    }

     //delete
     public function deleteUser($id){
        $user = User::findOrFail($id);
        $deleted = $user->delete();
        return response() -> json([
            'deleted' => $deleted,
            'user' => $user,
            'status' => 'Deleted',
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
    public function generateRandomKey(Request $request)
    {
        $email = $request->input('email'); 

        $length = 12; // adjust the length of the random key as needed.
        $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789!@#$%&<>?'; // Define the characters.

        $randomKey = '';

        for ($i = 0; $i < $length; $i++) {
            $randomKey .= $characters[random_int(0, strlen($characters) - 1)];
        }

        Mail::to($email)->send(new SendKeyMail($randomKey));

        $encryptedKey = bcrypt($randomKey);
        
        GenerateKeys::create(
            [
            'email' => $email,
            'special_key' => $encryptedKey,
            'user_id' => auth()->user()->id
            ]
        );

        return response()->json([
            'random_key' => $randomKey,
            'email' => $email,
            'key' => $encryptedKey
        ]);
    }

    public function verifyKey(Request $request)
    {
        $userInput = $request->input('keyInput');
        $email = $request->input('email');

        // Retrieve the user by email
        $user = GenerateKeys::where('email', $email)->first();

        if (!$user) {
            return response()->json([
                'status' => 'User not found',
            ], 404);
        }

        // Use Hash::check to compare user input with hashed special key
        if (Hash::check($userInput, $user->special_key)) {
            return response()->json([
                'status' => 'Key matches',
                'message' => 'Success',
            ], 200);
        } else {
            return response()->json([
                'status' => 'Key does not match',
            ], 401);
        }
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
