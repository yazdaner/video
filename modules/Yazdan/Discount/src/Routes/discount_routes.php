<?php

use Yazdan\Discount\App\Http\Controllers\DiscountController;

Route::prefix('admin-panel')->name('admin.')->middleware([
    'auth',
    'verified'
])->group(function(){

    providerGetRoute('/discounts',DiscountController::class,'index','discounts.index');

    Route::post("/discounts",[DiscountController::class,'store'])->name("discounts.store");



    Route::delete("/discounts/{discount}", [DiscountController::class,'destroy'])->name("discounts.destroy");
    Route::get("/discounts/{discount}/edit", [DiscountController::class,'edit'])->name("discounts.edit");
    Route::put("/discounts/{discount}", [DiscountController::class,'update'])->name("discounts.update");

    Route::get("/discounts/{code}/{course}/check", [DiscountController::class,'check'])->name("discounts.check")->middleware("throttle:6,1");
});
