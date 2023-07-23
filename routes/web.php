<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\comments_controller;
use App\Http\Controllers\visits_controller;
use App\Http\Controllers\cars_controller;
use App\Http\Controllers\car_parts_controller;
use App\Http\Controllers\repairs_controller;
use App\Http\Controllers\times_controller;
use App\Http\Controllers\users_controller;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
})->name('welcome');;

Route::get('/welcome', function () {
    return view('welcome');
})->name('welcome');;

Route::get('/about_us', function () {
    return view('about_us');
})->name('about_us');

Route::get('/comments', function () {
    return view('comments');
})->name('comments');

Route::get('/my_visits', function () {
    return view('my_visits');
})->middleware(['auth', 'verified'])->name('my_visits');

Route::get('/car_visits', function () {
    return view('car_visits');
})->middleware(['auth', 'verified'])->name('car_visits');

Route::get('/visits', function () {
    return view('visits');
})->middleware(['auth', 'verified'])->name('visits');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/all_site_visits', function () {
    return view('all_site_visits');
})->middleware(['auth', 'verified'])->name('all_site_visits');

Route::get('/manage_visit', function () {
    return view('manage_visit');
})->middleware(['auth', 'verified'])->name('manage_visit');

Route::get('/manage_times', function () {
    return view('manage_times');
})->middleware(['auth', 'verified'])->name('manage_times');

Route::get('/show_visit', function () {
    return view('show_visit');
})->middleware(['auth', 'verified'])->name('show_visit');

Route::get('/my_cars', function () {
    return view('my_cars');
})->middleware(['auth', 'verified'])->name('my_cars');

Route::get('/manager', function () {
    return view('manager');
})->middleware(['auth', 'verified'])->name('manager');

Route::get('/users_visits', function () {
    return view('users_visits');
})->middleware(['auth', 'verified'])->name('users_visits');

Route::get('/cars_visits', function () {
    return view('cars_visits');
})->middleware(['auth', 'verified'])->name('cars_visits');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::post('/addcomment', [comments_controller::class, 'add_comment'])->name('addcomment');
Route::get('/getallcomments', [comments_controller::class, 'getComments'])->name('getallcomments');
//Route::get('/getallcomments', 'comments_controller@getComments');

Route::post('/addcar', [cars_controller::class, 'add_car'])->name('addcar');
Route::post('/getmycars', [cars_controller::class, 'get_my_cars'])->name('getmycars');
Route::delete('/deletecar/{id}', [cars_controller::class, 'delete_car'])->name('deletecar');
Route::get('/getallcars', [cars_controller::class, 'get_all_cars'])->name('getallcars');
Route::post('/findcars', [cars_controller::class, 'find_cars'])->name('findcars');

Route::post('/addvisit', [visits_controller::class, 'add_visit'])->name('addvisit');
Route::post('/getvisittimes', [visits_controller::class, 'get_visit_times'])->name('getvisittimes');
Route::get('/getmyvisits', [visits_controller::class, 'get_my_visits'])->name('getmyvisits');
Route::get('/getallvisits', [visits_controller::class, 'get_all_visits'])->name('getallvisits');
Route::post('/update_time_for_take_car', [visits_controller::class, 'update_time_for_take_car'])->name('update_time_for_take_car');
Route::post('/deleteorder', [visits_controller::class, 'delete_order'])->name('deleteorder');
Route::post('/getcarvisits', [visits_controller::class, 'get_car_visits'])->name('getcarvisits');
Route::get('/gettodayvisits', [visits_controller::class, 'get_today_visits'])->name('gettodayvisits');
Route::post('/getuservisits', [visits_controller::class, 'get_user_visits'])->name('getuservisits');
Route::post('/getcarvisitsmanager', [visits_controller::class, 'get_car_visits_manager'])->name('getcarvisitsmanager');

Route::post('/add_car_part', [car_parts_controller::class, 'add_car_part'])->name('add_car_part');
Route::post('/get_my_car_parts', [car_parts_controller::class, 'get_my_car_parts'])->name('get_my_car_parts');
Route::delete('/delete_car_part/{id}', [car_parts_controller::class, 'delete_car_part'])->name('delete_car_part');

Route::post('/add_repair', [repairs_controller::class, 'add_repair'])->name('add_repair');
Route::post('/get_my_repairs', [repairs_controller::class, 'get_my_repairs'])->name('get_my_repairs');
Route::delete('/delete_repair/{id}', [repairs_controller::class, 'delete_repair'])->name('delete_repair');

Route::post('/addtimes', [times_controller::class, 'add_times'])->name('addtimes');
Route::get('/gettimes', [times_controller::class, 'get_times'])->name('gettimes');
Route::get('/getfreetimes', [times_controller::class, 'get_free_times'])->name('getfreetimes');

Route::get('/getusers', [users_controller::class, 'get_users'])->name('getusers');
Route::post('/findusers', [users_controller::class, 'find_users'])->name('findusers');

require __DIR__.'/auth.php';
