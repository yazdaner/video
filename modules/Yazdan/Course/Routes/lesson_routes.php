<?php

use Yazdan\Course\App\Http\Controllers\LessonController;

Route::prefix('admin-panel')->name('admin.')->middleware([
    'auth',
    'verified'
])->group(function(){

    Route::get('courses/{course}/lessons',[LessonController::class,'create'])->name('lessons.create');
    Route::post('courses/{course}/lessons',[LessonController::class,'store'])->name('lessons.store');

    Route::delete('lessons/{lesson}/delete',[LessonController::class,'destroy'])->name('lessons.destroy');
    Route::delete('lessons/destroyMultiple',[LessonController::class,'destroyMultiple'])->name('lessons.destroyMultiple');

    Route::patch('lessons/{lesson}/accepted',[LessonController::class,'accepted'])->name('lessons.accepted');
    Route::patch('lessons/acceptedMultiple',[LessonController::class,'acceptedMultiple'])->name('lessons.acceptedMultiple');
    Route::patch('lessons/acceptAll/{course}',[LessonController::class,'acceptAll'])->name('lessons.acceptAll');

    Route::patch('lessons/{lesson}/rejected',[LessonController::class,'rejected'])->name('lessons.rejected');
    Route::patch('lessons/rejectedMultiple',[LessonController::class,'rejectedMultiple'])->name('lessons.rejectedMultiple');
    Route::patch('lessons/rejectAll/{course}',[LessonController::class,'rejectAll'])->name('lessons.rejectAll');

    Route::get('courses/lessons/{lesson}/edit',[LessonController::class,'edit'])->name('lessons.edit');
    Route::put('courses/lessons/{lesson}/update',[LessonController::class,'update'])->name('lessons.update');

});
