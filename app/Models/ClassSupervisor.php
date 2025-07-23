<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClassSupervisor extends Model
{
    protected $fillable = [
        'classes_id',
        'supervisor_id'
    ];
}
