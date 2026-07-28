<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Mail;

use App\Http\Controllers\InventorySoftwareController;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\AccountabilityController;
use App\Http\Controllers\SoftwareController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuditTrailController;

// Auth
Route::get('/', [AuthController::class, 'index'])->name('login');
Route::post('/login', [AuthController::class, 'store']);
Route::post('/logout', [AuthController::class, 'destroy'])->name('logout');

// Inventory Controller
Route::resource('inventory', InventoryController::class)->except(['show'])->middleware('auth');
Route::post('/inventory/import', [InventoryController::class, 'import'])->name('inventory.import');

// Accountability Controller
Route::resource('accountability', AccountabilityController::class)->except(['show'])->middleware('auth');
Route::get('/accountability/print', [AccountabilityController::class, 'print'])->name('accountability.print');
Route::get('/accountability/export', [AccountabilityController::class, 'export'])->name('accountability.export');

// Software
Route::resource('software', SoftwareController::class)->except(['show'])->middleware('auth');
Route::get('/software/maintenance', [SoftwareController::class, 'maintenance'])->name('software.maintenance');

// User Maintenance
Route::resource('user', UserController::class)->except(['show'])->middleware('auth');
Route::get('/user/profile', [UserController::class, 'profile'])->name('user.profile');

// SoftwareInventory
Route::resource('inventory_software', InventorySoftwareController::class)->except(['show'])->middleware('auth');
Route::get('/inventory_software/notification', [InventorySoftwareController::class, 'sendNotification'])->name('inventory_software.notification');

// Audit Trail
Route::resource('audit', AuditTrailController::class)->except(['show'])->middleware('auth');