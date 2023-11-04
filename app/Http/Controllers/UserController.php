<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Admin;
use Illuminate\Support\Facades\Auth;
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


    public function getCompaniesInfo(){
        $companies = User::with('details')
                         ->where('role', 2)
                         ->get();
    
        return response()->json([
            'companies' => $companies
        ]);
    }
}
