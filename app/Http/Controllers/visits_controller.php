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

class visits_controller extends Controller
{
    public function add_visit(Request $request)
    {
        $car = Cars::find($request->input('car_id'));
        if($car==null)
            return array('color'=>'red','message'=>'ماشین پیدا نشد!!!');
        if($car->owner_id != Auth::id())
            return array('color'=>'blue','message'=>'این ماشین متعلق به شما نیست');
        $Orders = new Orders;
        $Orders->car_id = $request->input('car_id');
        $Orders->user_id = Auth::id();
        $Orders->time_for_visit = $request->input('time_for_visit');
        $Orders->problem = $request->input('problem');
        $Orders->price = 185000;
        $Orders->date = $request->input('date');
        $Orders->time = $request->input('time');
        $Orders->time_for_take_car = "-";
        $Orders->is_done = false;
        if($Orders->save()){
            return array('color'=>'green','message'=>'زمان ملاقات شما ثبت شد');
        } else {
            return array('color'=>'red','message'=>'زمان ملاقات شما ثبت نشد!!!');
        }
    }
    public function get_visit_times(Request $request)
    {
        $orders = Orders::select('id', 'time_for_visit')->where('time_for_visit', 'LIKE', $request->input('time_for_visit')."%")->get();
        return response()->json($orders);
    }
    public function get_my_visits()
    {
        $orders = DB::table('orders')
           ->join('cars', 'cars.id', '=', 'orders.car_id')
           ->select('orders.*', 'cars.model as c_model')
           ->where('orders.user_id', Auth::id())
           ->get();
        return response()->json($orders);
    }
    public function get_all_visits()
    {
        if(Auth::user()->role != "admin")
            return response()->json([]);
        $orders = DB::table('orders')
            ->join('cars', 'cars.id', '=', 'orders.car_id')
            ->join('users', 'users.id', '=', 'orders.user_id')
            ->select('orders.*', 'cars.model as c_model', 'users.name as u_name')
            ->orderBy('orders.time_for_visit')
            ->get();
        return response()->json($orders);
    }
    public function update_time_for_take_car(Request $request)
    {
        if(Auth::user()->role != "admin")
            return array('color'=>'red','message'=>'شما اجازه تغییر زمان تحویل را ندارید');
        $order = Orders::find($request->input('id'));
        if($order==null)
            return array('color'=>'red','message'=>'سفارش پیدا نشد!!!');
        $order->time_for_take_car = $request->input('time_for_take_car');
        if($order->save()){
            return array('color'=>'green','message'=>'زمان تحویل ماشین ثبت شد');
        } else {
            return array('color'=>'red','message'=>'زمان تحویل ماشین ثبت نشد!!!');
        }
    }
    public function get_car_visits(Request $request)
    {
        $car = Cars::find($request->input('id'));
        if($car == null)
            return response()->json([]);
        if($car->owner_id != Auth::id())
            return response()->json([]);
        $orders = DB::table('orders')->where('car_id', $request->input('id'))->get();
        return response()->json($orders);
    }
    public function delete_order(Request $request)
    {
        $order = Orders::find($request->input('id'));
        if(Auth::user()->role != "admin" && $order->user_id != Auth::id())
            return array('color'=>'red','message'=>'شما اجازه حذف این زمان ملاقات را ندارید');
        DB::table('repairs')->where('order_id', $request->input('id'))->delete();
        DB::table('car_parts')->where('order_id', $request->input('id'))->delete();
        if($order->delete()){
            return array('color'=>'green','message'=>'زمان ملاقات شما کنسل شد');
        } else {
            return array('color'=>'red','message'=>'زمان ملاقات شما کنسل نشد!!!');
        }
    }
    public function get_today_visits()
    {
        if(Auth::user()->role != "admin")
            return response()->json([]);
        include('jdf.php');
        $orders = DB::table('orders')
            ->join('cars', 'cars.id', '=', 'orders.car_id')
            ->join('users', 'users.id', '=', 'orders.user_id')
            ->select('orders.*', 'cars.model as c_model', 'users.name as u_name')
            ->where('date', jdate('Y')."/".jdate('m')."/".jdate('d'))
            ->orderBy('date', 'desc')
            ->get();
        return response()->json($orders);
    }
    public function get_user_visits(Request $request)
    {
        if(Auth::user()->role != "admin")
            return response()->json([]);
        $orders = DB::table('orders')
            ->join('cars', 'cars.id', '=', 'orders.car_id')
            ->select('orders.*', 'cars.model as c_model')
            ->where('orders.user_id', $request->input('id'))
            ->get();
        return response()->json($orders);
    }
    public function get_car_visits_manager(Request $request)
    {
        if(Auth::user()->role != "admin")
            return response()->json([]);
        $orders = DB::table('orders')
            ->join('users', 'users.id', '=', 'orders.user_id')
            ->select('orders.*', 'users.name as u_name')
            ->where('orders.car_id', $request->input('id'))
            ->get();
        return response()->json($orders);
    }
}
