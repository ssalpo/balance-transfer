<?php

namespace App\Http\Controllers;

use App\User;

class UserController extends Controller
{
    public function auth()
    {
        $user = User::where('email', request('email'))->first();

        if (password_verify(request('password'), $user->password ?? null)) {
            return $user->only(['name', 'email', 'api_token']);
        }

        return ['error' => 'Error while auth. Please check credentials!'];
    }
}
