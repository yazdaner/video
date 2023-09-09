<?php

use Yazdan\User\App\Models\User;
use Yazdan\Payment\Gateways\Gateway;
use Yazdan\Course\App\Models\Course;
use Yazdan\RolePermissions\Repositories\RoleRepository;


Route::get('/l', function () {
    $user = User::factory()->create();
    $user->assignRole(RoleRepository::ROLE_SUPER_ADMIN);
    auth()->loginUsingId($user->id);
    return back();
});

Route::get('/u', function () {
    $user = User::factory()->create();
    auth()->loginUsingId($user->id);
    return back();
});


Route::get('/un', function () {
    $user = User::factory()->unverified()->create();
    auth()->loginUsingId($user->id);

    return back();
});

Route::get('/ad', function () {
    $user = User::factory()->create();
    $user->assignRole(RoleRepository::ROLE_SUPER_ADMIN);
    auth()->loginUsingId($user->id);
    return back();
});

Route::get('/t', function () {
    $user = User::factory()->create();
    $user->assignRole('teacher');
    auth()->loginUsingId($user->id);
    Course::factory()->state(['teacher_id' => auth()->id()])->create();

    return back();
});

Route::get('/aa', function () {
    return Course::factory()->create();
});
Route::get('/logout', function () {
    auth()->logout();
});
Route::get('/www', function () {
    $minutes = 10000;
    $h = intdiv($minutes, 60) < 10 ? '0' . intdiv($minutes, 60) : intdiv($minutes, 60) ;
    $m = ($minutes % 60) < 10 ? '0' . ($minutes % 60) : ($minutes % 60) ;
    return $h . ':' . $m;
});

// Route::get('/ob', function () {
//     $gateway = resolve(Gateway::class);
//     dd($gateway->);
// });
