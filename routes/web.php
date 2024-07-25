<?php

use App\Http\Controllers\Api\UserController;

use Illuminate\Support\Facades\Route;

Route::get("/",function(){
    return "helo";
});

Route::get('/users', [UserController::class, 'index']);
Route::get('/users/{id}', [UserController::class, 'show']);
Route::post('/users', [UserController::class, 'store']);
Route::put('/users/{id}', [UserController::class, 'update']);
Route::delete('/users/{id}', [UserController::class, 'destroy']);