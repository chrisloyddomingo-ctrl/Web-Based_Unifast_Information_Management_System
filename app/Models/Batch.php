<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Batch extends Model
{
    protected $fillable = [
        'scholarship_id',
        'name',
    ];

    public function scholarship()
    {
        return $this->belongsTo(Scholarship::class);
    }

    public function grantees()
    {
        return $this->hasMany(Grantee::class);
    }
}