<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Feedback;

class FeedbackController extends Controller
{
    public function postFeedback(Request $request)
    {
        // Validate the incoming data
        // $validatedData = $request->validate([
        //     'full_name' => 'required|string',
        //     'companyName' => 'required|string',
        //     'phoneNum' => 'required|string',
        //     'coffee_bean_ai_sorter' => 'boolean',
        //     'website' => 'boolean',
        //     'message' => 'required|string',
        //     'email' => 'required|email|unique:feedback,email',
        // ]);

        $full_name = $request->input('full_name');
        $companyName = $request->input('companyName');
        $phoneNum = $request->input('phoneNum');
        $coffee_bean_ai_sorter = $request->input('coffee_bean_ai_sorter');
        $website = $request->input('website');
        $message = $request->input('message');
        $email = $request->input('email');

        // Create a new Feedback record
        $feedback = Feedback::create([
            'full_name' => $full_name,
            'companyName' => $companyName,
            'phoneNum' => $phoneNum,
            'coffee_bean_ai_sorter' => $coffee_bean_ai_sorter,
            'website' => $website,
            'message' => $message,
            'email' => $email
        ]);

        // Optionally, you can return a response or redirect as needed
        return response()->json(['message' => 'Feedback submitted successfully'], 201);
    }

    public function fetchFeedback($user_id)
    {
        $user_id = 1;
        $feedback = Feedback::all();

        return response()->json(['data' => $feedback], 200);
    }

    public function updateFeedback(Request $request, $id)
    {
        // Find the feedback entry by id
        $feedback = Feedback::find($id);

        if (!$feedback) {
            return response()->json(['error' => 'Feedback not found'], 404);
        }

        // Update the status
        $feedback->update(['status' => $request->input('status')]);

        // You can return a response or redirect as needed
        return response()->json(['data' => $feedback], 200);
    }
}
