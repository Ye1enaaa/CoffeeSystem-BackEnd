<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
//use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use App\Mail\SendOTPMail;
use App\Models\User;
use App\Models\PasswordReset;
use Mail;
//use Validator;
//use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Carbon;

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

    public function forgetPassword(Request $request){
        try {
            $user = User::where('email', $request->email)->get();

            if(count($user) > 0 ){

                $token = Str::random(40);
                $domain = URL::to('/');
                $url = $domain.'/password-reset?token'.$token;

                $data['url'] = $url;
                $data['email'] = $request->email;
                $data['title'] = 'Password Reset';
                $data['body'] = 'Please click on the link below.';

                Mail::send('forgetpasswordview', ['data'=>$data], function($message) use ($data){
                    $message->to($data['email'])->subject($data['title']);
                });

                $datetime = Carbon::now()->format('Y-m-d H:i:s');
                PasswordReset::updateOrCreate(
                    ['email' => $request->email],
                    [
                        'email' => $request->email,
                        'token' => $token,
                        'created_at' => $datetime
                    ]
                );
                return response()->json([
                    'success' => true,
                    'msg' => 'Please check your email'
                ]);
            } else{
                return response()->json([
                    'success' => false
                ]);
            }

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'msg' => $e->getMessage()
            ]);
        }
    }
    
}
