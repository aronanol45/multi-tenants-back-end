<?php
use App\Http\Controllers\Api\TenantController;
use Illuminate\Support\Facades\Route;

Route::get('/tenants', [TenantController::class, 'index']);
Route::get('/tenants/{id}', [TenantController::class, 'show']);
Route::post('/tenants', [TenantController::class, 'store']);