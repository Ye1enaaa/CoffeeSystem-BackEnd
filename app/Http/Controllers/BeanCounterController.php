<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BeanCount;
class BeanCounterController extends Controller
{
    public function fetchBeanCount(){
        $bean = BeanCount::latest()->first();

        return response()->json([
            'beans' => $bean
        ]);
    }
}
