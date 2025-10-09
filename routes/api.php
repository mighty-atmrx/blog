<?php

use App\Presentation\Http\Controllers\PostController;
use App\Presentation\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/posts', [PostController::class, 'getAll']);
Route::get('/posts/{identifier}', [PostController::class, 'getByIdentifier']);
Route::post('/posts', [PostController::class, 'create']);
Route::patch('/posts/{identifier}', [PostController::class, 'update']);
Route::delete('/posts/{identifier}', [PostController::class, 'delete']);

Route::get('/users/{id}/posts', [PostController::class, 'getByUserId']);

Route::get('/users/{id}', [UserController::class, 'getUser']);
Route::post('/users', [UserController::class, 'register']);
Route::patch('/users/{id}', [UserController::class, 'update']);
Route::delete('/users/{id}', [UserController::class, 'delete']);
