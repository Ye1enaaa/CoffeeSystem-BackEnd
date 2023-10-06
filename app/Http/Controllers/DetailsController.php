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
    $images = $request->file('images');
    $companyName = $request->input('companyName');
    $companyNumber = $request->input('companyNumber');
    $companyLocation = $request->input('companyLocation');

    $imagePaths = []; // Array to store image paths

    if ($images) {
        foreach ($images as $image) {
            if ($image->isValid()) {
                $imagePath = $image->store('details', 'public');
                $imagePaths[] = $imagePath;
            } else {
                return response()->json(['error' => 'Invalid image file.'], 400);
            }
        }
    }

    $detailsOfUser = Details::create([
        'user_id' => $user_id,
        'profileAvatar' => $profileAvatar,
        'images' => json_encode($imagePaths), // Store image paths as JSON array
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
        $user_id = $request->input('user_id');
        $profileAvatar = $request->input('profileAvatar');
        $companyName = $request->input('companyName');
        $companyNumber = $request->input('companyNumber');
        $companyLocation = $request->input('companyLocation');

        $detailsOfUser->user_id = $user_id;
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

    public function fetchDetails($user_id){
        $detailsOfUser = Details::where('user_id', $user_id)->first();
        if (!$detailsOfUser) {
            return response()->json(['message' => 'Company details not found'], 404);
        }
        return response() -> json([
            'details' => $detailsOfUser
        ]);
    }
}
