<?php

namespace App\Http\Controllers\User;

use App\PushApp;
use App\FCMDevice;
use Illuminate\Http\Request;
use App\Helpers\NotificationHelper;
use App\Http\Controllers\Controller;

class PushNotificationController extends Controller
{

    public function register(Request $request)
    {
        $input = $request->all();

        $this->validateOrAbort($input, [
            'token' => 'required',
            'user_id' => 'required',
            'app_id' => 'required',
        ]);

        $device = FCMDevice::where([
            ['user_id', $input['user_id']],
            ['token', $input['token']],
            ['app_id', $input['app_id']],
        ])->first();

        if (!$device) {
            $device = FCMDevice::create([
                'user_id' => $input['user_id'],
                'token' => $input['token'],
                'app_id' => $input['app_id'],
            ]);
        }

        return [
            'message' => 'Device Registered Successfully'
        ];
    }

    public function send(Request $request)
    {

        $input = $request->all();

        $this->validateOrAbort($input, [
            'notification' => 'required'
        ]);

        $sender_id = $request->header('sender-id');
        $server_key = $request->header('server-key');
        $client_secret = $request->header('client-secret');

        $app = PushApp::where([
            ['fcm_sender_id', $sender_id],
            ['server_key', $server_key],
            ['client_secret', $client_secret],
        ])->first();

        if (!$app) {
            abort(400, 'App does not exists');
        }

        $data = NotificationHelper::GENERATE(
            $app,
            $input['notification'],
            $request->users
        );

        return [
            'message' => 'Notification Sent Successfully',
            'data' => $data,
        ];
    }
}
