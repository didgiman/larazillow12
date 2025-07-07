<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\User;
use Inertia\Inertia;
use Illuminate\Http\RedirectResponse;

class SocialLoginController extends Controller
{
    public function redirectToProvider(string $provider): RedirectResponse
    {
        if (!in_array($provider, ['google', 'facebook', 'github'])) {
            abort(404);
        }

        return Socialite::driver($provider)->redirect();
    }

    public function handleProviderCallback(string $provider)
    {
        if (!request()->has('code') && !request()->has('state')) {
            return redirect()->route('login')->with('error', 'Invalid callback request.');
        }

        try {
            // $socialUser = Socialite::driver($provider)->user();
            // $socialUser = Socialite::driver($provider)->stateless()->user();

            $driver = Socialite::driver($provider);

            if (config('services.socialite_stateless', false)) {
                // In production, we don't want to use "stateless()" for some reason. To be checked
                $driver->stateless();
            }

            $socialUser = $driver->user();

        } catch (\Exception $e) {
            \Log::error('Socialite callback error: ' . $e->getMessage());
            return redirect()->route('login')->with('error', 'Login with ' . ucfirst($provider) . ' failed.');
        }

        $user = User::where('provider', $provider)
                    ->where('provider_id', $socialUser->getId())
                    ->first();

        if (!$user) {
            $user = User::where('email', $socialUser->getEmail())->first();

            if ($user) {
                // Link to existing user
                $user->provider = $provider;
                $user->provider_id = $socialUser->getId();
                $user->save();
            } else {
                // Create a new user
                $user = User::create([
                    'name' => $socialUser->getName() ?? $socialUser->getNickname() ?? 'Gebruiker',
                    'email' => $socialUser->getEmail(),
                    'provider' => $provider,
                    'provider_id' => $socialUser->getId(),
                    'password' => bcrypt(Str::random(16)), // Random password
                    'email_verified_at' => now(), // Mark as verified, so that user doesn't need to click link in verify email
                ]);
            }
        }

        Auth::login($user);

        // return redirect(route('user.summary', absolute: false));
        return Inertia::location('/');
    }
}
