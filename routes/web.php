<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TenantFormController;
use App\Http\Controllers\PurchaseController;

use App\Http\Controllers\DashboardController;

Route::get('/', [\App\Http\Controllers\Auth\LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [\App\Http\Controllers\Auth\LoginController::class, 'login'])->name('login.submit');
Route::post('/logout', [\App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');

Route::middleware(['auth', 'role'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/tenants/create', [TenantFormController::class, 'create'])->name('tenants.create');
    Route::post('/tenants/create', [TenantFormController::class, 'store'])->name('tenants.store');
    Route::delete('/tenants/{tenant}', [TenantFormController::class, 'destroy'])->name('tenants.destroy');
    Route::get('/tenants/edit/{tenant}', [TenantFormController::class, 'edit'])->name('tenants.edit');
    Route::put('/tenants/{tenant}', [TenantFormController::class, 'update'])->name('tenants.update');
    Route::get('/tenants', [TenantFormController::class, 'index'])->name('tenants.index');
    Route::get('/tenants/{tenant}', [TenantFormController::class, 'show'])->name('tenants.show');
    Route::get('/products', [App\Http\Controllers\ProductController::class, 'index'])->name('products.index');
    Route::get('/products/{product}', [App\Http\Controllers\ProductController::class, 'show'])->name('products.show');
    Route::get('/carts/{cart}', [App\Http\Controllers\CartController::class, 'show'])->name('carts.show');
    Route::get('/purchases/{purchase}', [PurchaseController::class, 'show'])->name('purchases.show');
    Route::resource('users', \App\Http\Controllers\UserController::class);
});

