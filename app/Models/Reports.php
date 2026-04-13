<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reports extends Model
{
        protected $table = 'reports';
        protected $fillable = [
            'grantee_list',
            'grantee_with_outstandings',
            'financial_disbursements',
            'attendance_summary',
        ];
}


