<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Sorter;
class SorterController extends Controller
{

    public function addSorter(Request $request){
        $user_id = $request->input('user_id');
        $sorterName = $request->input('sorterName');
        $phoneNum = $request->input('phoneNum');
        $address = $request->input('address');
        $dateHired = $request->input('dateHired');

        $user_id = $request->input('user_id');
        $existingSorter = Sorter::where('user_id', $user_id)
            ->where('sorterName', $sorterName)
            ->first();

        if($existingSorter){  
            return response() -> json([
                'error' => 'Sorter is in the database already'
            ], 422);
        } else {
            $sorter = Sorter::create([
                'user_id' => $user_id,
                'sorterName' => $sorterName,
                'phoneNum' => $phoneNum,
                'address' => $address,
                'dateHired' => $dateHired
            ]);
                    
            return response() -> json([
                'status' => 'succeeded',
                'sorter' => $sorter
            ], 200);
        }
    }

    public function fetchSorters($user_id)
    {
        $sorters = Sorter::where('user_id', $user_id)->get();

        if ($sorters->isEmpty()) {
            return response()->json([
                'status' => 'Sorters Not Found'
            ], 404);
        }

        return response() -> json([
            'sorters' => $sorters
        ], 200);
    }

     //update
     public function editSorter(Request $request, $id)
     {
         $sorters = Sorter::where('id', $id)->first();
         
         try {
             // Update the user details
             $sorters->update($request->all());
             return response()->json([
                 'status' => 'Sorter updated successfully',
                 'sorters' => $sorters
             ]);
         } catch (\Exception $e) {
             return response()->json([
                 'error' => $e->getMessage()
             ]);
         }
     }
}
