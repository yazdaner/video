<?php

use Yazdan\User\Models\User;
use Yazdan\User\Http\Controllers\Auth\VerificationController;


Route::group([
    'namespace' => 'Yazdan\User\Http\Controllers',
    'middleware' => 'web'
],function(){
    Auth::routes(['verify' => true]);
    Route::post('/email/verify',[VerificationController::class,'verify'])->name('verification.verify');
});
