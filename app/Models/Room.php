<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;
    protected $table="rooms";
    protected $fillable = ["name","description","branch_id"];


    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function classes()
    {
        return $this->hasMany(ClassRoom::class);
    }

    public function rooms()
    {
        return $this->hasMany(RoomHistory::class);
    }
}
