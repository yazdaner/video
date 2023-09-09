<?php

use Yazdan\Payment\App\Http\Controllers\PaymentController;


Route::any('/payment/callback/',[PaymentController::class,'callback'])->name('payment.callback');


Route::prefix('admin-panel')->name('admin.')->middleware([
    'auth',
    'verified'
])->group(function () {
    providerGetRoute('/payments',PaymentController::class,'index','payments.index');
});




