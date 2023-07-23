<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cars extends Model
{
    use HasFactory;
    public function orders()
    {
        return $this->belongsToMany(Orders::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    protected $fillable = ['model', 'owner_id', 'color', 'is_delete'];
}
