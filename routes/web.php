<?php

use App\Http\Controllers\ActivateAccController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\ClassController;
use App\Http\Controllers\MajorController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SecurityController;
use App\Http\Controllers\SupervisorClassController;
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

  Route::get('/profile', [ProfileController::class, 'index'])->middleware(['password.confirm']);
  Route::get('/profile/upload', [ProfileController::class, 'upload'])->name('profile.upload');
  Route::post('/profile/upload', [ProfileController::class, 'store'])->name('profile.store');
  Route::post('/profile/update', [ProfileController::class, 'updateInfo'])->name('profile.update');
  Route::post('/profile/update-password', [ProfileController::class, 'updatePassword']);

  Route::get('/student/theses', [ThesisController::class, 'index'])->name('theses.index')->middleware('password.confirm');
  Route::get('/student/theses/upload', [ThesisController::class, 'create'])->name('theses.create');
  Route::post('/student/theses/upload', [ThesisController::class, 'store']);
  Route::get('/student/theses/{thesis}/edit', [ThesisController::class, 'edit']);
  Route::post('/student/theses/{thesis}/update', [ThesisController::class, 'update']);
});

Route::middleware(['auth'])->group(function() {
  Route::get('/admin/create-major-&-class', [MajorController::class, 'create'])->name('major.create');
  Route::post('/admin/create-class', [ClassController::class, 'store']);
  Route::post('/admin/create-major', [MajorController::class, 'store']);

  Route::get('/admin/create-supervisor-&-class', [SupervisorClassController::class, 'create']);
  Route::post('/admin/create-supervisor-&-class', [SupervisorClassController::class, 'store']);
  Route::get('/supervisor/class-manage', [SupervisorClassController::class, 'myClass']);

  Route::get('/admin/activate-supervisor-account', [ActivateAccController::class, 'showActivate']);
  Route::post('/admin/activate-supervisor-account/{user}', [ActivateAccController::class, 'activate']);
  Route::post('/admin/disactivate-supervisor-account/{user}', [ActivateAccController::class, 'disactivate']);

});


