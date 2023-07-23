<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Cars;
use App\Models\Orders;
use App\Models\car_parts;
use App\Models\repairs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class car_parts_controller extends Controller
{
    public function add_car_part(Request $request)
    {
        if(Auth::user()->role != "admin")
            return array('color'=>'red','message'=>'شما اجازه ثبت قطعه ندارید');
        $order = Orders::find($request->input('order_id'));
        if($order == null)
            return array('color'=>'gold','message'=>'سفارش پیدا نشد!!!');
        $car_part = new car_parts;
        $car_part->order_id = $request->input('order_id');
        $car_part->name = $request->input('name');
        $car_part->price = $request->input('price');
        if($car_part->save()){
            return array('color'=>'green','message'=>'ماشین شما ثبت شد');
        } else {
            return array('color'=>'red','message'=>'ماشین شما ثبت نشد!!!');
        }
    }
    public function get_my_car_parts(Request $request)
    {
        $order = Orders::find($request->input('order_id'));
        if($order == null)
            return response()->json([]);
        if(Auth::user()->role != "admin" && $order->user_id != Auth::id())
            return response()->json([]);
        $car_parts = $order->car_parts;
//        $car_parts = car_parts::select('id', 'created_at', 'name', 'price')->where('order_id', $request->input('order_id'))->get();
        return response()->json($car_parts);
    }
    public function delete_car_part($id)
    {
        if(Auth::user()->role != "admin")
            return array('color'=>'red','message'=>'شما اجازه حذف قطعه ندارید');
        $car_part = car_parts::find($id);
        if($car_part ==  null)
            return array('color'=>'gold','message'=>'قطعه پیدا نشد!!!');
        $order = Orders::find($car_part->order_id);
        if($order == null)
            return array('color'=>'gold','message'=>'سفارش پیدا نشد!!!');
        if($car_part->delete()){
            return array('color'=>'green','message'=>'قطعه حذف شد');
        } else {
            return array('color'=>'red','message'=>'قطعه حذف نشد!!!');
        }
    }
}
