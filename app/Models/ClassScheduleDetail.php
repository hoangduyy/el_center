<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ClassScheduleDetail extends Model
{
    use HasFactory;

    use SoftDeletes;

    protected $table="class_schedule_details";

    protected $fillable = ["day_id", "schedule_id"];

    public function schedule()
    {
        return $this->belongsTo(ClassSchedule::class);
    }
}
