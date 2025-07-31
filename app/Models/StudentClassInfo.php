<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentClassInfo extends Model
{
    protected $fillable = [
        'student_id',
        'major_id',
        'classed_id'
    ];
}
