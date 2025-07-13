<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{

    protected $fillable = [
        'classes_id',
        'user_id'
    ];

    public function class() {
        return $this->belongsTo(Classes::class);
    }
    public function user() {
        return $this->belongsTo(User::class);
    }
}
