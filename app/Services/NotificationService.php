<?php

namespace App\Services;

use App\Notifications\TelegramNotification;
use Illuminate\Support\Facades\Notification;

class NotificationService
{
    public static function telegramRoute() {
        return 'telegram';
    }
}
