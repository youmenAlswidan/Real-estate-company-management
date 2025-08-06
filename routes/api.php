<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\Customer\AuthController;
use App\Http\Controllers\API\Customer\ReservationController;
use App\Http\Controllers\API\Property\PropertyController;
use App\Http\Controllers\Api\Customer\ReviewController;


// Register
Route::post('register', [AuthController::class, 'register']);
// login
Route::post('login', [AuthController::class, 'login']);


Route::middleware('auth:api')->group(function () {
    Route::post('logout', [AuthController::class, 'logout']);
    // reservations
    Route::apiResource('reservations',ReservationController::class);
     // reviews
    Route::apiResource('reviews', ReviewController::class);
    Route::get('properties/{property}/reviews', [ReviewController::class, 'index']);

    


});
//properties
Route::get('properties', [PropertyController::class, 'index']);
Route::get('properties/{property}', [PropertyController::class, 'show']);

