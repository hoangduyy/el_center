<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;


class Admin extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    use SoftDeletes;

    protected $table = 'admin';

    const ROLE_ADMIN = 'admin';
    const ROLE_MANAGE = 'manage';

    protected $fillable = [
        'name',
        'email',
        'password',
    ];
}
