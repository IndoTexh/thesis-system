<?php

namespace App;

class Service
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {

    }

    public static function notForceLogout() {
        return false;
    }

    public static function forceLogout() {
        return true;
    }
}
