<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Carbon\Carbon;
class User extends Authenticatable
{

    public $timestamps = false;
    protected $table = 'usuarios'; 

    protected $fillable = [
        'NOMBRE', 'CONTRASENA', 'EMAIL', 'ROL', 
    ];

    public function getAuthPassword()
    {
        return $this->CONTRASENA;
    }

   
}


