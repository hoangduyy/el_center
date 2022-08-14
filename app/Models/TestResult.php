<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;


class TestResult extends Authenticatable
{
    use SoftDeletes;

    protected $table = 'test_result';

    protected $fillable = [
        'user_id',
        'question_id',
        'user_da',
        'question_da',
    ];
}
