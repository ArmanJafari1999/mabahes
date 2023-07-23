<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
    use HasFactory;
    public function repairs()
    {
        return $this->hasMany(Repairs::class,'order_id');
    }
    public function car_parts()
    {
        return $this->hasMany(Car_parts::class,'order_id');
    }
    public function car()
    {
        return $this->hasOne(Cars::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    protected $fillable = ['car_id', 'user_id', 'problem', 'time_for_visit', 'price', 'time_for_take_car', 'is_done'];
}
