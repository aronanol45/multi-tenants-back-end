<?php
use App\Http\Controllers\Api\TenantController;
use Illuminate\Support\Facades\Route;

Route::get('/tenants', [TenantController::class, 'index']);
Route::get('/tenants/{id}', [TenantController::class, 'show']);
Route::post('/tenants', [TenantController::class, 'store']);

Route::get('/products', [\App\Http\Controllers\Api\ProductController::class, 'index']);
Route::get('/products/{id}', [\App\Http\Controllers\Api\ProductController::class, 'show']);