<?php

namespace App\Jobs;

use App\Notifications\TelegramNotification;
use App\Services\NotificationService;
use Exception;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Notification;

class NotificationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $user;

    public function __construct($user)
    {
        $this->user = $user;
    }

    public function handle(): void
    {
        try {
            Notification::route(NotificationService::telegramRoute(), env('TELEGRAM_ID'))
                ->notify(new TelegramNotification($this->user));
        } catch (Exception $ex) {
            \Log($ex->getMessage());
        }
    }
}
