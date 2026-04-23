<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class TblUser extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * Table name
     */
    protected $table = 'users';

    /**
     * Primary key
     * - If your PK is NOT "id", change this (example: user_id)
     */
    protected $primaryKey = 'id';

    /**
     * If tblusers does NOT have created_at and updated_at, keep this false.
     * If it has timestamps, set to true.
     */
    public $timestamps = true;

    /**
     * Mass assignable columns
     */
    protected $fillable = [
    'name',
    'email',
    'password',
    'role',
    'phone',
    'address',
    'status',
    'avatar',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'is_active' => 'boolean',
    ];
}