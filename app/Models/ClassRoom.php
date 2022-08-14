<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ClassRoom extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "classes";
    protected $fillable = [
        "title", "thumbnail","note", "qty",
        "content", "start_date", "end_date",
        "slug", "description",
        "course_id","room_id","teacher_id",
        "utilities"
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function teacher()
    {
        return $this->belongsTo(Teacher::class,"teacher_id");
    }

    public function schedule()
    {
        return $this->hasOne(ClassSchedule::class, "class_id");
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

//    public function orders()
//    {
//        return $this->hasMany(Order::class, "class_id");
//    }
}
