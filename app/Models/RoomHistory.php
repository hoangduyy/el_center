<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoomHistory extends Model
{
    use HasFactory;
    protected $table = "room_histories";
    protected $fillable = [
        "start_date","end_date", "days","start_hour", "end_hour",
        "room_id"
    ];


    public function room()
    {
        return $this->belongsTo(Room::class);
    }
}
