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

    public static function trueValue() {
        return true;
    }

    public static function falseValue() {
        return false;
    }

    public static function warningAudio() {
        return 'warning_audio.mp3';
    }

    public static function successAudio() {
        return 'success_audio.mp3';
    }
}
