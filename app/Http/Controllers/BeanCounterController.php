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
        $id = $request->input('id');
        $good = $request->input('good');
        $bad = $request->input('bad');

        $beanData = BeanData::create([
            //'id' => $id,
            'good' => $good,
            'bad' => $bad
        ]);

        return response()->json([
            'message' => 'OK',
            'data' => $beanData
        ], 200);
    }
}
