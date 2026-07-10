<?php

use App\Http\Controllers\API\AmadeusEnterpriseController;
use App\Http\Controllers\Api\NewsletterController;
use App\Http\Controllers\Api\StorefrontAccountController;
use App\Http\Controllers\Api\StorefrontAddressController;
use App\Http\Controllers\Api\StorefrontAuthController;
use App\Http\Controllers\Api\StorefrontCheckoutController;
use App\Http\Controllers\Api\StorefrontContentController;
use App\Http\Controllers\Api\StorefrontController;
use App\Http\Controllers\Api\StorefrontWishlistController;
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
    Route::get('products/{slug}', [StorefrontController::class, 'productDetail']);
    Route::get('reels', [StorefrontController::class, 'reels']);
    Route::get('reviews', [StorefrontController::class, 'reviews']);
    Route::post('newsletter/subscribe', [NewsletterController::class, 'subscribe']);
    Route::post('cart/validate', [StorefrontController::class, 'validateCart']);

    Route::get('pages/{slug}', [StorefrontContentController::class, 'page']);
    Route::get('faqs', [StorefrontContentController::class, 'faqs']);
    Route::post('contact', [StorefrontContentController::class, 'contact'])->middleware('throttle:5,1');
    Route::get('seo', [StorefrontContentController::class, 'seo']);
    Route::get('site-settings', [StorefrontContentController::class, 'siteSettings']);

    Route::get('checkout/options', [StorefrontCheckoutController::class, 'options']);
    Route::post('orders', [StorefrontCheckoutController::class, 'store']);
    Route::get('orders/{orderNumber}', [StorefrontCheckoutController::class, 'show']);
    Route::post('orders/{orderNumber}/payment-proof', [StorefrontCheckoutController::class, 'uploadPaymentProof']);

    Route::middleware('auth:sanctum')->prefix('wishlist')->group(function () {
        Route::get('/', [StorefrontWishlistController::class, 'index']);
        Route::post('/merge', [StorefrontWishlistController::class, 'merge']);
        Route::post('/{product}', [StorefrontWishlistController::class, 'toggle']);
    });

    Route::middleware('auth:sanctum')->prefix('account')->group(function () {
        Route::get('summary', [StorefrontAccountController::class, 'summary']);
        Route::get('orders', [StorefrontAccountController::class, 'orders']);
        Route::get('orders/{orderNumber}', [StorefrontAccountController::class, 'orderDetail']);
        Route::patch('profile', [StorefrontAccountController::class, 'updateProfile']);
        Route::patch('password', [StorefrontAccountController::class, 'updatePassword']);

        Route::get('addresses', [StorefrontAddressController::class, 'index']);
        Route::post('addresses', [StorefrontAddressController::class, 'store']);
        Route::patch('addresses/{address}', [StorefrontAddressController::class, 'update']);
        Route::delete('addresses/{address}', [StorefrontAddressController::class, 'destroy']);
    });

    Route::prefix('auth')->group(function () {
        Route::post('register', [StorefrontAuthController::class, 'register'])->middleware('throttle:6,1');
        Route::post('login', [StorefrontAuthController::class, 'login'])->middleware('throttle:6,1');
        Route::post('forgot-password', [StorefrontAuthController::class, 'forgotPassword'])->middleware('throttle:6,1');
        Route::post('reset-password', [StorefrontAuthController::class, 'resetPassword'])->middleware('throttle:6,1');

        Route::middleware('auth:sanctum')->group(function () {
            Route::post('logout', [StorefrontAuthController::class, 'logout']);
            Route::get('me', [StorefrontAuthController::class, 'me']);
        });
    });
});