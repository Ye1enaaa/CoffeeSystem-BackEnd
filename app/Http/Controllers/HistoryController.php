<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\History;
use App\Models\Customer;
class HistoryController extends Controller
{
    
    public function fetchHistoryOfCustomer($user_id, $id){
        $customer = Customer::with('history')
            ->where('user_id', $user_id)
            ->find($id);

        if(!$customer){
            return response() -> json([
                'message' => 'Customer Not Found'
            ], 404);    
        }

        if(!$customer->history){
            return response() -> json([
                'message' => 'Customer History Not Found'
            ], 404);    
        }

        return response() -> json([
            'history' => $customer->history
        ], 200);
    }
}
