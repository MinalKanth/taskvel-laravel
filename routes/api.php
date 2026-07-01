<?php

use App\Http\Controllers\ExportController;
use App\Http\Controllers\FocusController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\RemarkController;
use App\Http\Controllers\TaskController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

Route::middleware('auth:sanctum')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Authenticated User
    |--------------------------------------------------------------------------
    */

    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    /*
    |--------------------------------------------------------------------------
    | Tasks
    |--------------------------------------------------------------------------
    */

    // Route::apiResource('tasks', TaskController::class);

    Route::patch('/tasks/{task}/complete', [TaskController::class, 'complete']);
    Route::patch('/tasks/{task}/restore', [TaskController::class, 'restore']);
    Route::post('/tasks/{task}/duplicate', [TaskController::class, 'duplicate']);

    /*
    |--------------------------------------------------------------------------
    | Remarks
    |--------------------------------------------------------------------------
    */

    // Route::apiResource('remarks', RemarkController::class)
    //     ->only([
    //         'index',
    //         'store',
    //         'show',
    //         'update',
    //         'destroy',
    //     ]);

    /*
    |--------------------------------------------------------------------------
    | Focus Sessions
    |--------------------------------------------------------------------------
    */

    Route::get('/focus', [FocusController::class, 'index']);
    Route::post('/focus/start', [FocusController::class, 'start']);
    Route::post('/focus/stop', [FocusController::class, 'stop']);
    Route::get('/focus/history', [FocusController::class, 'history']);

    /*
    |--------------------------------------------------------------------------
    | Export
    |--------------------------------------------------------------------------
    */

    Route::post('/export', [ExportController::class, 'export']);

    /*
    |--------------------------------------------------------------------------
    | Notifications
    |--------------------------------------------------------------------------
    */

    Route::get('/notifications', [NotificationController::class, 'index']);
    Route::post('/notifications/{notification}/read', [NotificationController::class, 'markAsRead']);
    Route::post('/notifications/read-all', [NotificationController::class, 'markAllAsRead']);
});