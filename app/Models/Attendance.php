<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

    protected $table = 'attendances';

    protected $fillable = [
        'student_number',
        'event_id',
        'name',
        'course',
        'barcode',
        'time_in',
        'time_out',
        'remarks',
    ];
    public function event()
    {
        return $this->belongsTo(Event::class);
    }
     public function getFinalRemarksAttribute()
    {
    if ($this->time_in && $this->time_out) {
        return 'Complete Attendance';
    }

    if ($this->time_in && !$this->time_out) {
        return 'Time In Only';
    }

    return $this->remarks ?? 'No Attendance';
    }
}