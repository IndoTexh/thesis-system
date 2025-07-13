<?php

namespace App\Models;

use App\ThesisStatus;
use Illuminate\Database\Eloquent\Model;

class Theses extends Model
{

    protected $fillable = [
        'user_id',
        'title',
        'abstract',
        'file_path',
        'department',
        'status'
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    protected $casts = [
        'status' => ThesisStatus::class,
    ];
}
