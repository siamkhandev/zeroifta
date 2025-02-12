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
    {dd(storage_path('app/zeroifta2.json'));
        $this->serviceAccountPath = storage_path('app/zeroifta2.json');
    }

    public function sendNotification($deviceToken, $title, $body, $data = [])
    {
        $accessToken = $this->getAccessToken();
        $client = new Client();


        $payload = [
            'message' => [
                'token' => $deviceToken,  // Replace this with the actual token
                'notification' => [
                    'title' => $title,
                    'body' => $body,
                ],
                'data' => (object) $data,  // Ensure this is cast to an object to avoid the list-to-map error
            ]
        ];


        $headers = [
            'Authorization' => 'Bearer ' . $accessToken,
            'Content-Type' => 'application/json',
        ];

        $response = $client->post($this->fcmUrl, [
            'headers' => $headers,
            'body' => json_encode($payload),
        ]);

        return json_decode($response->getBody(), true);
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
