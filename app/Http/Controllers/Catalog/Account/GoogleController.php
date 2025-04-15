<?php

namespace App\Http\Controllers\Catalog\Account;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;

class GoogleController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    
    public function handleGoogleCallback()
    {
        $user = Socialite::driver('google')
            ->setHttpClient(new \GuzzleHttp\Client(['verify' => false]))
            ->stateless()
            ->user();

        $finduser = User::where('email', $user->email)->first();
     
        if($finduser){
            if ($finduser->status) {
                $finduser->update([
                    "google_id" => $user->id,
                    "name" => $user->name,
                    "image" => $user->avatar,
                ]);
                session()->put('isUser', $finduser->id);
                session()->put('user_name', $finduser->name);
                return redirect()->route('catalog.front-user-account');
            } else {
                return redirect()->route('catalog.user-login')->with('error', 'Account disabled. Please contact Admin.');
            }
        }else{

            $newUser = User::create([
                'google_id'=> $user->id,
                "name" => $user->name,
                "email" => $user->email,
                "image" => $user->avatar,
                "email_verified_at" => Carbon::now(),
                "password" => Hash::make(rand(1000,9999)),
                "status" => 1
            ]);
     
            session()->put('isUser', $newUser->id);
            session()->put('user_name',$newUser->name);
            return redirect()->route('catalog.front-user-account');
        }

    }
}
