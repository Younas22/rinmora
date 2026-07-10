<?php

use App\Http\Controllers\Admin\AuthController;
use Illuminate\Support\Facades\Route;

// Admin Login Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/signin', [AuthController::class, 'login'])->name('admin.signin.post');

// Root: send straight to the admin panel — redirects to the dashboard if
// already logged in, otherwise to the Rinmora-branded admin login page.
Route::get('/', [AuthController::class, 'showLogin'])->name('home');
