<?php


$serverKey = env('FCM_SERVER_KEY', null);
$serverId = env('FCM_SENDER_ID', null);

if (isset($_SERVER['HTTP_SENDER_ID']) && isset($_SERVER['HTTP_SERVER_KEY'])) {
    $serverId = $_SERVER['HTTP_SENDER_ID'];
    $serverKey = $_SERVER['HTTP_SERVER_KEY'];
}

return [
    'driver' => env('FCM_PROTOCOL', 'http'),
    'log_enabled' => false,
    'http' => [
        'server_key' => $serverKey,
        'sender_id' => $serverId,
        'server_send_url' => 'https://fcm.googleapis.com/fcm/send',
        'server_group_url' => 'https://android.googleapis.com/gcm/notification',
        'timeout' => 30.0, // in second
    ],
];
