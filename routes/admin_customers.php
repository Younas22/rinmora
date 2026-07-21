<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\Customers\CustomerController;
use App\Http\Controllers\Admin\Customers\AddressController;
use App\Http\Controllers\Admin\Customers\WishlistController;
use App\Http\Controllers\Admin\Customers\RewardPointController;

// Rinmora e-commerce admin (Customers module). Same conventions as
// routes/admin_catalog.php and routes/admin_sales.php.
//
// IMPORTANT: the static routes below (addresses/wishlist/reward-points) must
// be declared BEFORE Route::resource('customers', ...) — that resource
// generates GET admin/customers/{customer}, which is the same one-segment
// shape as these static paths. If the resource were declared first, a
// request to /admin/customers/addresses would bind {customer} to the
// literal string "addresses" and 404 instead of hitting AddressController.
Route::middleware(['auth', 'admin'])->group(function () {
    Route::name('admin.customers.')->group(function () {
        Route::get('customers/addresses', [AddressController::class, 'index'])->name('addresses.index');
        Route::post('customers/addresses', [AddressController::class, 'store'])->name('addresses.store');
        Route::patch('customers/addresses/{address}', [AddressController::class, 'update'])->name('addresses.update');
        Route::delete('customers/addresses/{address}', [AddressController::class, 'destroy'])->name('addresses.destroy');

        Route::get('customers/wishlist', [WishlistController::class, 'index'])->name('wishlist.index');
        Route::get('customers/reward-points', [RewardPointController::class, 'index'])->name('reward-points.index');

        Route::delete('customers/bulk-delete', [CustomerController::class, 'destroyMany'])->name('destroyMany');
    });

    // Route::resource() prefixes route names with the resource name itself
    // ("customers.index" etc) — ->names() overrides that base so the final
    // names come out as "admin.customers.index", not
    // "admin.customers.customers.index".
    Route::resource('customers', CustomerController::class)->names('admin.customers');
});
