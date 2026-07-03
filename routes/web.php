<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\RemarkController;
use App\Http\Controllers\FocusController;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ThemeController;
use App\Http\Controllers\ProfileController;

use App\Http\Controllers\ClientController;
use App\Http\Controllers\ClientContactController;
use App\Http\Controllers\ClientAddressController;
use App\Http\Controllers\ClientServiceController;
use App\Http\Controllers\ClientDocumentController;
use App\Http\Controllers\ClientCredentialController;
use App\Http\Controllers\ClientRemarkController;
use App\Http\Controllers\ClientCommunicationController;
use App\Http\Controllers\ClientTagController;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return redirect()->route('dashboard');
});

/*
|--------------------------------------------------------------------------
| Authentication
|--------------------------------------------------------------------------
*/

require __DIR__ . '/auth.php';

/*
|--------------------------------------------------------------------------
| Authenticated Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Dashboard
    |--------------------------------------------------------------------------
    */

    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    /*
    |--------------------------------------------------------------------------
    | Profile
    |--------------------------------------------------------------------------
    */

    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');

    /*
    |--------------------------------------------------------------------------
    | Tasks
    |--------------------------------------------------------------------------
    */

    Route::resource('tasks', TaskController::class);

    Route::patch('/tasks/{task}/complete', [TaskController::class, 'complete'])
        ->name('tasks.complete');

    Route::patch('/tasks/{task}/restore', [TaskController::class, 'restore'])
        ->name('tasks.restore');

    Route::post('/tasks/{task}/duplicate', [TaskController::class, 'duplicate'])
        ->name('tasks.duplicate');

    /*
    |--------------------------------------------------------------------------
    | Remarks
    |--------------------------------------------------------------------------
    */

    Route::resource('remarks', RemarkController::class);
    Route::post('remarks/{remark}/toggle-pin', [RemarkController::class, 'togglePin'])->name('remarks.togglePin');

    

    /*
    |--------------------------------------------------------------------------
    | Focus Timer
    |--------------------------------------------------------------------------
    */

    Route::get('/focus', [FocusController::class, 'index'])
        ->name('focus.index');

    Route::post('/focus/start', [FocusController::class, 'start'])
        ->name('focus.start');

    Route::post('/focus/stop', [FocusController::class, 'stop'])
        ->name('focus.stop');

    Route::get('/focus/history', [FocusController::class, 'history'])
        ->name('focus.history');

    /*
    |--------------------------------------------------------------------------
    | Export
    |--------------------------------------------------------------------------
    */

    // Route::get('/export', [ExportController::class, 'index'])
    //     ->name('export.index');

    // Route::post('/export/download', [ExportController::class, 'export'])
    //     ->name('export.download');

    Route::prefix('export')->name('export.')->group(function () {
    Route::get('/',        [ExportController::class, 'index'])    ->name('index');
    Route::post('/download', [ExportController::class, 'download'])->name('download');
});

    /*
    |--------------------------------------------------------------------------
    | Notifications
    |--------------------------------------------------------------------------
    */

    // Route::get('/notifications', [NotificationController::class, 'index'])
    //     ->name('notifications.index');

    // Route::patch('/notifications/{notification}/read', [NotificationController::class, 'markAsRead'])
    //     ->name('notifications.read');

    // Route::post('/notifications/read-all', [NotificationController::class, 'markAllAsRead'])
    //     ->name('notifications.readAll');

    Route::delete('/notifications/{notification}', [NotificationController::class, 'destroy'])
        ->name('notifications.destroy');

        Route::prefix('notifications')->name('notifications.')->group(function () {
    Route::get('/',                              [NotificationController::class, 'index'])       ->name('index');
    Route::post('/read-all',                     [NotificationController::class, 'readAll'])     ->name('readAll');
    Route::delete('/clear-read',                 [NotificationController::class, 'clearRead'])   ->name('clearRead');
    Route::get('/unread-count',                  [NotificationController::class, 'unreadCount']) ->name('unreadCount');
    Route::get('/{notification}',                [NotificationController::class, 'show'])        ->name('show');
    Route::patch('/{notification}/read',         [NotificationController::class, 'read'])        ->name('read');
    Route::delete('/{notification}',             [NotificationController::class, 'destroy'])     ->name('destroy');
});



/*
|--------------------------------------------------------------------------
| Client Management (CRM)
|--------------------------------------------------------------------------
*/

Route::resource('clients', ClientController::class);

Route::resource('client-contacts', ClientContactController::class);

Route::resource('client-addresses', ClientAddressController::class);

Route::resource('client-services', ClientServiceController::class);

Route::resource('client-documents', ClientDocumentController::class);

Route::resource('client-credentials', ClientCredentialController::class);

Route::resource('client-remarks', ClientRemarkController::class);

Route::resource('client-communications', ClientCommunicationController::class);

Route::resource('client-tags', ClientTagController::class);



/*
|--------------------------------------------------------------------------
| Client Management
|--------------------------------------------------------------------------
*/

Route::resource('clients', ClientController::class);

Route::post('/clients/bulk-action', [ClientController::class, 'bulkAction'])
    ->name('clients.bulk-action');

Route::patch('/clients/{client}/restore', [ClientController::class, 'restore'])
    ->name('clients.restore');

Route::get('/clients/export', [ClientController::class, 'export'])
    ->name('clients.export');

Route::post('/clients/import', [ClientController::class, 'import'])
    ->name('clients.import');

Route::prefix('client-addresses')
    ->name('client-addresses.')
    ->group(function () {

        Route::post('/bulk-action', [ClientAddressController::class, 'bulkAction'])
            ->name('bulk-action');

        Route::get('/export', [ClientAddressController::class, 'export'])
            ->name('export');

    });
    
    /*
    |--------------------------------------------------------------------------
    | Theme
    |--------------------------------------------------------------------------
    */

    Route::post('/theme/toggle', [ThemeController::class, 'toggle'])
        ->name('theme.toggle');

});

/*
|--------------------------------------------------------------------------
| Fallback Route
|--------------------------------------------------------------------------
*/

Route::fallback(function () {
    abort(404);
});