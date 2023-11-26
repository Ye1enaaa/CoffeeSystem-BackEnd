<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sorter;
class SorterController extends Controller
{
    public function addSorter(Request $request){
        $validate = $request->validate([
            'sorterName' => 'required|string|max:50',
            'phoneNum' => 'required|string',
            'address' => 'required|string|max:100',
            'dateHired' => 'required'
        ]);
        $user_id = $request->input('user_id');
        $sorter = Sorter::create([
            'user_id' => $user_id,
            'sorterName' => $validate['sorterName'],
            'phoneNum' => $validate['phoneNum'],
            'address' => $validate['address'],
            'dateHired' => $validate['dateHired']
        ]);
        return response() -> json([
            'status' => 'OK',
            'sorter' => $sorter
        ], 200);
    }

    public function fetchSorters($user_id){
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
