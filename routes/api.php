<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\SiswaController;
use App\Http\Controllers\Api\GuruController;
use App\Http\Controllers\Api\IndustriController;
use App\Http\Controllers\Api\PklController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
// API Routes untuk CRUD
Route::apiResource('users', UserController::class);
Route::apiResource('siswa', SiswaController::class);
Route::apiResource('guru', GuruController::class);
Route::apiResource('industri', IndustriController::class);
Route::apiResource('pkl', PklController::class);
// Additional routes for relationships
Route::get('siswa/{id}/pkl', [SiswaController::class, 'pkl']);
Route::get('guru/{id}/pkl', [GuruController::class, 'pkl']);
Route::get('industri/{id}/pkl', [IndustriController::class, 'pkl']);