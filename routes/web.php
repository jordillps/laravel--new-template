<?php

use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Password;

Route::get('/', function () {
    return view('welcome');
});

// Rutas de verificación de email
Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    return redirect('/admin');
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return back()->with('message', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');

// Rutas personalizadas de password reset
Route::get('/custom-password/reset/{token}', function (Request $request, $token) {
    $email = $request->query('email');
    
    if (!$email) {
        return response('Email parameter missing', 400);
    }
    
    // Crear formulario simple de reset
    return view('password-reset-form', compact('token', 'email'));
})->name('custom.password.reset');

Route::post('/custom-password/reset', function (Request $request) {
    $request->validate([
        'token' => 'required',
        'email' => 'required|email',
        'password' => 'required|confirmed|min:8',
    ]);

    $status = Password::reset(
        $request->only('email', 'password', 'password_confirmation', 'token'),
        function ($user, $password) {
            $user->forceFill(['password' => bcrypt($password)])->save();
        }
    );

    return $status === Password::PASSWORD_RESET
        ? redirect('/admin')->with('status', __($status))
        : back()->withErrors(['email' => [__($status)]]);
})->name('custom.password.update');