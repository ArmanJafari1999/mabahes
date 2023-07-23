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

class users_controller extends Controller
{
    public function get_users()
    {
        if(Auth::user()->role != "admin")
            return response()->json([]);
        $users = User::select('id', 'name')->get();
        return response()->json($users);
    }
    public function find_users(Request $request)
    {
        if(Auth::user()->role != "admin")
            return response()->json([]);
        $users = User::select('id', 'name')
        ->whereRaw('name LIKE ? AND phone_number LIKE ? AND email LIKE ?', ['%'.$request->input('name').'%','%'.$request->input('phone_number').'%','%'.$request->input('email').'%'])
        ->orderByDesc('id')
        ->get();
        return response()->json($users);
    }
}
