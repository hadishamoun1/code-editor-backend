<?php

use App\Http\Controllers\Api\CodeController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/users', [UserController::class, 'index']);
Route::get('/users/{id}', [UserController::class, 'show']);
Route::post('/users', [UserController::class, 'store']);
Route::put('/users/{id}', [UserController::class, 'update']);
Route::delete('/users/{id}', [UserController::class, 'destroy']);



Route::get('/code', [CodeController::class, 'index']);
Route::get('/code/{id}', [CodeController::class, 'show']);
Route::post('/code', [CodeController::class, 'store']);
Route::put('/code/{id}', [CodeController::class, 'update']);
Route::delete('/code/{id}', [CodeController::class, 'destroy']);