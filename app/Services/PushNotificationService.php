<?php

namespace App\Services;


use App\FCMDevice;
use LaravelFCM\Facades\FCM;
use LaravelFCM\Message\OptionsBuilder;
use LaravelFCM\Message\PayloadDataBuilder;
use LaravelFCM\Message\PayloadNotificationBuilder;

class PushNotificationService
{

    public function send($tokens, $notification)
    {

        $expoNotification = [];

        if (sizeof($tokens) > 0) {
            $expoNotification = $this->expo($tokens,$notification);
        }

        return $expoNotification;
    }

    function expo($tokens, $notification){

        $url= "https://exp.host/--/api/v2/push/send";

        $options = array(
            'http' => array(
              'method'  => 'POST',
              'content' => json_encode([
                "sound" => $notification['sound'],
                "title" => $notification['title'],
                "body" => $notification['body'],
                "data" => $notification["payload"],
                "to" => $tokens,
              ]),
              'header'=>  "Content-Type: application/json\r\n" .
                          "Accept: application/json\r\n"
              )
          );

          $context  = stream_context_create( $options );
          $result = file_get_contents( $url, false, $context );

          return json_decode( $result );
    }
}
