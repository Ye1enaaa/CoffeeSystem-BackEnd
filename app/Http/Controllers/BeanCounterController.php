<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BeanCount;
use App\Models\BeanData;
class BeanCounterController extends Controller
{
    public function fetchBeanCount(){
        $bean = BeanCount::latest()->first();

        return response()->json([
            'beans' => $bean
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
