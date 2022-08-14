<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Cart extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'cart';

    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'class_id',
    ];
}
