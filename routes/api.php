<?php

use App\Http\Controllers\API\AmadeusEnterpriseController;
use App\Http\Controllers\Api\NewsletterController;
use App\Http\Controllers\Api\StorefrontController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('storefront')->group(function () {
    Route::get('home', [StorefrontController::class, 'home']);
    Route::get('layout', [StorefrontController::class, 'layout']);
    Route::get('categories', [StorefrontController::class, 'categories']);
    Route::get('products', [StorefrontController::class, 'products']);
    Route::get('reels', [StorefrontController::class, 'reels']);
    Route::get('reviews', [StorefrontController::class, 'reviews']);
    Route::post('newsletter/subscribe', [NewsletterController::class, 'subscribe']);
});