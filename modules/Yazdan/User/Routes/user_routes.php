<?php

use Yazdan\User\App\Http\Controllers\UserController;
use Yazdan\User\App\Http\Controllers\Auth\LoginController;
use Yazdan\User\App\Http\Controllers\Auth\RegisterController;
use Yazdan\User\App\Http\Controllers\Auth\VerificationController;
use Yazdan\User\App\Http\Controllers\Auth\ResetPasswordController;
use Yazdan\User\App\Http\Controllers\Auth\ForgotPasswordController;


Route::prefix('admin-panel')->name('admin.')->middleware([
    'auth',
    'verified'
])->group(function () {

    // User Routes

    Route::resource('users', UserController::class);
    Route::post('users/{user}/add/role', [UserController::class, 'addRole'])->name('users.role');
    Route::delete('users/{user}/remove/{role}', [UserController::class, 'removeRole'])->name('users.removeRole');
    Route::patch('users/{user}/manualVerify', [UserController::class, 'manualVerify'])->name('users.manualVerify');
});


Route::group([
    'middleware' => [
        'auth',
        'verified'
    ]
], function () {

    // Update User's Photo
    Route::post('/users/updatePhoto', [UserController::class, 'updatePhoto'])->name('users.updatePhoto');

    // Profile
    providerGetRoute('/users/profile',UserController::class,'profile','users.profile');
    Route::patch('/users/profile', [UserController::class, 'updateProfile'])->name('users.profile');

    //todo
    Route::get('/users/profile/{username}', [UserController::class, 'showProfile'])->name('users.showProfile');
});



// Verification

Route::get('/email/verify', [VerificationController::class, 'show'])->name('verification.notice');
Route::post('/email/verify', [VerificationController::class, 'verify'])->name('verification.verify');

Route::post('/email/resend', [VerificationController::class, 'resend'])->name('verification.resend');

// login

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login');

// logout

Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Confirm Password

// Route::get('/password/confirm',[ConfirmPasswordController::class,'showConfirmForm'])->name('password.confirm');
// Route::post('/password/confirm',[ConfirmPasswordController::class,'confirm']);


// Register

Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register'])->name('register');

// Reset Password
Route::get('/password/reset/request', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::get('/password/email', [ForgotPasswordController::class, 'sendVerifyCodeResetPassword'])->name('password.sendVerifyCode');

Route::post('/password/reset/verify', [ForgotPasswordController::class, 'checkVerifyCodeResetPassword'])
    ->name('password.checkVerifyCode')
    ->middleware('throttle:5,1');

Route::get('/password/update', [ResetPasswordController::class, 'showResetForm'])
    ->name('password.showResetForm')
    ->middleware('auth');

Route::post('/password/update', [ResetPasswordController::class, 'update'])->name('password.update');
