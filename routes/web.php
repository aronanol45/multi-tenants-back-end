<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TenantFormController;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/tenants/create', [TenantFormController::class, 'create'])->name('tenants.create');
Route::post('/tenants/create', [TenantFormController::class, 'store'])->name('tenants.store');

