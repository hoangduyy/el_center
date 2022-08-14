<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TimeKeeping extends Model
{
    use HasFactory;

    public $fillable = [
        "type",
        "user_id",
        "compare_time",
    ];
    public $timestamps = true;

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
