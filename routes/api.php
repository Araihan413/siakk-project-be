<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MahasiswaProfileController;
use App\Http\Controllers\DosenProfileController;

Route::post('/register', [AuthController::class, 'register']); 
Route::post('/auth/login', [AuthController::class, 'login']);
Route::post('/auth/logout', [AuthController::class, 'logout']);

Route::middleware(['auth:api', 'role:admin'])->group(function () {
    Route::get('/admin', [AuthController::class, 'index']);
    Route::get('/admin/{id}', [AuthController::class, 'show']);
});

Route::middleware(['auth:api', 'role:mahasiswa'])->group(function () {
    Route::get('/mahasiswa', [MahasiswaProfileController::class, 'index']);
    Route::get('/mahasiswa/{id}', [MahasiswaProfileController::class, 'show']);
    Route::put('/mahasiswa/{id}', [MahasiswaProfileController::class, 'update']);
    Route::delete('/mahasiswa/{id}', [MahasiswaProfileController::class, 'destroy']);
});

Route::middleware(['auth:api', 'role:dosen'])->group(function () {
    Route::get('/dosen', [DosenProfileController::class, 'index']);
    Route::get('/dosen/{id}', [DosenProfileController::class, 'show']);
    Route::put('/dosen/{id}', [DosenProfileController::class, 'update']);
    Route::delete('/dosen/{id}', [DosenProfileController::class, 'destroy']);
});
