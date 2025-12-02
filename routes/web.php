<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\RegisterUserController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\AccountabilityController;


// Auth
Route::get('/', [SessionController::class, 'index'])->name('login');
Route::post('/login', [SessionController::class, 'store']);
Route::post('/logout', [SessionController::class, 'destroy']);

Route::get('/register', [RegisterUserController::class, 'index']);
Route::post('/register', [RegisterUserController::class, 'store']);


Route::resource('units', UnitController::class)->except(['show'])->middleware('auth');
Route::get('/units/next-control/{categoryId}', [UnitController::class, 'getNextControlNo']);
Route::post('/inventory/import', [UnitController::class, 'import'])->name('inventory.import');


Route::resource('accountability', AccountabilityController::class)->except(['show'])->middleware('auth');
Route::get('/accountability/print', [AccountabilityController::class, 'print'])->name('accountability.print')->middleware('auth');
