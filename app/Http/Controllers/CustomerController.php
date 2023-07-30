<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
class CustomerController extends Controller
{
    public function addCustomer(Request $request){
       
        $validate = $request->validate([
            'customerName' => 'required|string|max:50',
            'phoneNum' => 'required|integer',
            'address' => 'required|string|max:100'
        ]);

        $user_id = $request->input('user_id');
        try{
        $customer = Customer::create([
            'user_id' => $user_id,
            'customerName' => $validate['customerName'],
            'phoneNum' => $validate['phoneNum'],
            'address' => $validate['address']
        ]);

        return response() -> json([
            'status' => 'OK',
            'customer' => $customer
        ], 200);
        }
       catch(\Exception $e){
        return response()->json([
            'error' => $e
        ]);
       }
    }
}
