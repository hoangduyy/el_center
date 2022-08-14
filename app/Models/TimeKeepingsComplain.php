<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TimeKeepingsComplain extends Model
{
    use HasFactory;

    public $timestamp = true;
    public $fillable = [
        "user_id",
        "date",
        "complain",
        "reply",
    ];

    protected $casts = [
        'date'  => 'date:d-m-Y',
    ];
}
