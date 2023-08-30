<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sorter;
use App\Models\Status;
class StatusController extends Controller
{
    public function postStatus(Request $request){
        $user_id = $request->input('user_id');
        $customerName = $request->input('customerName');
        $sorterName = $request->input('sorterName');
        $status = $request->input('status');

        $stats = Status::create([
            'user_id' => $user_id,
            'customerName' => $customerName,
            'sorterName' => $sorterName,
            'status' => $status
        ]);

        return response() -> json([
            'status' => 'OK',
            'stats' => $stats
        ], 200);
    }

    public function fetchStatus($user_id){
        $status = Status::where('user_id', $user_id)->get();
        return response() -> json([
            'status' => $status
        ], 200);
    }
}
