<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Feedback;

class FeedbackController extends Controller
{
    public function postFeedback(Request $request)
    {
        // Validate the incoming data
        $validatedData = $request->validate([
            'full_name' => 'required|string',
            'companyName' => 'required|string',
            'phoneNum' => 'required|string',
            'coffee_bean_ai_sorter' => 'boolean',
            'website' => 'boolean',
            'message' => 'required|string',
            'email' => 'required|email|unique:feedback,email',
        ]);

        // Create a new Feedback record
        $feedback = Feedback::create($validatedData);

        // Optionally, you can return a response or redirect as needed
        return response()->json(['message' => 'Feedback submitted successfully'], 201);
    }

    public function fetchFeedback()
    {
        $feedback = Feedback::all();

        return response()->json(['data' => $feedback], 200);
    }
}
