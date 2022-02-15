<?php

namespace Shanerutter\LaravelAdminGoogleRecaptcha;

use Illuminate\Support\ServiceProvider;

class AuthAttemptsServiceProvider extends ServiceProvider
{
    /**
     * @param AuthGoogleRecaptcha $extension
     */
    public function boot(AuthGoogleRecaptcha $extension)
    {
        if (!AuthGoogleRecaptcha::boot()) {
            return;
        }

        if ($views = $extension->views()) {
            $this->loadViewsFrom($views, AuthGoogleRecaptcha::$group);
        }

        if ($this->app->runningInConsole() && $assets = $extension->assets()) {
            $this->publishes(
                [$assets => public_path('vendor/shanerutter/laravel-admin-google-recaptcha')],
                AuthGoogleRecaptcha::$group
            );
        }

        $this->app->booted(function () {
            AuthGoogleRecaptcha::routes(__DIR__ . '/../routes/web.php');
        });
    }
}
