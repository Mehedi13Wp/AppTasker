<?php

use App\Http\Controllers\Api\WorkerTaskAppController;
use Illuminate\Support\Facades\Route;

Route::prefix('worker-task')->group(function () {
    Route::get('/{token}', [WorkerTaskAppController::class, 'task']);
    Route::post('/{token}/opened', [WorkerTaskAppController::class, 'opened']);
    Route::post('/{token}/completed', [WorkerTaskAppController::class, 'completed']);
});
