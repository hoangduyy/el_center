<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentPoint extends Model
{
    use HasFactory;
    protected $table="student_points";
    protected $fillable = ["note","point","class_id","teacher_id","student_id",
        "listen",
        "speak",
        "read",
        "write",
    ];


    public function student()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public function teacher()
    {
        return $this->belongsTo(User::class,'teacher_id');
    }

    public function class()
    {
        return $this->belongsTo(ClassRoom::class);
    }


}
