<?php

use Yazdan\Course\App\Http\Controllers\CourseController;

Route::prefix('admin-panel')->name('admin.')->middleware([
    'auth',
    'verified'
])->group(function(){

    Route::resource('courses',CourseController::class)->except(['show']);
    Route::patch('courses/{course}/accepted',[CourseController::class,'accepted'])->name('courses.accepted');
    Route::patch('courses/{course}/rejected',[CourseController::class,'rejected'])->name('courses.rejected');
    Route::get('courses/{course}/details',[CourseController::class,'details'])->name('courses.details');
    Route::get('courses/{course}/details',[CourseController::class,'details'])->name('courses.details');
    Route::post('courses/{course}/buy',[CourseController::class,'buy'])->name('courses.buy');

});

Route::middleware([
    'auth',
    'verified'
])->group(function(){

    Route::post('courses/{course}/buy',[CourseController::class,'buy'])->name('courses.buy');

});
