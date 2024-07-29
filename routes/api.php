<?php

use App\Http\Controllers\Api\CodeController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\MessageController;
use App\Http\Controllers\Api\ChatController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CodeExecutionController;


//Route::get('/users', [UserController::class, 'index']);
Route::get('/users/{id}', [UserController::class, 'show']);
Route::post('/users', [UserController::class, 'store']);
Route::put('/users/{id}', [UserController::class, 'update']);
Route::delete('/users/{id}', [UserController::class, 'destroy']);



Route::get('/code', [CodeController::class, 'index']);
Route::get('/code/{id}', [CodeController::class, 'show']);
Route::post('/code', [CodeController::class, 'store']);
Route::put('/code/{id}', [CodeController::class, 'update']);
Route::delete('/code/{id}', [CodeController::class, 'destroy']);


Route::get('/message/{chatId}', [MessageController::class, 'getAllMessages']);
Route::post('/message', [MessageController::class,'createMessage']);
Route::put('/message/{msgId}', [MessageController::class,'updateMessage']);
Route::delete('/message/{id}', [MessageController::class,'deleteMessage']);


Route::get('/chat/{userid}', [ChatController::class, 'getUserChats']);
Route::post('/chat', [ChatController::class,'createChat']);
Route::delete('/chat/{id}', [ChatController::class,'deleteChat']);

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/profile', [AuthController::class, 'profile']);



Route::post('/execute', [CodeExecutionController::class, 'execute']);

Route::middleware('checkAuth')->group(function () {
    Route::get('/users', [AuthController::class, 'index']);
    Route::post('/logout', [AuthController::class, 'logout']);
    
});