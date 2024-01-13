<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BeanCount;
use App\Models\BeanData;
use App\Models\BeanDataTwo;
use App\Models\Status;
use App\Models\Customer;
class BeanCounterController extends Controller
{
    // public function fetchBeanCount($machineID, $userId)
    // {
    //     // Get the latest BeanData for the specified machineID
    //     $latestBeanData = BeanData::where('machineID', $machineID);
    //     $latestBeanDataTwos = BeanDataTwo::where('machineID', $machineID);

    //     // Get the latest overall BeanData
    //     $latestOverallBeanData = $latestBeanData->latest()->first();

    //     // Get the latest overall BeanDataTwo
    //     $latestOverallBeanDataTWo = $latestBeanDataTwos->latest()->first();

    //     // Get all BeanData records for the specified machineID
    //     $allBeans = BeanData::where('machineID', $machineID)->get();

    //     $finishedStatus = Status::where('user_id', $userId)
    //                    ->where('status', 'Finished')
    //                    ->get();

    //     // Calculate total kilos of bad beans
    //     $totalBeans = $finishedStatus->sum('kiloOfBeans');

    //     // Convert kilo to grams
    //     $intTotalBeans = intval($totalBeans * 1000);

    //     //convert to grams to kilo
    //     $totalBad = $latestOverallBeanData->bad + $latestOverallBeanDataTWo->bad;
    //     $goodBeans = $intTotalBeans - $totalBad * 0.5;
    //     $kiloBeans = $totalBad * 0.5 / 1000;
    //     $kiloBeansTwo = $latestOverallBeanDataTWo->bad * 0.5 / 1000;
    //     $good = $intTotalBeans - $kiloBeans;
    //     $kiloBeans2 = $intTotalBeans - $kiloBeans;
    //     $TotalkiloBeans = $kiloBeans + $kiloBeans2;

    //     // Return the response
    //     return response()->json([
    //         'beans' => $latestOverallBeanData,
    //         'total' => $kiloBeans2,
    //         'TotalBadBeans' => $totalBad,
    //         'GramsBadBeans' => $kiloBeans,
    //         'kiloGoodBeans' => $good,
    //         // 'kiloBeans2' => $kiloBeans2,
    //         'allBeans' => $allBeans,
    //         'goodbeans' => round($goodBeans),
    //         'status' => $finishedStatus,
    //         'total' => $totalBeans
    //     ]);
    // }

    public function fetchBeanCount($machineID, $userId)
    {
        $statuses = Status::where('user_id', $userId)->get();
        
        $totalBadCount = 0;
        $totalGoodCount = 0;
        $totalKg = 0;

        foreach ($statuses as $status) {
            $totalBadCount += $status->badCount;
            $totalGoodCount += $status->goodCount;
            $totalKg += $status->kiloOfBeans;
        }
    
        return response()->json([
            'badBeans' => $totalBadCount,
            'goodBeans' => $totalGoodCount,
            'totalKg' => $totalKg
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

    public function insertBadCount(Request $request){
        $statusId = $request->input('statusId');
        $badCount = $request->input('bad');
        $customer = Status::where('id', $statusId)->first();
        
        $customer->badCount = $badCount;
        $customer->save();

        return response()->json([
            'msg' => $customer 
        ], 200);
    }
}
