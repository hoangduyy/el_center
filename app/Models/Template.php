<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Template extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $fillable = ["name","html","mailjet_id"];

    public function configs(){
        return $this->hasMany(MailConfig::class);
    }
}
