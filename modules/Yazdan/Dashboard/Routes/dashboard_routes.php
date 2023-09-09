<?php

use Yazdan\Dashboard\App\Http\Controllers\DashboardController;

Route::group([
    'middleware' => [
    'verified'
],
    'prefix' => 'admin-panel'
],function(){

    Route::get('/dashboard',[DashboardController::class,'index'])->name('admin.dashboard');

});
