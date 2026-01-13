<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TenantFormController;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/tenants/create', [TenantFormController::class, 'create'])->name('tenants.create');
Route::post('/tenants/create', [TenantFormController::class, 'store'])->name('tenants.store');
Route::delete('/tenants/{tenant}', [TenantFormController::class, 'destroy'])->name('tenants.destroy');
Route::get('/tenants/edit/{tenant}', [TenantFormController::class, 'edit'])->name('tenants.edit');
Route::put('/tenants/{tenant}', [TenantFormController::class, 'update'])->name('tenants.update');
Route::get('/tenants', [TenantFormController::class, 'index'])->name('tenants.index');

