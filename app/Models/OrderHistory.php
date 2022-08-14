<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderHistory extends Model
{
    use HasFactory;
    protected $table="order_histories";
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'note',
        'fullName',
        'total',
        "creator_id",
        "order_id",
    ];

    public function creator(){
        return $this->belongsTo(User::class,'creator_id');
    }

    public function order(){
        return $this->belongsTo(Order::class,'order_id');
    }



}