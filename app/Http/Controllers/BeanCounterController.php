<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BeanCount;
use App\Models\BeanData;
use App\Models\BeanDataTwo;
use App\Models\Status;
class BeanCounterController extends Controller
{
    public function fetchBeanCount($machineID)
    {
        // Get the latest BeanData for the specified machineID
        $latestBeanData = BeanData::where('machineID', $machineID);

        // Get the latest overall BeanData
        $latestOverallBeanData = $latestBeanData->latest()->first();

        // Get all BeanData records for the specified machineID
        $allBeans = BeanData::where('machineID', $machineID)->get();

        // Get all finished statuses
        $finishedStatus = Status::where('status', 'Finished')->get();

        // Calculate total kilos of beans
        $totalBeans = $finishedStatus->sum('kiloOfBeans');

        // Calculate total kilos of good beans
        $intTotalBeans = intval($totalBeans * 1000);
        $goodBeans = $intTotalBeans - $latestOverallBeanData->bad * 0.5;

        // Return the response
        return response()->json([
            'beans' => $latestOverallBeanData,
            'allBeans' => $allBeans,
            'goodbeans' => round($goodBeans),
            'status' => $finishedStatus,
            'total' => $totalBeans
        ]);
    }

    public function postBeanCount(Request $request){
        $machineID = $request->input('machineID');
        $bad = $request->input('bad');

        $beanData = BeanData::create([
            'machineID' => $machineID,
            'bad' => $bad
        ]);

        return response()->json([
            'message' => 'OK',
            'data' => $beanData
        ], 200);
    }

    public function secondPostBeanCount(Request $request){
        $machineID = $request->input('machineID');
        $bad = $request->input('bad');

        $beanData = BeanDataTwo::create([
            'machineID' => $machineID,
            'bad' => $bad
        ]);

        return response()->json([
            'message' => 'OK',
            'data' => $beanData
        ], 200);
    }
}
