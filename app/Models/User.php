<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;


class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'user';

    const ROLE_ADMIN = 'admin';
    const ROLE_MANAGE = 'manage';
    const ROLE_STUDENT = 'student';
    const ROLE_TEACHER = 'teacher';
    const STATUS_TESTED = 1;
    const STATUS_WAIT_TEST = 2;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'time_test_end',
        'status_test',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function profile()
    {
        return $this->hasOne(Profile::class);
    }


    public function orderCreators()
    {
        return $this->hasMany(Order::class,'creator_id');
    }

    public function orderBuys()
    {
        return $this->hasMany(Order::class,'user_id');
    }

    public function teacherClasses()
    {
        return $this->hasMany(ClassRoom::class,'teacher_id');
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function blogPosts()
    {
        return $this->hasMany(BlogPost::class);
    }

    public function timeKeepings()
    {
        return $this->hasMany(TimeKeeping::class);
    }
}
