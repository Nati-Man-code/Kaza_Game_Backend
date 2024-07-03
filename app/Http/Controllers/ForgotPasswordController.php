<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

class ForgotPasswordController extends Controller
{

    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $response = Password::sendResetLink($request->only('email'));

        return $response == Password::RESET_LINK_SENT
            ? response()->json(['message' =>  __($response)])
            : response()->json(['error' => __($response)], 400);
    }

}
