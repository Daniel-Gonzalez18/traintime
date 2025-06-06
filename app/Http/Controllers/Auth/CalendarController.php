<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class CalendarController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->scopes([
            'https://www.googleapis.com/auth/calendar'
        ])->with([
        'access_type' => 'offline',
        'prompt' => 'consent',
    ])->stateless()->redirect();
    }
    public function handleGoogleCallback()
    {
        $googleUser = Socialite::driver('google')->stateless()->user();
        $user = Auth::user();
        $user->calendar_access_token = $googleUser->token;
        $user->calendar_refresh_token = $googleUser->refreshToken;
        $user->calendar_expires_in = $googleUser->expiresIn;
        $user->save();
        return redirect('/home')->with('status', 'Cuenta de Google conectada');
    }
}

