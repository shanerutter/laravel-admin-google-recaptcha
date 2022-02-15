Google Recaptcha and Login attempts for laravel-admin
======
Add google recaptcha and login attempts to laravel-admin


### Installation

```
composer require shanerutter/laravel-admin-google-recaptcha
```

### Configuration

In the extensions section of the `config/admin.php` file, add configurations
```
'extensions' => [
    \Shanerutter\LaravelAdminGoogleRecaptcha\AuthGoogleRecaptcha::$group => [
        'enable' => (bool)env('ADMIN_RECAPTCHA_ENABLED', true),
        'maxAttempts' => 5,
        'decayMinutes' => 5,
        'recaptchaPublicKey' => env('ADMIN_RECAPTCHA_SITE_KEY', ''),
        'recaptchaPrivateKey' => env('ADMIN_RECAPTCHA_SECRET_KEY', ''),
    ]
]
```

In the `.env` file, add configurations
```
ADMIN_RECAPTCHA_ENABLED=true
ADMIN_RECAPTCHA_SITE_KEY="...."
ADMIN_RECAPTCHA_SECRET_KEY="...."
```


### License

Licensed under [The MIT License (MIT)](LICENSE).

