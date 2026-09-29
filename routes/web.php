<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/admin', function () {
    return 'AppTasker Admin Dashboard';
})->name('admin.dashboard');

Route::get('/client', function () {
    return 'AppTasker Client Dashboard';
})->name('client.dashboard');

Route::get('/worker', function () {
    return 'AppTasker Worker Dashboard';
})->name('worker.dashboard');
