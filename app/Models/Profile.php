<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;

    protected $primaryKey = 'user_id';
    
    public $incrementing = false;

    public function user()
    {
        
        return $this->belongsTo(User::class, 'user_id', 'id')->withDefault();
        // withDefault() Apply Only  the two method 1- hasOne 2- belongsTo
    }
}
