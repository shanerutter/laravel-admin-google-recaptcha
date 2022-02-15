<?php

namespace Shanerutter\LaravelAdminGoogleRecaptcha;

use Encore\Admin\Extension;

class AuthGoogleRecaptcha extends Extension
{
    public static string $group = 'auth-google-recaptcha';
    public $name = 'auth-google-recaptcha';
    public $views = __DIR__ . '/../resources/views';
}
