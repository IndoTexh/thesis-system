<?php

use App\Http\Controllers\AuthApiController;
use App\Http\Controllers\ThesisApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/login', [AuthApiController::class, 'login']);
Route::post('/register', [AuthApiController::class, 'register']);
Route::post('/logout', [AuthApiController::class, 'logout']);
Route::post('/check-session', [AuthApiController::class, 'checkSession']);


Route::post('/thesis-upload', [ThesisApiController::class, 'store']);