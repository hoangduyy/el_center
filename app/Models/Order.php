<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory;

    use SoftDeletes;

    const STATUS_SUCCESS = 2;
    const STATUS_FAIL = 3;

    protected $table="orders";
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'status',
        'note',
        'fullName',
        'phone',
        'email',
        'total',
        "user_id",
        "total_final",
        "sale",
    ];

    public function creator(){
        return $this->belongsTo(User::class,'creator_id');
    }

    public function customer(){
        return $this->belongsTo(User::class,'user_id');
    }

//    public function class(){
//        return $this->belongsTo(ClassRoom::class,'class_id');
//    }
}
