<?php

namespace App\Helpers;


use App\FCMDevice;
use App\Services\PushNotificationService;

class NotificationHelper
{
    public static function GENERATE($app, $notification, $users)
    {

        // if users are set on request it will send notifications to selected users otherwise it will
        // send notifications to all users

        if (!$users) {
            $users = FCMDevice::where([
                ['app_id', $app->id],
            ])->pluck('user_id')->toArray();
        }

        $tokens = FCMDevice::where('app_id', $app->id)
            ->whereIn('user_id', $users)
            ->pluck('token')
            ->toArray();

        $service = new PushNotificationService();

        $data = $service->send($tokens, $notification);

        return $data;
    }
}
