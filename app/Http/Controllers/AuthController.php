<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{
    public function login()
    {
        return view('Auth.login');
    }
    public function register()
    {
        return view('Auth.register');
    }
    public function dashboard()
    {
        return view('ADM.dashboard.list');
    }

    //socialite
    //google

    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        $data = Socialite::driver('google')->user();
        $this->_registerOrLogin($data);

        if (Auth::user()) {
            return redirect()->route('admin#dashboard');
        }
    }

    //facebook
    public function redirectToGithub()
    {
        return Socialite::driver('github')->redirect();
    }

    public function handleGithubCallback()
    {
        $data = Socialite::driver('github')->user();
        $this->_registerOrLogin($data);

        if (Auth::user()) {
            return redirect()->route('admin#dashboard');
        }
    }

    protected function _registerOrLogin($data)
    {
        $user = User::where('email', $data->email)->first();
        if (!$user) {
            $user = new User();
            $user->name = $data->name;
            $user->email = $data->email;
            $user->provider_id = $data->id;
            $user->avatar = $data->avatar;
            $user->save();
        }
        Auth::login($user);
    }
}
