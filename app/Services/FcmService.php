<?php

namespace App\Services;

use Kreait\Firebase\Factory;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;
use Kreait\Laravel\Firebase\Facades\Firebase;

class FcmService
{
    protected $fcmUrl = 'https://fcm.googleapis.com/v1/projects/zeroifta-4d9af/messages:send';
    protected $serviceAccountPath = '/zeroifta.json';

    public function sendNotification($deviceToken, $title, $body, $data = [])
    {
        $client = new Client();
        $accessToken = $this->getAccessToken();

        $payload = [
            'message' => [
                'token' =>'fIGTMW3_RiKQt5pVjWHZ4H:APA91bHYl477ROJ2U_fQ5Z0aE3PpgEw-zsACQG5aPizOa2IauxdJdTj3FsQLjicISoig632z-kC4nFVHbl40ujxOwrVv3J1D8HR2cTBH0Xom0c9v0Esdzgs',
                'notification' => [
                    'title' => 'hello',
                    'body' => 'test notification',
                ],
                'data' => $data,
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
