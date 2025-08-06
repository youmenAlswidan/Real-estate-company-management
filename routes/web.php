<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Admin\PropertyTypeController;
use App\Http\Controllers\Admin\PropertyController;
use App\Http\Controllers\Admin\PropertyServiceController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\employee\ReservationManagementController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\employee\ReviewManagementController;

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/', function () {
    return view('login');
})->name('login');

Auth::routes();

Route::middleware(['auth', 'role:admin'])
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
        Route::get('reservations/pending', [ReservationManagementController::class, 'index'])->name('reservations.pending');


        //Reports
        Route::resource('reports', ReportController::class);
    });


Route::middleware(['auth', 'role:employee'])
    ->prefix('employee')->name('employee.')
    ->group(function () {
        Route::get('reservations/pending', [ReservationManagementController::class, 'index'])->name('reservations.pending');
        Route::patch('reservations/{reservation}/status', [ReservationManagementController::class, 'updateStatus'])->name('reservations.updateStatus'); // لاحظ هنا حذف كلمة employee.


          Route::get('/reviews', [ReviewManagementController::class, 'index'])->name('reviews.index');
    });
