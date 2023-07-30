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

        return response()->json([
            'user' => $user
        ]);
    }
}
