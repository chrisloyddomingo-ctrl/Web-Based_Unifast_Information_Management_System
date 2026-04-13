<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\ApplicationController;

Route::post('/submit', [ApplicationController::class, 'submit']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
