<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sorter;
use App\Models\Status;
class StatusController extends Controller
{
    public function postStatus(Request $request){
        $customerName = $request->input('customerName');
        $sorterName = $request->input('sorterName');
        $status = $request->input('status');

        $stats = Status::create([
            'customerName' => $customerName,
            'sorterName' => $sorterName,
            'status' => $status
        ]);

        return response() -> json([
            'status' => 'OK',
            'stats' => $stats
        ], 200);
    }
}
