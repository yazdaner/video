<?php

use Yazdan\User\Models\User;


Route::group([
    'namespace' => 'Yazdan\User\Http\Controllers',
    'middleware' => 'web'
],function(){
    Auth::routes(['verify' => true]);
    Route::get('/test',function(){
        User::factory()->create();
    });
});
