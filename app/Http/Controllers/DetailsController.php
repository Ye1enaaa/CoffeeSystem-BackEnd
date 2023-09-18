<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Details;
use App\Models\User;
class DetailsController extends Controller
{
    public function postDetails(Request $request)
    {
        $user_id = $request->input('user_id');
        $profileAvatar = $request->input('profileAvatar');
        $companyName = $request->input('companyName');
        $companyNumber = $request->input('companyNumber');
        $companyLocation = $request->input('companyLocation');
        
        $detailsOfUser = Details::create([
            'user_id' => $user_id,
            'profileAvatar' => $profileAvatar,
            'companyName' => $companyName,
            'companyNumber' => $companyNumber,
            'companyLocation' => $companyLocation
        ]);

        return response()->json([
            'status' => 'OK',
            'details' => $detailsOfUser
        ], 200);
    }
    
    public function editDetails(Request $request, $id)
    {
        $detailsOfUser = Details::find($id);
        
        $profileAvatar = $request->input('profileAvatar');
        $companyName = $request->input('companyName');
        $companyNumber = $request->input('companyNumber');
        $companyLocation = $request->input('companyLocation');

        $detailsOfUser->user_id = 1;
        $detailsOfUser -> profileAvatar = $profileAvatar;
        $detailsOfUser -> companyName = $companyName;
        $detailsOfUser -> companyNumber = $companyNumber;
        $detailsOfUser -> companyLocation = $companyLocation;

        $detailsOfUser->save();

        return response() -> json([
            'status' => 'OK',
            'details' => $detailsOfUser
        ], 200);
    }
}
