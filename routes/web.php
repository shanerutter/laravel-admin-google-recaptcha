<?php

use Shanerutter\LaravelAdminGoogleRecaptcha\Http\Controllers\AuthController;

Route::get('auth/login', [AuthController::class, 'getLogin']);
Route::post('auth/login', [AuthController::class, 'postLogin']);
