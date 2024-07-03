<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

class ResetPasswordController extends Controller
{

    public function reset(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'token' => 'required',
            'password' => 'required|confirmed|min:8',
        ]);

        $response = Password::reset($request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->password = bcrypt($password);
                $user->save();
            });

        return $response == Password::PASSWORD_RESET
            ? response()->json(['message' => __($response)])
            : response()->json(['error' => __($response)], 400);
    }
}
