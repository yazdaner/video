<?php

use Yazdan\Course\App\Http\Controllers\SeasonController;

Route::prefix('admin-panel')->name('admin.')->middleware([
    'auth',
    'verified'
])->group(function(){

    Route::post('seasons/{course}/store',[SeasonController::class,'store'])->name('seasons.store');

    Route::patch('seasons/{season}/accepted',[SeasonController::class,'accepted'])->name('seasons.accepted');
    Route::patch('seasons/{season}/rejected',[SeasonController::class,'rejected'])->name('seasons.rejected');

    Route::delete('seasons/{season}',[SeasonController::class,'destroy'])->name('seasons.destroy');
    Route::get('courses/{season}/seasons',[SeasonController::class,'edit'])->name('seasons.edit');
    Route::patch('seasons/{season}',[SeasonController::class,'update'])->name('seasons.update');

});
