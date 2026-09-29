<?php

use App\Http\Controllers\Auth\AuthController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.store');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.store');
});

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

Route::get('/admin', fn () => 'AppTasker Admin Dashboard')->middleware('auth')->name('admin.dashboard');
Route::get('/client', fn () => 'AppTasker Client Dashboard')->middleware('auth')->name('client.dashboard');
Route::get('/worker', fn () => 'AppTasker Worker Dashboard')->middleware('auth')->name('worker.dashboard');
