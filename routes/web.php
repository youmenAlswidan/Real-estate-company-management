<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\PropertyTypeController;
use App\Http\Controllers\Admin\PropertyController;
use Illuminate\Support\Facades\Auth;



// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/', function () {
    return view('login');
})->name('login');

Auth::routes();



Route::middleware(['auth','role:admin'])
    ->prefix('admin')->name('admin.')
    ->group(function () {
        Route::resource('properties', PropertyController::class);
        Route::resource('property_types', PropertyTypeController::class);
  Route::delete('property-images/{id}', [PropertyController::class, 'destroyImage'])
            ->name('properties.images.destroy');    });


Route::middleware(['auth','role:employee'])->group( function() {
    Route::get('/employee/bookings', function(){
        return view('employee.bookings.index');
    })->name('employee.bookings.index');
});
