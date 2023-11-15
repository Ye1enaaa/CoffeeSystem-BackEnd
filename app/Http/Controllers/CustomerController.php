<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\History;
use App\Models\Archived;
use App\Models\Status;
use App\Models\ArchivedStatusHistory;
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

    public function archiveCustomerbadrequestdontusethis(Request $request, $id)
    {
        $customer = Customer::find($id);

        if (!$customer) {
            return response()->json([
                'error' => 'Customer not found',
            ], 404);
        }

        // Archive the customer by moving them to the archived table.
        $archivedCustomer = new Archived($customer->toArray());
        $archivedCustomer->customer_id = $id;
        $archivedCustomer->save();

        $customerInfo = $customer->customerName;
        $customerStatus = Status::where('customerName', $customerInfo)->first();

        if (!$customerStatus) {
            return response()->json([
                'error' => 'No status data found for the customer',
            ], 400);
        }

        $customerStatuses = Status::where('customer_id', $customerStatus->customer_id)->get();

        // Save each status record to archived_status_histories
        $archivedStatusHistories = [];  // Create an array to store archived status
        foreach ($customerStatuses as $status) {
            $archived_status = new ArchivedStatusHistory($status->toArray());
            $archived_status->customer_id = $archivedCustomer->customer_id;
            $archived_status->status_id = $status->id;

            $archivedStatusHistories[] = $archived_status;  // Add each archived status to the array
            $status->delete(); 
        }

        // Convert the array of objects into an array of associative arrays
        $recordsToInsert = [];
        foreach ($archivedStatusHistories as $archived_status) {
            $recordsToInsert[] = $archived_status->toArray();
        }

        
        // Now, save all the archived status histories in one go
        ArchivedStatusHistory::insert($recordsToInsert);
        // $customerStatuses->delete(); 
        $customer->delete();
        
        return response()->json([
            'status' => 'Customer and associated histories archived successfully',
            'archivedCustomer' => $archivedCustomer,
            'customerStatuses' => $customerStatuses,
            'archived_status' => $recordsToInsert
        ]);
    }

    public function archiveCustomer(Request $request, $id)
    {
        $customer = Customer::find($id);

        if (!$customer) {
            return response()->json([
                'error' => 'Customer not found',
            ], 404);
        }

        // Archive the customer by moving them to the archived table.
        $archivedCustomer = new Archived($customer->toArray());
        $archivedCustomer->customer_id = $id;
        $archivedCustomer->save();

        // Check if there is any data related to the customer in the Status table
        $customerInfo = $customer->customerName;
        $customerStatus = Status::where('customerName', $customerInfo)->first();

        if ($customerStatus) {
            // If status data found, proceed with archival process

            $customerStatuses = Status::where('customer_id', $customerStatus->customer_id)->get();

            // Save each status record to archived_status_histories
            $archivedStatusHistories = [];  // Create an array to store archived status
            foreach ($customerStatuses as $status) {
                $archived_status = new ArchivedStatusHistory($status->toArray());
                $archived_status->customer_id = $archivedCustomer->customer_id;
                $archived_status->status_id = $status->id;

                $archivedStatusHistories[] = $archived_status;  // Add each archived status to the array
                $status->delete(); 
            }

            // Convert the array of objects into an array of associative arrays
            $recordsToInsert = [];
            foreach ($archivedStatusHistories as $archived_status) {
                $recordsToInsert[] = $archived_status->toArray();
            }

            // Now, save all the archived status histories in one go
            ArchivedStatusHistory::insert($recordsToInsert);
        }

        // Delete the customer regardless of the status data
        $customer->delete();

        return response()->json([
            'status' => 'Customer and associated histories archived successfully',
            'archivedCustomer' => $archivedCustomer ?? null,
            'customerStatuses' => $customerStatuses ?? null,
            'archived_status' => $recordsToInsert ?? null
        ]);
    }

    


    public function fetchArchiveds($user_id){
        $archivedCustomer = Archived::where('user_id', $user_id)->get();
        return response() -> json([
            'archiveds' => $archivedCustomer
        ]);
    }

    public function fetchStatusArchive($user_id){
        $archived_status = ArchivedStatusHistory::where('user_id', $user_id)->get();
        return response() -> json([
            'archived_status' => $archived_status
        ]);
    }

    //delete
    public function deleteCustomer($id){
        $archivedCustomer = Archived::findOrFail($id);
        $deleted = $archivedCustomer->delete();
        return response() -> json([
            'deleted' => $deleted,
            'status' => 'Deleted',
            'archiveds' => $archivedCustomer
        ], 200);
    }

    //delete
    public function deleteStatus($id){
        $archived_status = ArchivedStatusHistory::findOrFail($id);
        $deleted = $archived_status->delete();
        return response() -> json([
            'deleted' => $deleted,
            'status' => 'Deleted',
            'archiveds' => $archived_status
        ], 200);
    }
}
