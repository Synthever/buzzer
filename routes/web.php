<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\AdminController;

// Public routes
Route::get('/', function () {
    return view('home');
})->name('home');

// Authentication Routes
Route::get('/login', [LoginController::class, 'showLoginForm'])
    ->name('login')
    ->middleware('guest');
Route::post('/login', [LoginController::class, 'login'])
    ->middleware('guest');
Route::post('/logout', [LoginController::class, 'logout'])
    ->name('logout');

// Registration Routes
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])
    ->name('register')
    ->middleware('guest');
Route::post('/register', [RegisterController::class, 'register'])
    ->middleware('guest');

// Protected Routes
Route::middleware(['auth'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/home/dashboard', [DashboardController::class, 'index'])->name('home.dashboard');
    
    // Task Routes
    Route::prefix('tasks')->name('tasks.')->group(function () {
        Route::get('/in-progress', [TaskController::class, 'inProgress'])->name('in-progress');
        Route::get('/{task}', [TaskController::class, 'show'])->name('show');
        Route::post('/', [TaskController::class, 'store'])->name('store');
        Route::put('/{task}', [TaskController::class, 'update'])->name('update');
        Route::delete('/{task}', [TaskController::class, 'destroy'])->name('destroy');
        Route::post('/{task}/submit-work', [TaskController::class, 'submitWork'])->name('submit-work');
        Route::patch('/{task}/status', [TaskController::class, 'updateStatus'])->name('update-status');
    });
    
    // Admin Routes - using full class name instead of alias
    Route::middleware([\App\Http\Middleware\AdminMiddleware::class])->prefix('admin')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
        Route::get('/users', [AdminController::class, 'users'])->name('admin.users');
        Route::get('/users/{user}', [AdminController::class, 'showUser'])->name('admin.users.show');
        Route::put('/users/{user}', [AdminController::class, 'updateUser'])->name('admin.users.update');
        Route::post('/users/{user}/reset-password', [AdminController::class, 'resetPassword'])->name('admin.users.reset-password');
        Route::post('/collaborations', [AdminController::class, 'createCollaboration'])->name('admin.collaborations.store');
        Route::delete('/collaborations/{collaboration}', [AdminController::class, 'destroyCollaboration'])->name('admin.collaborations.destroy');
    });
});