<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\ThesisController;

Route::get('/', [HomeController::class, 'home'])->name('home');

Route::middleware('guest')->group(function () {
  Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
  Route::post('/register', [AuthController::class, 'register']);

  Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
  Route::post('/login', [AuthController::class, 'login']);
});


Route::middleware('auth')->group(function () {
  Route::get('/dashboard', [HomeController::class, 'dashboard']);
  Route::post('/logout', [AuthController::class, 'logout']);
});

// Thesis
Route::middleware('auth')->group(function() {
  Route::get('/student/theses', [ThesisController::class, 'index'])->name('theses.index');
  Route::get('/student/theses/upload', [ThesisController::class, 'create'])->name('theses.create');
  Route::post('/student/theses/upload', [ThesisController::class, 'store']);
  Route::get('/student/theses/{thesis}/edit', [ThesisController::class, 'edit']);
  Route::post('/student/theses/{thesis}/update', [ThesisController::class, 'update']);
});