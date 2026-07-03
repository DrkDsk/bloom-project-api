<?php

use App\Http\Controllers\FcmController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('devices')->group(function () {
    Route::post('register', [FcmController::class, 'register']);
    Route::post('login', [FcmController::class, 'login'])->name('login');
    Route::post('trigger', [FcmController::class, 'trigger'])->name('trigger');
});

