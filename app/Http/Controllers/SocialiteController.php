<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class SocialiteController extends Controller
{
    /**
    *
    * @param NA
    * @return void
    */
    public function googleLogin()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
    *
    * @param NA
    * @return void
    */
    public function googleAuthentication()
    {
        try {
            $googleUser = Socialite::driver('google')->stateless()->user();

            $user = User::where('id_google', $googleUser->id)->first();

            if ($user) {
                Auth::login($user);
                return redirect()->route('beranda');
            }

            $userData = User::create([
                'nama_lengkap' => $googleUser->name,
                'email' => $googleUser->email,
                'role' => 'user',
                'id_google' => $googleUser->id,
                'password' => Hash::make('Password@1234'),
            ]);

            Auth::login($userData);
            return redirect()->route('beranda');

        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }
}
