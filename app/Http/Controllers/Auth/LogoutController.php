<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
class LogoutController extends Controller
{
    public function logOut(){
        auth()->user()->tokens()->delete();

        return response() -> json([
            'message' => 'Log Out Successfully'
        ], 200);
    }
}
