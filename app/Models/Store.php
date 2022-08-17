<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User;

class Store extends User implements MustVerifyEmail
{
    use HasFactory;

    protected $table = 'stores';

    protected $primaryKey = 'id';
}
