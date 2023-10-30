<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\History;
use Carbon\Carbon;
class CustomerController extends Controller
{
    // public function addCustomer(Request $request){
       
    //     $validate = $request->validate([
    //         'customerName' => 'required|string|max:50',
    //         'phoneNum' => 'required|string',
    //         'address' => 'required|string|max:100'
    //     ]);

    //     $user_id = $request->input('user_id');
    //     try{
    //     $customer = Customer::create([
    //         'user_id' => $user_id,
    //         'customerName' => $validate['customerName'],
    //         'phoneNum' => $validate['phoneNum'],
    //         'address' => $validate['address']
    //     ]);
    //     if($validate->fails()){
    //         return response()-> json([
    //             'error' => $validate->errors()
    //         ]);
    //     }
    //     return response() -> json([
    //         'status' => 'OK',
    //         'customer' => $customer
    //     ], 200);
    //     }
    //    catch(\Exception $e){
    //     return response()->json([
    //         'error' => $e
    //     ]);
    //    }
    // }


    public function getCustomerPostHistory(Request $request, $user_id){
        //$customerId = $request->input('customer_id');
        $user_id = $request->input('user_id');
        $customerName = $request->input('customerName');
        $phoneNum = $request->input('phoneNum');
        $address = $request->input('address');
        //$kiloOfBeans = $request->input('kiloOfBeans');
        $date = $request->input('date');

        $existingCustomer = Customer::where('user_id', $user_id)
            ->where('customerName', $customerName)
                ->first();

        if($existingCustomer){
            // $history = History::create([
            //     'customer_id' => $existingCustomer->id,
            //     'customerName' => $existingCustomer->customerName,
            //     'kiloOfBeans' => $kiloOfBeans,
            //     'date' => now()
            // ]);     
            return response() -> json([
                'error' => 'Customer is in the database already'
            ], 422);
        } else {
            $customer = Customer::create([
                'user_id' => $user_id,
                'customerName' => $customerName,
                'phoneNum' => $phoneNum,
                'address' => $address,
                //'kiloOfBeans' => $kiloOfBeans,
                'date' => now()
            ]);
            
            return response() -> json([
                'status' => 'OK',
                'customer' => $customer
            ], 200);
        }
        
        
    }


    public function fetchCustomers($user_id){
        // /$user_id = 1;
        $customer = Customer::where('user_id', $user_id)->get();
        return response() -> json([
            'customer' => $customer
        ]);
    }

    //update
    public function editCustomer(Request $request, $id)
    {
        $customer = Customer::where('id', $id)->first();
        
        try {
            // Update the user details
            $customer->update($request->all());
            return response()->json([
                'status' => 'Customer updated successfully',
                'customer' => $customer
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ]);
        }
    }

    //delete
    public function deleteCustomer($id){
        $customer = Customer::findOrFail($id);
        $deleted = $customer->delete();
        return response() -> json([
            'deleted' => $deleted,
            'status' => 'Deleted'
        ], 200);
    }
}
