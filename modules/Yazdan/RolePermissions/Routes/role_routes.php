<?php

use Yazdan\RolePermissions\App\Http\Controllers\RoleController;

Route::prefix('admin-panel')->name('admin.')->middleware([
    'auth',
    'verified'
    ])->group(function () {

    Route::resource('roles',RoleController::class)->except([
        'create' , 'show'
    ]);

});
