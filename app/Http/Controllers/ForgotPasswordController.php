<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use App\Mail\SendOTPMail;
use App\Models\User;
class ForgotPasswordController extends Controller
{
    public function sendOTP(Request $request)
    {
       
        $otp = mt_rand(1000, 9999);
    
        
        $email = $request->input('email'); 
        Mail::to($email)->send(new SendOTPMail($otp));
        $uID = User::where('email', $email)->first();
        $encryptedOtp = bcrypt($otp);
        return response()->json([
            'uID' => $uID->id,
            'email' => $email,
            'otp' => $encryptedOtp
        ]);
    }

    public function verifyOTP(Request $request){
        $userInput = $request->input('otpInput');
        $encryptedOtp = $request->input('otp');
        
        $decryptedOtp = Hash::check($userInput, $encryptedOtp);
    
        if ($userInput == $decryptedOtp){
            return response()->json([
                'status' => 'OTP True',
                'message' => 'Success'
            ], 200);
        } else {
            return response()->json([
                'status' => 'OTP dont match'
            ], 401);
        }
    }
    
    
    public function passwrdEdit(Request $request, $id){
        $user = User::find($id);
    
        $newPassword = $request->input('password');
    
        $user->password = bcrypt($newPassword);
    
        $user->update();

        return response()->json([
            'message' => 'Password updated successfully',
        ], 200);

        
    }
    
}
