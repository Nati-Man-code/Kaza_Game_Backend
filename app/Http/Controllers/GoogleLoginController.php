<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class GoogleLoginController extends Controller
{
     /**
     * Redirect the user to the Google authentication page.
     *
     * @return \Illuminate\Http\Response
     */
    
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $user = Socialite::driver('google')->user();
            $findUser = User::where('google_id', $user->id)->first();

            if ($findUser) {
                Auth::login($findUser);
                $token = $findUser->createToken('authToken')->plainTextToken;

                return response()->json([
                    'access_token' => $token,
                    'token_type' => 'Bearer',
                    'user' => $findUser,
                ]);
            } else {
                $newUser = User::create([
                    'name' => $user->name,
                    'email' => $user->email,
                    'google_id' => $user->id,
                    'password' => encrypt('my-google')
                ]);

                Auth::login($newUser);
                $token = $newUser->createToken('authToken')->plainTextToken;

                return response()->json([
                    'access_token' => $token,
                    'token_type' => 'Bearer',
                    'user' => $newUser,
                ]);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => __($e)], 500);
        }
    }
}
