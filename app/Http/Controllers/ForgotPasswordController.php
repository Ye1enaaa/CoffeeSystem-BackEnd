<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendOTPMail;
class ForgotPasswordController extends Controller
{
    public function sendOTP(Request $request)
    {
       
        $otp = mt_rand(1000, 9999);
    
        
        $email = $request->input('email'); 
        Mail::to($email)->send(new SendOTPMail($otp));
        $encryptedOtp = Crypt::encryptString($otp);
        return response()->json([
            'otp' => $encryptedOtp
        ]);

    }
    
}
