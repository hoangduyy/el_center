<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Teacher extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    use SoftDeletes;

    protected $table = 'teacher';

    const PASSWORD_DEFAULT = '123456';
    const GENDER_BOY = 1;
    const GENDER_GIRL = 2;

    protected $fillable = [
        'name',
        'email',
        'password',
        'address',
        'birthday',
        'gender',
        'phone',
        'degree_id',
    ];

    public function teacherCertificate()
    {
        return $this->hasMany(TeacherCertificate::class, 'teacher_id', 'id');
    }

    public function degree()
    {
        return $this->belongsTo(Degree::class, 'degree_id', 'id');
    }
}
