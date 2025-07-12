<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;


Route::middleware('guest')->group(function () {
  Route::get('/', [HomeController::class, 'home'])->name('home');
  Route::get('/login', [AuthController::class, 'showLogin']);
  Route::post('/login', [AuthController::class, 'login'])->name('login');

  Route::get('/register', [AuthController::class, 'showRegister']);
  Route::post('/register', [AuthController::class, 'register']);
});

Route::middleware(['auth', 'force_logout'])->group(function () {
  Route::get('/dashboard', [HomeController::class, 'dashboard']);
  Route::post('/logout', [AuthController::class, 'logout']);
});
