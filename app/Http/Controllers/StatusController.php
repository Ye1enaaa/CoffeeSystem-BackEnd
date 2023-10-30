<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sorter;
use App\Models\Status;
use App\Models\Customer;
use App\Models\History;
class StatusController extends Controller
{
    public function postStatus(Request $request){
        $user_id = $request->input('user_id');
        $customerName = $request->input('customerName');
        $sorterName = $request->input('sorterName');
        $kiloOfBeans = $request->input('kiloOfBeans');
        $status = $request->input('status');

        $existingCustomer = Customer::where('user_id', $user_id)
            ->where('customerName', $customerName)
            ->first();

        if($existingCustomer){
            $history = History::create([
                'customer_id' => $existingCustomer->id,
                'sorterName' => $sorterName,
                'kiloOfBeans' => $kiloOfBeans,
                'status' => $status,
                'date' => now()
            ]);

            $stats = Status::create([
                'user_id' => $user_id,
                'customerName' => $customerName,
                'sorterName' => $sorterName,
                'kiloOfBeans' => $kiloOfBeans,
                'status' => $status
            ]);

            return response() -> json([
                'history' => $history,
                'status' => $stats
            ], 200);
        }

        // $stats = Status::create([
        //     'user_id' => $user_id,
        //     'customerName' => $customerName,
        //     'sorterName' => $sorterName,
        //     'kiloOfBeans' => $kiloOfBeans,
        //     'status' => $status
        // ]);

        // return response() -> json([
        //     'status' => 'OK',
        //     'stats' => $stats
        // ], 200);
    }

    public function fetchStatus($user_id){
        $status = Status::where('user_id', $user_id)->get();
        return response() -> json([
            'status' => $status
        ], 200);
    }

    public function fetchStatusByCustomer($id, $user_id){
        $status = Status::where('user_id', $user_id)->get();
        $statusByCustomer = $status->find($id);

        return response()->json([
            'customerStatus' => $statusByCustomer
        ], 200);
    }
}
