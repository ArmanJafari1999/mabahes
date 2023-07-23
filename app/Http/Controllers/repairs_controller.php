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

class repairs_controller extends Controller
{
    public function add_repair(Request $request)
    {
        if(Auth::user()->role != "admin")
            return array('color'=>'red','message'=>'شما ثبت تعمیر را ندارید');
        $order = Orders::find($request->input('order_id'));
        if($order == null)
            return array('color'=>'gold','message'=>'سفارش پیدا نشد!!!');
        $repair = new repairs;
        $repair->order_id = $request->input('order_id');
        $repair->text = $request->input('text');
        $repair->price = $request->input('price');
        if($repair->save()){
            return array('color'=>'green','message'=>'تعمیر شما ثبت شد');
        } else {
            return array('color'=>'red','message'=>'تعمیر شما ثبت نشد!!!');
        }
    }
    public function get_my_repairs(Request $request)
    {
        $order = Orders::find($request->input('order_id'));
        if($order == null)
            return response()->json([]);
        if(Auth::user()->role != "admin" && $order->user_id != Auth::id())
            return response()->json([]);
        $repairs = $order->repairs;
//        $repairs = repairs::select('id', 'created_at', 'text', 'price')->where('order_id', $request->input('order_id'))->get();
        return response()->json($repairs);
    }
    public function delete_repair($id)
    {
        if(Auth::user()->role != "admin")
            return array('color'=>'red','message'=>'شما اجازه حذف تعمیر را ندارید');
        $repair = repairs::find($id);
        if($repair ==  null)
            return array('color'=>'gold','message'=>'قطعه پیدا نشد!!!');
        $order = Orders::find($repair->order_id);
        if($order == null)
            return array('color'=>'gold','message'=>'سفارش پیدا نشد!!!');
        if($repair->delete()){
            return array('color'=>'green','message'=>'تعمیر حذف شد');
        } else {
            return array('color'=>'red','message'=>'تعمیر حذف نشد!!!');
        }
    }
}
