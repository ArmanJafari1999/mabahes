<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Cars;
use App\Models\Orders;
use App\Models\car_parts;
use App\Models\repairs;
use App\Models\Times;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class times_controller extends Controller
{
    public function add_times(Request $request)
    {
        if(Auth::user()->role != "admin")
            return array('color'=>'red','message'=>'شما اجازه ثبت زمان ویزیت را ندارید');
        DB::table('times')->where('date', $request->input('date'))->delete();
        $times = json_decode($request->input('times'));
        $date = $request->input('date');
        for($i=0;$i<count($times);$i++){
            $time = new Times;
            $time->date = $date;
            $time->time = $times[$i];
            if(!$time->save())
                return array('color'=>'red','message'=>'زمان ملاقات '.$times[$i].' ثبت نشد!!!');
        }
        return array('color'=>'green','message'=>'زمان‌ها ثبت شدند');
    }
    public function get_times(Request $request)
    {
        if(Auth::user()->role != "admin")
            return response()->json([]);
        $Times = Times::select('id', 'date', 'time')->where('date', $request->input('date'))->get();
        return response()->json($Times);
    }
    public function get_free_times(Request $request)
    {
        $times = DB::select("
        SELECT t.*
        FROM times t
        LEFT JOIN orders o ON t.date = o.date AND t.time = o.time
        WHERE t.date = ? AND (o.date IS NULL OR o.time IS NULL)",
        [$request->input('date'),]);
        return response()->json($times);
    }
}
