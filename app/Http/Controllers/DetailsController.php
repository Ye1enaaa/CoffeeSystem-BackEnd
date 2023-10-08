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

        
public function editDetails(Request $request, $user_id)
{

    // Find the user details by user_id
    $detailsOfUser = Details::where('user_id', $user_id)->first();

    // Validate the request data for the fields you want to update
    // $request->validate([
    //     'companyName' => 'required|string|max:255',
    //     'companyNumber' => 'required|string',
    //     'companyLocation' => 'required|string|max:255',
    // ]);

    // Retrieve the values from the request
    $companyName = $request->input('companyName');
    $companyNumber = $request->input('companyNumber');
    $companyLocation = $request->input('companyLocation');

    // Update the user details
    $detailsOfUser->update($request->all());


    return response()->json([
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
