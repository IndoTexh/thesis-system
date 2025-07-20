<?php

namespace App\Services;

class RoleService
{
    public static function admin() 
    {
        return "admin";
    }

    public static function supervisor()
    {
        return "supervisor";
    }

    public static function student()
    {
        return "student";
    }
}
