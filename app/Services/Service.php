<?php

namespace App\Services;

class Service
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public static function true()
    {
        return true;
    }

    public static function false()
    {
        return false;
    }

    public static function warningAudio()
    {
        return 'warning_audio.mp3';
    }

    public static function successAudio()
    {
        return 'success_audio.mp3';
    }

    public static function waitForActivateMessage()
    {
        return  "You won't be able to login until the the admin active your account!";
    }

    public static function welcomeMessage()
    {
        return "Welcome";
    }

    public static function invalidCredentialMessage()
    {
        return "The provided credentials do not match our records.";
    }

    public static function accountCreatedMessage()
    {
        return "Account created! Please log in.";
    }

    public static function logoutMessage() {
        return "Your're logged out!";
    }
}
