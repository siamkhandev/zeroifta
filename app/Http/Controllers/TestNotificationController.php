<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\FcmService;

class TestNotificationController extends Controller
{
    protected $fcmService;

    public function __construct(FcmService $fcmService)
    {
        $this->fcmService = $fcmService;
    }

    public function sendTestNotification(Request $request)
    {
        $deviceToken = 'fIGTMW3_RiKQt5pVjWHZ4H:APA91bHYl477ROJ2U_fQ5Z0aE3PpgEw-zsACQG5aPizOa2IauxdJdTj3FsQLjicISoig632z-kC4nFVHbl40ujxOwrVv3J1D8HR2cTBH0Xom0c9v0Esdzgs'; // Replace with actual FCM token.
        $title = 'Test Notification';
        $body = 'This is a test push notification.';
        
        $response = $this->fcmService->sendNotification($deviceToken, $title, $body);

        return response()->json(['response' => $response]);
    }
}
