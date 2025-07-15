<?php

namespace App\Services;

use Illuminate\Support\Facades\Hash;

class SecurityService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        
    }

    public static function validatePassword(string $f_password, string $s_password) {
        if (!Hash::check($f_password, $s_password)) {
            return false; 
        }
        return true;
    }
}
