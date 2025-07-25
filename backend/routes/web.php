<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::post('/login', [UserController::class, 'login']);
Route::get('/user', [UserController::class, 'me'])->middleware('auth:sanctum');
