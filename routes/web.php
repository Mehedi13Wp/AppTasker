<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminManagementController;
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

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/admin/submissions', [AdminDashboardController::class, 'submissions'])->name('admin.submissions');
    Route::patch('/admin/submissions/{submission}', [AdminDashboardController::class, 'review'])->name('admin.submissions.review');
    Route::get('/admin/tasks', [AdminManagementController::class, 'tasks'])->name('admin.tasks');
    Route::post('/admin/tasks', [AdminManagementController::class, 'storeTask'])->name('admin.tasks.store');
    Route::patch('/admin/tasks/{task}/status', [AdminManagementController::class, 'taskStatus'])->name('admin.tasks.status');
    Route::get('/admin/workers', [AdminManagementController::class, 'workers'])->name('admin.workers');
    Route::get('/admin/clients', [AdminManagementController::class, 'clients'])->name('admin.clients');
    Route::patch('/admin/users/{user}/status', [AdminManagementController::class, 'userStatus'])->name('admin.users.status');
});
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
