<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminManagementController;
use App\Http\Controllers\Admin\AdminWithdrawalController;
use App\Http\Controllers\Admin\AdminCampaignController;
use App\Http\Controllers\Admin\PaymentSettingsController;
use App\Http\Controllers\Worker\WorkerDashboardController;
use App\Http\Controllers\Client\ClientDashboardController;
use App\Http\Controllers\Client\BkashPaymentController;
use App\Http\Controllers\Worker\TaskController;
use App\Http\Controllers\Worker\TaskSubmissionController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'home')->name('home');

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
    Route::get('/admin/submissions/{submission}/download', [AdminDashboardController::class, 'download'])->name('admin.submissions.download');
    Route::patch('/admin/submissions/{submission}', [AdminDashboardController::class, 'review'])->name('admin.submissions.review');
    Route::get('/admin/tasks', [AdminManagementController::class, 'tasks'])->name('admin.tasks');
    Route::post('/admin/tasks', [AdminManagementController::class, 'storeTask'])->name('admin.tasks.store');
    Route::patch('/admin/tasks/{task}/status', [AdminManagementController::class, 'taskStatus'])->name('admin.tasks.status');
    Route::get('/admin/workers', [AdminManagementController::class, 'workers'])->name('admin.workers');
    Route::get('/admin/clients', [AdminManagementController::class, 'clients'])->name('admin.clients');
    Route::patch('/admin/users/{user}/status', [AdminManagementController::class, 'userStatus'])->name('admin.users.status');
    Route::get('/admin/withdrawals', [AdminWithdrawalController::class, 'index'])->name('admin.withdrawals');
    Route::patch('/admin/withdrawals/{withdrawal}', [AdminWithdrawalController::class, 'update'])->name('admin.withdrawals.update');
    Route::get('/admin/campaigns', [AdminCampaignController::class, 'index'])->name('admin.campaigns');
    Route::patch('/admin/campaigns/{campaign}', [AdminCampaignController::class, 'update'])->name('admin.campaigns.update');
    Route::get('/admin/payment-settings', [PaymentSettingsController::class, 'index'])->name('admin.payment-settings');
    Route::patch('/admin/payment-settings', [PaymentSettingsController::class, 'update'])->name('admin.payment-settings.update');
});
Route::middleware(['auth', 'role:client'])->group(function () {
    Route::get('/client', [ClientDashboardController::class, 'index'])->name('client.dashboard');
    Route::post('/client/campaigns', [ClientDashboardController::class, 'store'])->name('client.campaigns.store');
    Route::get('/client/campaigns/{campaign}/pay', [BkashPaymentController::class, 'checkout'])->name('client.bkash.checkout');
    Route::post('/client/campaigns/{campaign}/demo-pay', [BkashPaymentController::class, 'demoPay'])->name('client.bkash.demo-pay');
});
Route::middleware(['auth', 'role:worker'])->group(function () {
    Route::get('/worker', [WorkerDashboardController::class, 'index'])->name('worker.dashboard');
    Route::get('/worker/history', [WorkerDashboardController::class, 'history'])->name('worker.history');
    Route::get('/worker/wallet', [WorkerDashboardController::class, 'wallet'])->name('worker.wallet');
    Route::get('/worker/profile', [WorkerDashboardController::class, 'profile'])->name('worker.profile');
    Route::post('/worker/wallet/withdraw', [WorkerDashboardController::class, 'withdraw'])->name('worker.withdraw');
    Route::get('/worker/tasks/{task}', [TaskController::class, 'show'])->name('worker.tasks.show');
    Route::post('/worker/tasks/{task}/start', [TaskController::class, 'start'])->name('worker.tasks.start');
    Route::post('/worker/tasks/{task}/submit', [TaskSubmissionController::class, 'store'])->name('worker.tasks.submit');
});
