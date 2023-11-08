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
        $profileAvatar = $request->file('profileAvatar');
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

        $profilePaths = []; // Array to store image paths

        if ($profileAvatar) {
            foreach ($profileAvatar as $profileImage) {
                if ($profileImage->isValid()) {
                    $profilePath = $profileImage->store('details', 'public');
                    $profilePaths[] = $profilePath;
                } else {
                    return response()->json(['error' => 'Invalid image file.'], 400);
                }
            }
        }

        $detailsOfUser = Details::create([
            'user_id' => $user_id,
            'profileAvatar' => json_encode($profilePaths),
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
    
        if (!$detailsOfUser) {
            return response()->json(['error' => 'User details not found.'], 404);
        }
    
        // Handle profileAvatar and images separately
        if ($request->hasFile('profileAvatar')) {
            $profileAvatar = $request->file('profileAvatar');
            if ($profileAvatar->isValid()) {
                $profilePath = $profileAvatar->store('public/details'); // Store with a relative path
                $detailsOfUser->profileAvatar = json_encode([$profilePath]);
            } else {
                return response()->json(['error' => 'Invalid profile image file.'], 400);
            }
        }
    
        if ($request->hasFile('images')) {
            $imagePaths = [];
            $images = $request->file('images');
            foreach ($images as $image) {
                if ($image->isValid()) {
                    $imagePath = $image->store('details', 'public');
                    $imagePaths[] = $imagePath;
                } else {
                    return response()->json(['error' => 'Invalid image file.'], 400);
                }
            }
            $detailsOfUser->images = json_encode($imagePaths);
        }
    
        // Update the user details using the request data after handling profileAvatar and images
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
