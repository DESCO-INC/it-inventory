<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\RegisterUserController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\AccountabilityController;
use App\Http\Controllers\MaintenanceController;


// Auth
Route::get('/', [SessionController::class, 'index'])->name('login');
Route::post('/login', [SessionController::class, 'store']);
Route::post('/logout', [SessionController::class, 'destroy']);

Route::get('/register', [RegisterUserController::class, 'index']);
Route::post('/register', [RegisterUserController::class, 'store']);


Route::prefix('units')->middleware(['auth'])->controller(UnitController::class)->group(function () {
    Route::get('/', 'index')->name('units.index');
    Route::get('/create', 'create')->name('units.create');
    Route::post('/', 'store')->name('units.store'); // <-- Add this
    Route::get('/{unit}/edit', 'edit')->name('units.edit');
    Route::put('/{unit}/update', 'update')->name('units.update');
    Route::delete('/{unit}/destroy', 'destroy')->name('units.destroy');

    
    Route::get('/next-control/{categoryId}', 'getNextControlNo')->name('units.getNextControlNo');
});

Route::post('/inventory/import', [UnitController::class, 'import'])->name('inventory.import');

Route::prefix('accountability')->middleware(['auth'])->controller(AccountabilityController::class)->group(function () {
    Route::get('/', 'index')->name('accountability.index');
    Route::post('/store', 'store')->name('accountability.store');
    Route::put('/{id}', 'update')->name('accountability.update'); 
    Route::delete('/{id}/destroy', 'destroy')->name('accountability.destroy');

    Route::get('/accountability/print', 'print')->name('accountability.print');
});


Route::prefix('maintenance')->middleware(['auth'])->controller(MaintenanceController::class)->group(function () {
    Route::get('/reports', 'reports')->name('maintenance.reports');
    Route::get('/users', 'users')->name('maintenance.users');
    Route::post('/users', 'store')->name('users.store');
    Route::put('/users/{id}', 'update')->name('users.update');
    Route::delete('/users/{id}', 'destroy')->name('users.destroy');
});
