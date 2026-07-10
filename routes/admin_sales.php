<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\Sales\OrderController;
use App\Http\Controllers\Admin\Sales\PaymentController;
use App\Http\Controllers\Admin\Sales\ShippingController;

// Rinmora e-commerce admin (Sales module: Orders/Payments/Shipping).
// Same conventions as routes/admin_catalog.php — lives directly under
// /admin, no extra URI prefix, route names under admin.sales.*.
Route::middleware(['auth', 'admin'])->group(function () {
    Route::name('admin.sales.')->group(function () {
        Route::resource('orders', OrderController::class)->only(['index', 'create', 'store', 'show']);
        Route::patch('orders/{order}/status', [OrderController::class, 'updateStatus'])->name('orders.status');
        Route::post('orders/{order}/cancel', [OrderController::class, 'cancel'])->name('orders.cancel');
        Route::post('orders/{order}/verify-payment', [OrderController::class, 'verifyPayment'])->name('orders.verify-payment');
        Route::get('orders/{order}/invoice', [OrderController::class, 'invoice'])->name('orders.invoice');
        Route::get('orders/{order}/shipping-label', [OrderController::class, 'shippingLabel'])->name('orders.shipping-label');

        Route::get('payments', [PaymentController::class, 'index'])->name('payments.index');
        Route::patch('payments/gateways/{gateway}', [PaymentController::class, 'updateGateway'])->name('payments.gateways.update');
        Route::patch('refunds/{refund}/stage', [PaymentController::class, 'updateRefundStage'])->name('refunds.stage');
        Route::post('bank-accounts', [PaymentController::class, 'storeBankAccount'])->name('bank-accounts.store');
        Route::patch('bank-accounts/{bankAccount}', [PaymentController::class, 'updateBankAccount'])->name('bank-accounts.update');
        Route::delete('bank-accounts/{bankAccount}', [PaymentController::class, 'destroyBankAccount'])->name('bank-accounts.destroy');

        Route::get('shipping', [ShippingController::class, 'index'])->name('shipping.index');
        Route::post('shipping/zones', [ShippingController::class, 'storeZone'])->name('shipping.zones.store');
        Route::patch('shipping/zones/{zone}', [ShippingController::class, 'updateZone'])->name('shipping.zones.update');
        Route::delete('shipping/zones/{zone}', [ShippingController::class, 'destroyZone'])->name('shipping.zones.destroy');
        Route::post('shipping/zones/{zone}/methods', [ShippingController::class, 'storeMethod'])->name('shipping.methods.store');
        Route::patch('shipping/methods/{method}', [ShippingController::class, 'updateMethod'])->name('shipping.methods.update');
        Route::delete('shipping/methods/{method}', [ShippingController::class, 'destroyMethod'])->name('shipping.methods.destroy');
        Route::put('shipping/free-threshold', [ShippingController::class, 'updateFreeThreshold'])->name('shipping.free-threshold');
    });
});
