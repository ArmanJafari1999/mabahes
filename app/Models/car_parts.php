<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class car_parts extends Model
{
    use HasFactory;
    public function orders()
    {
        return $this->belongsTo(Orders::class);
    }
    protected $fillable = ['order_id', 'name', 'price'];
}
