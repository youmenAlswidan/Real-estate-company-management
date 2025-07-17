<?php

use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/', function () {
    return view('login');
})->name('login');

Auth::routes();



Route::middleware(['auth','role:admin'])->group( function() {
    Route::get('/admin/properties', function(){
        return view('admin.properties.index');
    })->name('admin.properties.index');
});


Route::middleware(['auth','role:employee'])->group( function() {
    Route::get('/employee/bookings', function(){
        return view('employee.bookings.index');
    })->name('employee.bookings.index');
});
