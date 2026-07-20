<?php

namespace App\Providers;

use App\Actions\Fortify\CreateNewUser;
use Illuminate\Support\ServiceProvider;
use Laravel\Fortify\Fortify;
use App\Validation\LoginRules;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class FortifyServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(
            \Laravel\Fortify\Contracts\RegisterResponse::class,
            \App\Http\Responses\RegisterResponse::class
        );
        $this->app->singleton(
            \Laravel\Fortify\Contracts\VerifyEmailResponse::class,
            \App\Http\Responses\VerifyEmailResponse::class
        );
        $this->app->bind(
            \Laravel\Fortify\Http\Requests\LoginRequest::class,
            \App\Http\Requests\FortifyLoginRequest::class
        );
    }

    public function boot()
    {
        Fortify::createUsersUsing(CreateNewUser::class);

        Fortify::loginView(function () {
            return view('auth.login');
        });
        Fortify::registerView(function () {
            return view('auth.register');
        });
        Fortify::verifyEmailView(function () {
            return view('auth.verify');
        });
        Fortify::authenticateUsing(
            function ($request) {
                $rules = LoginRules::rules();
                $messages = LoginRules::messages();
                Validator::make($request->all(), $rules, $messages)->validate();

                $user = User::where('email', $request->email)->first();

                if ($user && Hash::check($request->password, $user->password)) {
                    return $user;
                }
            }
        );
    }
}
