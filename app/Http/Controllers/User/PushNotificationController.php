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
            'notification' => 'required',
            'app_id' => 'required',
        ]);
        
        $data = NotificationHelper::GENERATE(
            $input['notification'],
            $request->users,
            $input['app_id']
        );

        return [
            'message' => 'Notification Sent Successfully',
            'data' => $data,
        ];
    }
}
