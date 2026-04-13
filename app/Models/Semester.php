<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Semester extends Model
{
    protected $fillable = [
        'semester_name',
        'school_year',
        'is_current',
        'application_status',
        'start_date',
        'end_date',
    ];
}
