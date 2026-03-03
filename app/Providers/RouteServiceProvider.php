<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to your application's "home" route.
     *
     * Typically, users are redirected here after authentication.
     *
     * @var string
     */
    public const HOME = '/';

    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     */
    public function boot(): void
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });

        RateLimiter::for('login', function (Request $request) {
            $email = strtolower((string) $request->input('email'));

            return [
                Limit::perMinute(20)->by('login-ip:'.$request->ip()),
                Limit::perMinute(8)->by('login-email:'.sha1($email).'|'.$request->ip()),
            ];
        });

        RateLimiter::for('register', function (Request $request) {
            $email = strtolower((string) $request->input('email'));

            return [
                Limit::perMinute(15)->by('register-ip:'.$request->ip()),
                Limit::perMinute(5)->by('register-email:'.sha1($email).'|'.$request->ip()),
            ];
        });

        RateLimiter::for('otp-resend', function (Request $request) {
            $userId = (string) $request->input('user_id', 'guest');

            return [
                Limit::perMinute(15)->by('otp-resend-ip:'.$request->ip()),
                Limit::perMinute(4)->by('otp-resend-user:'.$userId.'|'.$request->ip()),
            ];
        });

        RateLimiter::for('otp-verify', function (Request $request) {
            $userId = (string) $request->input('user_id', 'guest');

            return [
                Limit::perMinute(20)->by('otp-verify-ip:'.$request->ip()),
                Limit::perMinute(8)->by('otp-verify-user:'.$userId.'|'.$request->ip()),
            ];
        });

        RateLimiter::for('passwordless-request', function (Request $request) {
            $email = strtolower((string) $request->input('email'));

            return [
                Limit::perMinute(20)->by('pwdless-request-ip:'.$request->ip()),
                Limit::perMinute(4)->by('pwdless-request-email:'.sha1($email).'|'.$request->ip()),
            ];
        });

        RateLimiter::for('passwordless-verify', function (Request $request) {
            $email = strtolower((string) $request->input('email'));

            return [
                Limit::perMinute(30)->by('pwdless-verify-ip:'.$request->ip()),
                Limit::perMinute(10)->by('pwdless-verify-email:'.sha1($email).'|'.$request->ip()),
            ];
        });

        RateLimiter::for('jobs-search', function (Request $request) {
            if ($request->user()) {
                return Limit::perMinute(240)->by('jobs-user:'.$request->user()->id);
            }

            return Limit::perMinute(120)->by('jobs-ip:'.$request->ip());
        });

        RateLimiter::for('admin-login', function (Request $request) {
            $email = strtolower((string) $request->input('email'));

            return [
                Limit::perMinute(12)->by('admin-login-ip:'.$request->ip()),
                Limit::perMinute(6)->by('admin-login-email:'.sha1($email).'|'.$request->ip()),
            ];
        });

        $this->routes(function () {
            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/api.php'));

            Route::middleware('web')
                ->group(base_path('routes/web.php'));
        });
    }
}
