<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MahasiswaProfileController;
use App\Http\Controllers\DosenProfileController;

Route::post('/register', [AuthController::class, 'register']); 
Route::post('/auth/login', [AuthController::class, 'login']);
Route::post('/auth/refresh', [AuthController::class, 'refresh']);
Route::post('/auth/logout', [AuthController::class, 'logout']);

Route::middleware(['jwt.cookie', 'role:admin'])->group(function () {
    Route::get('/admin', [AuthController::class, 'index']);
    Route::get('/admin/{id}', [AuthController::class, 'show']);
});

Route::middleware(['jwt.cookie', 'role:mahasiswa'])->group(function () {
    Route::get('/mahasiswa', [MahasiswaProfileController::class, 'index']);
    Route::get('/mahasiswa/{id}', [MahasiswaProfileController::class, 'show']);
    Route::put('/mahasiswa/{id}', [MahasiswaProfileController::class, 'update']);
    Route::delete('/mahasiswa/{id}', [MahasiswaProfileController::class, 'destroy']);
});

Route::middleware(['jwt.cookie', 'role:dosen'])->group(function () {
    Route::get('/dosen', [DosenProfileController::class, 'index']);
    Route::get('/dosen/{id}', [DosenProfileController::class, 'show']);
    Route::put('/dosen/{id}', [DosenProfileController::class, 'update']);
    Route::delete('/dosen/{id}', [DosenProfileController::class, 'destroy']);
});
