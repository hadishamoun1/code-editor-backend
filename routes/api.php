<?php

use App\Http\Controllers\Api\CodeController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\MessageController;
use App\Http\Controllers\Api\ChatController;

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


Route::get('/message/{chatId}', [MessageController::class, 'getAllMessages']);
Route::post('/message/{chatId}', [MessageController::class,'createMessage']);
Route::put('/message/{id}', [MessageController::class,'updateMessage']);
Route::delete('/message/{id}', [MessageController::class,'deleteMessage']);


Route::get('/chat/{userid}', [ChatController::class, 'getUserChat']);
Route::post('/chat', [ChatController::class,'createChat']);
Route::put('/chat/{id}', [ChatController::class,'updateChat']);
Route::delete('/chat/{id}', [ChatController::class,'deleteChat']);