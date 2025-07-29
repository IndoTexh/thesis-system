<?php

use App\Http\Controllers\AuthApiController;
use App\Http\Controllers\ProfileApiController;
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

// Thesis
Route::post('/thesis-upload', [ThesisApiController::class, 'store']);
Route::post('/thesis-update', [ThesisApiController::class, 'update']);


// Profile

Route::post('/profile-upload', [ProfileApiController::class, 'store']);
Route::post('/profile-update-info', [ProfileApiController::class, 'updateInfo']);
Route::post('profile-update-password', [ProfileApiController::class, 'updatePass']);

