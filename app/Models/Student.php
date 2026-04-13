<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class StudentAccount extends Authenticatable
{
    use Notifiable;

    protected $table = 'student_accounts'; // palitan lang kung iba ang tunay na table name

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