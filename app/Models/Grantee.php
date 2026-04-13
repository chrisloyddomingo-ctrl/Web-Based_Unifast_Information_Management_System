<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grantee extends Model
{
    use HasFactory;

    protected $fillable = [
        'application_id',
        'student_id',
        'seq',
        'last_name',
        'first_name',
        'middle_name',
        'extension_name',
        'mobile_number',
        'email',
        'course',
        'year',
        'years_of_stay',
        'status_of_student',
        'remarks',
        'batch_id',
        'scholarship_id',
    ];
    public function application()
    {
        return $this->belongsTo(Application::class, 'application_id');
    }

    public function studentAccount()
    {
        return $this->hasOne(StudentAccount::class, 'grantee_id');
    }

    
    public function batch()
    {
        return $this->belongsTo(Batch::class);
    }
    public function scholarship()
    {
        return $this->belongsTo(Scholarship::class);
    }
    
}
