<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Protected routes (requires authentication)
Route::middleware('auth:sanctum')->group(function () {
    // User Management (Admin only)
    Route::resource('users', App\Http\Controllers\Api\UserController::class)->except(['create', 'edit']);

    // Property Management
    Route::resource('properties', App\Http\Controllers\Api\PropertyController::class)->except(['create', 'edit']);

    // Tenant Management
    Route::resource('tenants', App\Http\Controllers\Api\TenantController::class)->except(['create', 'edit']);

    // Contract Management
    Route::resource('contracts', App\Http\Controllers\Api\ContractController::class)->except(['create', 'edit']);

    // Invoice Management
    Route::resource('invoices', App\Http\Controllers\Api\InvoiceController::class)->except(['create', 'edit']);

    // Payment Management
    Route::resource('payments', App\Http\Controllers\Api\PaymentController::class)->except(['create', 'edit']);

    // Expense Management
    Route::resource('expenses', App\Http\Controllers\Api\ExpenseController::class)->except(['create', 'edit']);

    // Purchase Management
    Route::resource('purchases', App\Http\Controllers\Api\PurchaseController::class)->except(['create', 'edit']);

    // Maintenance Management
    Route::resource('maintenance', App\Http\Controllers\Api\MaintenanceController::class)->except(['create', 'edit']);

    // Reports
    Route::prefix('reports')->controller(App\Http\Controllers\Api\ReportController::class)->group(function () {
        Route::get('expenses', 'expenseReport');
        Route::get('purchases', 'purchaseReport');
        Route::get('payments', 'paymentReport');
        Route::get('{reportType}/export/excel', 'exportExcel');
        Route::get('{reportType}/export/pdf', 'exportPdf');
    });

    // Notification Logs
    Route::resource('notifications', App\Http\Controllers\Api\NotificationController::class)->only(['index', 'show']);

    // File Upload/Management (AWS S3)
    Route::post('files/upload', [App\Http\Controllers\Api\FileController::class, 'upload']);
    Route::get('files/{id}', [App\Http\Controllers\Api\FileController::class, 'show']);
    Route::delete('files/{id}', [App\Http\Controllers\Api\FileController::class, 'destroy']);
});
