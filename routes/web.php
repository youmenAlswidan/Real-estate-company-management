<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\PropertyTypeController;

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/', function () {
    return view('login');
})->name('login');

Auth::routes();



Route::middleware(['auth','role:admin'])
    ->prefix('admin')->name('admin.')
    ->group( function() {

    Route::get('properties', function(){
        return view('admin.properties.index');
    })->name('properties.index');

    Route::resource('property_types',PropertyTypeController::class);

    
});


Route::middleware(['auth','role:employee'])->group( function() {
    Route::get('/employee/bookings', function(){
        return view('employee.bookings.index');
    })->name('employee.bookings.index');
});
