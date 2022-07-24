<?php

namespace App\Providers;

use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use App\Actions\Fortify\UpdateUserProfileInformation;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Laravel\Fortify\Fortify;

class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        
        /*if (preg_match('/^[^\.]+\.localhost$/', request()->getHost())) {
            config([
                'fortify.guard' => 'store',
                'fortify.domain' => request()->getHost(),
            ]);
        }*/
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

        /* if (request()->getHost() == 'store.localhost') {
            config([ 
                'fortify.guard' =>  'store',
            ]);
        } */

        Fortify::createUsersUsing(CreateNewUser::class);
        Fortify::updateUserProfileInformationUsing(UpdateUserProfileInformation::class);
        Fortify::updateUserPasswordsUsing(UpdateUserPassword::class);
        Fortify::resetUserPasswordsUsing(ResetUserPassword::class);

        RateLimiter::for('login', function (Request $request) {
            $email = (string) $request->email;

            return Limit::perMinute(5)->by($email.$request->ip());
        });

        RateLimiter::for('two-factor', function (Request $request) {
            return Limit::perMinute(5)->by($request->session()->get('login.id'));
        });

        

        Fortify::registerView('auth.register');
        Fortify::requestPasswordResetLinkView('auth.forgot-password');
        Fortify::resetPasswordView('auth.reset-password');
        Fortify::confirmPasswordView('auth.confirm-password');
        Fortify::verifyEmailView('auth.verify-email');
        Fortify::twoFactorChallengeView('auth.two-factor-challenge');

        /*Fortify::authenticateUsing(function(Request $request) {
            $username = config('fortify.username');
            
            $request->validate([
                $username => 'required',
                'password' => 'required',
            ]);
            //Auth::guard('web')->validate($request->only($username, 'password'));
            $user = User::where($username, $request->post($username))->first();
            if ($user && Hash::check($request->password, $user->password)) {
                return $user;
            }
        });*/
    }
}