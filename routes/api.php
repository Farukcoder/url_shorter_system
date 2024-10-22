<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ShortenedUrlController;

Route::post('/user/login', [AuthController::class, 'login'])->name('user.login');
Route::post('/user/register', [AuthController::class, 'store'])->name('user.register');

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('url-shorten', ShortenedUrlController::class);
});
