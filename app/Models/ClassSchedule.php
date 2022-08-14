<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ClassSchedule extends Model
{
    use HasFactory;

    use SoftDeletes;

    protected $table="class_schedules";

    protected $fillable = ["class_id", "teacher_id", "room_id", "time_id"];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function class()
    {
        return $this->belongsTo(ClassRoom::class);
    }

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function details()
    {
        return $this->hasMany(ClassScheduleDetail::class,"schedule_id");
    }


}
