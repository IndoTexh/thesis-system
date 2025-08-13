<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'department',
        'force_logout',
        'allow_access',
        'profile_picture'
    ];

    public function theses() {
        return $this->hasMany(Theses::class);
    }

    public function student() {
        return $this->hasOne(Student::class);
    }

    public function supervisedClasses() {
        //return $this->belongsToMany(Classes::class, 'class_supervisors', 'classes_id', 'supervisor_id');
        return $this->belongsToMany(Classes::class, 'class_supervisors', 'supervisor_id', 'classes_id');

    }

    public function getHasApiTokensAttribute()
    {
        return $this->tokens()->exists();
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];
    
    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'force_logout' => 'boolean',
        'allow_access' => 'boolean',
    ];

}
