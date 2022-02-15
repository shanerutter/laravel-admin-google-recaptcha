<?php

namespace Shanerutter\LaravelAdminGoogleRecaptcha\Http\Controllers;

use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Encore\Admin\Controllers\AuthController as BaseAuthController;
use Shanerutter\LaravelAdminGoogleRecaptcha\AuthGoogleRecaptcha;
use Shanerutter\LaravelAdminGoogleRecaptcha\Rules\ReCaptchaRule;

class AuthController extends BaseAuthController
{
    use ThrottlesLogins;

    protected $maxAttempts;
    protected $decayMinutes;

    public function __construct()
    {
        $this->maxAttempts  = AuthGoogleRecaptcha::config('maxAttempts', 5);
        $this->decayMinutes = AuthGoogleRecaptcha::config('decayMinutes', 1);
    }

    public function getLogin()
    {
        if ($this->guard()->check()) {
            return redirect($this->redirectPath());
        }

        return view(AuthGoogleRecaptcha::$group . '::login', [
            'recaptchaPublicKey' => AuthGoogleRecaptcha::config('recaptchaPublicKey', ''),
        ]);
    }

    public function postLogin(Request $request)
    {
        $credentials = $request->only([$this->username(), 'password', 'recaptcha-token']);

        /** @var \Illuminate\Validation\Validator $validator */
        $validator = Validator::make($credentials, [
            $this->username()   => 'required',
            'password'          => 'required',
            'recaptcha-token' => ['required', new ReCaptchaRule()],
        ]);

        if ($validator->fails()) {
            return back()->withInput()->withErrors($validator);
        }

        unset($credentials['recaptcha-token']);

        if ($this->guard()->attempt($credentials)) {
            return $this->sendLoginResponse($request);
        }

        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        $this->incrementLoginAttempts($request);

        return back()->withInput()->withErrors([
            $this->username() => $this->getFailedLoginMessage(),
        ]);
    }
}
