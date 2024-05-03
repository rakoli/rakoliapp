<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

class MobileAppController
{
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'phone' => ['required', 'numeric'],
            'password' => ['required'],
        ]);

        if (\Auth::attempt($credentials)) {
            $user = \Auth::user();

            if(!$user->canAccessMobileApp()){
                return responder()->error('unauthorized');
            }

            $token = $user->createToken('auth_token')->plainTextToken;

            return responder()->success([
                'token_type' => 'Bearer',
                'access_token' => $token,
            ]);

        } else {
            return responder()->error('unauthorized');
        }
    }

    public function logout(Request $request)
    {

        if(!$request->user()->currentAccessToken()->delete()){
            return responder()->error('action_failed');
        }

        return responder()->success(['message'=>'logged out successfully']);
    }

}
