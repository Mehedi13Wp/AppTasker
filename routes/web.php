<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Worker\WorkerDashboardController;
use App\Http\Controllers\Worker\TaskController;
use App\Http\Controllers\Worker\TaskSubmissionController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (! auth()->check()) {
        return redirect()->route('login');
    }

    return match (auth()->user()->role) {
        'admin' => redirect()->route('admin.dashboard'),
        'worker' => redirect()->route('worker.dashboard'),
        'client' => redirect()->route('client.dashboard'),
        default => redirect()->route('login'),
    };
})->name('home');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.store');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.store');
});

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

Route::middleware(['auth', 'role:admin'])->get('/admin', fn () => 'AppTasker Admin Dashboard')->name('admin.dashboard');
Route::middleware(['auth', 'role:client'])->get('/client', fn () => view('client.dashboard'))->name('client.dashboard');
Route::middleware(['auth', 'role:worker'])->group(function () {
    Route::get('/worker', [WorkerDashboardController::class, 'index'])->name('worker.dashboard');
    Route::get('/worker/history', [WorkerDashboardController::class, 'history'])->name('worker.history');
    Route::get('/worker/wallet', [WorkerDashboardController::class, 'wallet'])->name('worker.wallet');
    Route::get('/worker/profile', [WorkerDashboardController::class, 'profile'])->name('worker.profile');
    Route::get('/worker/tasks/{task}', [TaskController::class, 'show'])->name('worker.tasks.show');
    Route::post('/worker/tasks/{task}/start', [TaskController::class, 'start'])->name('worker.tasks.start');
    Route::post('/worker/tasks/{task}/submit', [TaskSubmissionController::class, 'store'])->name('worker.tasks.submit');
});
