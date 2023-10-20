<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Services\UserService;
use App\Http\Controllers\Controller;
use App\Services\SocialAccountsService;
use App\Http\Controllers\IssueTokenTrait;


class AuthController extends Controller
{

    use IssueTokenTrait;

    public function socialLogin(Request $request)
    {

        $input = $request->all();

        $this->validateOrAbort($input, [
            'name' => 'required',
            'email' => 'nullable|email',
            'provider_name' => 'required',
            'provider_id' => 'required'
        ]);

        $saService = new SocialAccountsService();

        $saService->findOrCreate($request);

        return $this->issueToken($request, 'social');
    }

    public function register(Request $request)
    {

        $input = $request->all();

        $input['avatar'] = $request->avatar;

        $service = new UserService();

        $user = $service->create($input);

        return [
            "message" => "Registered Successfully!"
        ];
    }

    public function login(Request $request)
    {

        $input = $request->all();

        $this->validateOrAbort($input, [
            'email' => 'required|email',
            'password' => 'required|min:6'
        ]);

        return $this->issueToken($request, 'password');
    }
}
