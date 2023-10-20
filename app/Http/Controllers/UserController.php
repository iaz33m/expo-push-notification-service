<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    //
    protected $permissions = [
        'index' => 'role-list',
    ];

    public function index(Request $request)
    {
        return "Danish";
    }
}
