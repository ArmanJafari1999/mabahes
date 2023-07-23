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

class cars_controller extends Controller
{
    public function add_car(Request $request)
    {
        $cars = new cars;
        $cars->model = $request->input('model');
        $cars->owner_id = Auth::id();
        $cars->color = $request->input('color');
        if($cars->save()){
            return array('color'=>'green','message'=>'ماشین شما ثبت شد');
        } else {
            return array('color'=>'red','message'=>'ماشین شما ثبت نشد!!!');
        }
    }
    public function get_my_cars()
    {
        $cars = Auth()->user()->cars;
        return response()->json($cars);
    }
    public function get_all_cars()
    {
        if(Auth::user()->role != "admin")
            abort(404);
        $cars = DB::table('cars')->get();
        return response()->json($cars);
    }
    public function delete_car($id)
    {
        $Car = Cars::find($id);
        if ($Car==null)
            return array('color'=>'gold','message'=>'ماشین پیدا نشد!!!');
        if($Car->owner_id != Auth::id())
            return array('color'=>'red','message'=>'این ماشین متعلق به شما نیست');
        $Car->is_delete = true;
        if($Car->save()){
            return array('color'=>'green','message'=>'ماشین حذف شد');
        } else {
            return array('color'=>'red','message'=>'ماشین حذف نشد!!!');
        }
    }
    public function find_cars(Request $request)
    {
        if(Auth::user()->role != "admin")
            return response()->json([]);
        $cars = DB::table('cars')
        ->join('users', 'users.id', '=', 'cars.owner_id')
        ->select('cars.*', 'users.name as u_name')
        ->where('model', 'like', '%'.$request->input('model').'%')
        ->where('color', 'like', '%'.$request->input('color').'%')
        ->orderBy('id', 'desc')
        ->get();
        return response()->json($cars);
    }
}
