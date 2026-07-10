<?php
// routes/admin.php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\PageController;
use Illuminate\Support\Facades\Route;

// Protected Admin Routes
Route::middleware(['auth', 'admin'])->group(function () {

    // Dashboard now served from routes/admin_catalog.php (Admin\Catalog\DashboardController)
    // Customers now served from routes/admin_customers.php (Admin\Customers\CustomerController)

    // Pages Management Routes
    Route::prefix('pages')->name('admin.pages.')->group(function () {
        Route::get('/', [PageController::class, 'index'])->name('index');
        Route::get('/create', [PageController::class, 'create'])->name('create');
        Route::post('/', [PageController::class, 'store'])->name('store');
        Route::get('/{page}/edit', [PageController::class, 'edit'])->name('edit');
        Route::patch('/{page}', [PageController::class, 'update'])->name('update');
        Route::delete('/{page}', [PageController::class, 'destroy'])->name('destroy');
        Route::get('/{page}', [PageController::class, 'show'])->name('show');

        // Additional functionality
        Route::post('/bulk-action', [PageController::class, 'bulkAction'])->name('bulk-action');
        Route::post('/upload-image', [PageController::class, 'uploadImage'])->name('upload-image');
        Route::post('/{page}/duplicate', [PageController::class, 'duplicate'])->name('duplicate');
        Route::post('/update-sort-order', [PageController::class, 'updateSortOrder'])->name('update-sort-order');
    });

    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('admin.logout');
});