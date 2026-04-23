<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Student extends Authenticatable
{
    use Notifiable;

    protected $table = 'student_accounts';

    protected $fillable = [
        'student_id',
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function tblapplications()
    {
        return $this->hasMany(Application::class, 'student_id', 'student_id');
    }
}