<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\StudentAccount;

class Application extends Model
{
    protected $table = 'tblapplications';

    protected $fillable = [
        'student_id',
        'sex',
        'birthdate',
        'last_name',
        'given_name',
        'middle_name',
        'ext_name',
        'program_name',
        'year_level',
        'father_last_name',
        'father_given_name',
        'father_middle_name',
        'mother_last_name',
        'mother_given_name',
        'mother_middle_name',
        'street_barangay',
        'zipcode',
        'contact_number',
        'email',
        'disability',
        'indigenous_group',
        'status',
        'first_generation',
        'parents_monthly_income',
        'semester_id',
    ];

    public function grantee()
    {
        return $this->hasOne(Grantee::class, 'application_id');
    }

    public function student()
    {
        return $this->belongsTo(StudentAccount::class, 'student_id', 'student_id');
    }
    
    public function semester()
    {
        return $this->belongsTo(Semester::class, 'semester_id');
    }
}