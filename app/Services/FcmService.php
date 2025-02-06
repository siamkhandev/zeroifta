<?php

namespace App\Services;

use Kreait\Firebase\Factory;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;
use Kreait\Laravel\Firebase\Facades\Firebase;

class FcmService
{
    protected $messaging;

    public function __construct()
    {
        $firebase = (new Factory)->withServiceAccount(config('firebase.credentials.file'));
        $this->messaging = $firebase->createMessaging();
    }

    public function sendNotification($title, $body, $fcmToken)
    {
        $message = [
            'token' => $fcmToken,
            'notification' => [
                'title' => $title,
                'body' => $body,
            ],
        ];

        try {
            $this->messaging->send($message);
        } catch (\Exception $e) {
            \Log::error('Firebase notification error: ' . $e->getMessage());
        }
    }
}
