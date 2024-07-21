<?php

use App\Http\Controllers\Api\CategoryController;
use Illuminate\Support\Facades\Route;
use Laravel\Sanctum\Sanctum;

Route::apiResource('categories', CategoryController::class)->middleware('auth:sanctum');
