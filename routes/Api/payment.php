<?php

use App\Http\Controllers\Api\PaymentController;
use Illuminate\Support\Facades\Route;


Route::controller(PaymentController::class)
->group(function(){

    Route::post('/handle','handle')->name('handle');
    Route::get('/confirm','confirm')->name('confirm');
});
