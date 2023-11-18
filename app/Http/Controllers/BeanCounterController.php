<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BeanCount;
use App\Models\BeanData;
use App\Models\Status;
class BeanCounterController extends Controller
{
    public function fetchBeanCount(){
        $bean = BeanData::latest()->first();
        $finishedStatus = Status::where('status', 'Finished')->get();
        $totalBeans = $finishedStatus->sum('kiloOfBeans');
        $intTotalBeans = intval($totalBeans * 1000);
        $goodBeans = floatval($intTotalBeans) - floatval($bean->bad) * 0.5;
        return response()->json([
            'beans' => $bean,
            'goodbeans' => round($goodBeans),
            'status' => $finishedStatus,
            'total' => $totalBeans
        ]);
    }

    public function postBeanCount(Request $request){
        $bad = $request->input('bad');

        $beanData = BeanData::create([
            'bad' => $bad
        ]);

        return response()->json([
            'message' => 'OK',
            'data' => $beanData
        ], 200);
    }
}
