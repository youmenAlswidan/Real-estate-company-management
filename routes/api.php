<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\Customer\AuthController;
use App\Http\Controllers\API\Customer\ReservationController;
use App\Http\Controllers\API\Property\PropertyController;

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);


Route::middleware('auth:api')->group(function () {
    Route::post('logout', [AuthController::class, 'logout']);
    Route::get('myprofile', [AuthController::class, 'my_profile']);
    Route::apiResource('reservations',ReservationController::class);
});

Route::get('properties', [PropertyController::class, 'index']);
Route::get('properties/{property}', [PropertyController::class, 'show']);

