<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;

Route::post('/user/login', [AuthController::class, 'login'])->name('user.login');
Route::post('/user/register', [AuthController::class, 'store'])->name('user.register');

Route::middleware('auth:sanctum')->prefix('admin')->group(function () {
    // Route::apiResource('')
});