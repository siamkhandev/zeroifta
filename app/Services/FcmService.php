<?php

namespace App\Services;

use Kreait\Firebase\Factory;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;
use Kreait\Laravel\Firebase\Facades\Firebase;
use GuzzleHttp\Client;

class FcmService
{
    protected $fcmUrl = 'https://fcm.googleapis.com/v1/projects/zeroifta-4d9af/messages:send';
    protected $serviceAccountPath;

    public function __construct()
    {
        $this->serviceAccountPath = storage_path('app/zeroifta.json');
    }

    public function sendNotification($deviceToken, $title, $body, $data = [])
{
    $accessToken = $this->getAccessToken();
    $client = new Client();

    $payload = [
        'message' => [
            'token' => $deviceToken,  // The actual device token
            'notification' => [
                'title' => $title,
                'body'  => $body,
            ],
            'android' => [
                'notification' => [
                    'sound' => 'default',
                    'priority' => 'high',
                ]
            ],
            'apns' => [
                'payload' => [
                    'aps' => [
                        'sound' => 'default',
                        'content-available' => 1,
                    ]
                ]
            ],
            'data' => (object) $data // Ensure it's an object if empty
        ]
    ];

    $headers = [
        'Authorization' => 'Bearer ' . $accessToken,
        'Content-Type'  => 'application/json',
    ];

    try {
        $response = $client->post($this->fcmUrl, [
            'headers' => $headers,
            'json'    => $payload, // Use 'json' instead of 'body' for automatic encoding
        ]);

        return json_decode($response->getBody(), true);
    } catch (\GuzzleHttp\Exception\ClientException $e) {
        return [
            'error'   => true,
            'message' => $e->getResponse()->getBody()->getContents(),
        ];
    }
}

    private function getAccessToken()
    {
        $credentials = json_decode(file_get_contents($this->serviceAccountPath), true);
        $client = new \Google\Client();
        $client->setAuthConfig($credentials);
        $client->addScope('https://www.googleapis.com/auth/firebase.messaging');
        return $client->fetchAccessTokenWithAssertion()['access_token'];
    }
}
