<?php

namespace App\Http\Controllers\Operate;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RealTimeController extends Controller
{
    public function RealTime() 
    {
        
        return view('Operate.realtime');
        
    }
   
    public function RealTimeDesc() 
    {
        return view('Operate.realtimestatistics');
    }
    
    public function RealTimePbDesc(Request $request) 
    {
        $array=array(
            'pbid'=>$request->input('f-channel')
        );
        return view('Operate.realtimestatisticspb',$array);
    }
    
    public function RealTimeBussDesc(Request $request) 
    {
        $array=array(
            'pbid'=>$request->input('f-channel'),
            'bussid'=>$request->input('s-channel')
        );
        return view('Operate.realtimestatisticsbuss',$array);
    }
}
