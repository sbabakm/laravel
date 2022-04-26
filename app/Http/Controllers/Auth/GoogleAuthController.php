<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;

class GoogleAuthController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    public function callback()
    {

        try {
           
            $googleUser = Socialite::driver('google')->stateless()->user();
            //dd($googleUser);
            $user = User::where('email', $googleUser->email)->first();
           // return 'test';
            if ($user) {

                auth()->loginUsingId($user->id);
                return redirect('/home');
            } else {
                $newUser = User::create([
                    'name' => $googleUser->name,
                    'email' => $googleUser->email,
                    'password' => bcrypt(Str::random(16)),
                ]);

                auth()->loginUsingId($newUser->id);
                return redirect('/home');
            }
        } catch (\Exception $e) {
            //return 'error';
            alert()->error('login with goole not success' , 'Message')->persistent('OK');
           return redirect('/login');
        }
    }
}
