<?php

use Yazdan\Front\App\Http\Controllers\FrontController;


Route::get('/', [FrontController::class, 'index']);
Route::get('/courses/{slug}', [FrontController::class, 'singleCourse'])->name('singleCourse');
Route::get('/tutors/{username}', [FrontController::class, 'singleTutor'])->name('singleTutor');
