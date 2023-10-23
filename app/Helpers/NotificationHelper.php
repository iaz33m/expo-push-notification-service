<?php

namespace App\Helpers;


use App\FCMDevice;
use App\Services\PushNotificationService;

class NotificationHelper {

    public static function GENERATE($notification, $users, $app_id){

        // if users are set on request it will send notifications to selected users otherwise it will
        // send notifications to all users

        if (!$users) {
            $users = FCMDevice::pluck('user_id')->where('app_id', $app_id)->toArray();
        }

        $tokens = FCMDevice::whereIn('user_id', $users)->pluck('token')->toArray();
            
        $service = new PushNotificationService();

        return $service->send($tokens, $notification);
    }
}
