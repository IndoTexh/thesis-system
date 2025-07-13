<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Classes extends Model
{

    protected $fillable = [
        'class_name',
        'major_id'
    ];

    public function major() {
        return $this->belongsTo(Major::class);
    }

    public function students() {
        return $this->hasMany(Student::class);
    }

   public function supervisors() {
    return $this->belongsToMany(User::class,  'class_supervisors', 'classes_id', 'supervisor_id')->where('role', 'supervisor');
   }
}
