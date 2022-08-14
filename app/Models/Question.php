<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;


class Question extends Authenticatable
{
    use SoftDeletes;

    protected $table = 'question';

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'question',
        'da_a',
        'da_b',
        'da_c',
        'da_d',
        'da',
    ];
}
