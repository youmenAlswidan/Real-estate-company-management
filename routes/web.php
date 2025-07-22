<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Admin\PropertyTypeController;
use App\Http\Controllers\Admin\PropertyController;
use App\Http\Controllers\Admin\PropertyServiceController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\PermissionController;

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

        // Properties
        Route::resource('properties', PropertyController::class);
        Route::delete('property-images/{id}', [PropertyController::class, 'destroyImage'])->name('properties.images.destroy');

        // Property Types
        Route::resource('property_types', PropertyTypeController::class);

        // Property Services
        Route::resource('property_services', PropertyServiceController::class);

        // Roles
        Route::resource('roles', RoleController::class);
        Route::get('roles/{role}/edit-permissions', [RoleController::class, 'editPermissions'])->name('roles.editPermissions');
        Route::put('roles/{role}/update-permissions', [RoleController::class, 'updatePermissions'])->name('roles.updatePermissions');

        // Permissions
        Route::resource('permissions', PermissionController::class);
});

Route::middleware(['auth','role:employee'])->group( function() {
    Route::get('/employee/bookings', function(){
        return view('employee.bookings.index');
    })->name('employee.bookings.index');
});
