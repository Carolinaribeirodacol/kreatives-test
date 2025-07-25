<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// Login público (retorna token)
Route::post('/login', [UserController::class, 'login']);

// Rotas protegidas com token Sanctum
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/me', [UserController::class, 'me']);

    Route::get('/users', [UserController::class, 'index']);
    Route::get('/users/{id}', [UserController::class, 'show']);

    // Apenas admin pode criar, editar ou deletar usuários
    Route::middleware('admin')->group(function () {
        Route::post('/users', [UserController::class, 'store']);
        Route::put('/users/{id}', [UserController::class, 'update']);
        Route::delete('/users/{id}', [UserController::class, 'destroy']);
    });
});
