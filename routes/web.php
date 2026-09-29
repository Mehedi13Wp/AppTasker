<?php

use App\Http\Controllers\Auth\AuthController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn () => view('welcome'))->name('home');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.store');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.store');
});

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

Route::middleware(['auth', 'role:admin'])->get('/admin', fn () => 'AppTasker Admin Dashboard')->name('admin.dashboard');
Route::middleware(['auth', 'role:client'])->get('/client', fn () => view('client.dashboard'))->name('client.dashboard');
Route::middleware(['auth', 'role:worker'])->get('/worker', fn () => 'AppTasker Worker Dashboard')->name('worker.dashboard');
