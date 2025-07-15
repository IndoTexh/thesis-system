<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SecurityController;
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

// Student & Thesis
Route::middleware('auth')->group(function() {

  Route::get('/confirm-password', [SecurityController::class, 'confirmView'])->name('password.confirm');
  Route::post('/confirm-password', [SecurityController::class, 'validatePassword'])->middleware(['throttle:6,1']);

  Route::get('/student/profile', [ProfileController::class, 'index'])->middleware(['password.confirm']);
  Route::get('/student/profile/upload', [ProfileController::class, 'upload'])->name('profile.upload')->middleware('password.confirm');
  Route::post('/student/profile/upload', [ProfileController::class, 'store'])->name('profile.store');
  Route::post('/student/profile/update', [ProfileController::class, 'updateInfo'])->name('profile.update');
  Route::post('/student/profile/update-password', [ProfileController::class, 'updatePassword']);

  Route::get('/student/theses', [ThesisController::class, 'index'])->name('theses.index')->middleware('password.confirm');
  Route::get('/student/theses/upload', [ThesisController::class, 'create'])->name('theses.create');
  Route::post('/student/theses/upload', [ThesisController::class, 'store']);
  Route::get('/student/theses/{thesis}/edit', [ThesisController::class, 'edit']);
  Route::post('/student/theses/{thesis}/update', [ThesisController::class, 'update']);
});