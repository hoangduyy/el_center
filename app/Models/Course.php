<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Course extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "courses";

    protected $fillable = [
        "title", "thumbnail", "content","price",
        "slug", "description", "status", "user_id",
        "number_of_hours", "rate", "start_date", "utilities",
        "level_id","lectures"
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function level()
    {
        return $this->belongsTo(Level::class);
    }

    public function classes()
    {
        return $this->hasMany(ClassRoom::class);
    }
}
