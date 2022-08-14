<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderDetail extends Model
{
    use HasFactory;

    use SoftDeletes;

    const STATUS_SUCCESS = 2;
    const STATUS_FAIL = 3;

    protected $table="order_detail";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'status',
        "order_id",
        "class_id",
    ];

    public function order()
    {
        return $this->belongsTo(Order::class,'order_id');
    }

    public function class()
    {
        return $this->belongsTo(ClassRoom::class,'class_id');
    }
}
