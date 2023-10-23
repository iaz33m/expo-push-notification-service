<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\PushApp;
use App\Http\Resources\PushAppResource;

class AppsController extends Controller
{
    public function store(Request $request)
    {

        $input = $request->all();

        $this->validateOrAbort($input, [
            'name' => 'required',
            'fcm_sender_id' => 'required',
            'server_key' => 'required'
        ]);

        $app = PushApp::create([
            'name' => $input['name'],
            'fcm_sender_id' => $input['fcm_sender_id'],
            'server_key' => $input['server_key'],
            'client_id' => rand(10000, 100000),
            'client_secret' => str_random(32)
        ]);

        return [
            'data' => PushAppResource::make($app)
        ];
    }
}
