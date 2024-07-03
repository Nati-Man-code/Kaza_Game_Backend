<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\GoogleLoginController;
use App\Http\Controllers\ResetPasswordController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('register', [AuthController::class, 'register'])->name('register');
Route::post('login', [AuthController::class, 'login'])->name('login');
Route::post('/password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.reset');
Route::post('/password/reset', [ResetPasswordController::class, 'reset'])->name('password.new');
Route::get('auth/google', [GoogleLoginController::class, 'redirectToGoogle'])->name('redirect');
Route::get('auth/google/callback', [GoogleLoginController::class, 'handleGoogleCallback'])->name('google.callback');