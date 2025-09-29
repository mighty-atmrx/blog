<?php

use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;

Route::get('/posts', [PostController::class, 'getAll']);
Route::get('/posts/{identifier}', [PostController::class, 'getByIdentifier']);
