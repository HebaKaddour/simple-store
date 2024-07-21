<?php

use App\Http\Controllers\Api\UserAuthController;
use App\Enums\TokenAbility;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::controller(UserAuthController::class)
->prefix('auth')
->group(function(){

    Route::post('register','register')->name('auth.register');
    Route::post('login','login')->name('auth.login');
});

