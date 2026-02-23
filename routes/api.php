<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ApiController;
use App\Http\Controllers\Api\ApplicationController;

Route::get('/users', [ApiController::class, 'users']);
Route::get('/users/{id}', [ApiController::class, 'user']);
Route::get('/posts', [ApiController::class, 'posts']);
Route::get('/posts/{id}', [ApiController::class, 'post']);

Route::post('/submit', [ApplicationController::class, 'submit']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
