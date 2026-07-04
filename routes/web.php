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
use App\Http\Controllers\ChatController;


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


Route::resource(
    'client-contacts',
    ClientContactController::class
);

Route::get(
    'client-contacts/trashed',
    [ClientContactController::class, 'trashed']
)->name('client-contacts.trashed');

Route::post(
    'client-contacts/{id}/restore',
    [ClientContactController::class, 'restore']
)->name('client-contacts.restore');

Route::delete(
    'client-contacts/{id}/force-delete',
    [ClientContactController::class, 'forceDelete']
)->name('client-contacts.force-delete');

Route::delete(
    'client-contacts/bulk-delete',
    [ClientContactController::class, 'bulkDelete']
)->name('client-contacts.bulk-delete');

Route::post(
    'client-contacts/bulk-restore',
    [ClientContactController::class, 'bulkRestore']
)->name('client-contacts.bulk-restore');

Route::delete(
    'client-contacts/empty-trash',
    [ClientContactController::class, 'emptyTrash']
)->name('client-contacts.empty-trash');

Route::get(
    'client-contacts/datatable',
    [ClientContactController::class, 'datatable']
)->name('client-contacts.datatable');

Route::get(
    'client-contacts/search',
    [ClientContactController::class, 'search']
)->name('client-contacts.search');

Route::delete(
    'client-contacts/{clientContact}/ajax-delete',
    [ClientContactController::class, 'ajaxDelete']
)->name('client-contacts.ajax-delete');

Route::resource('client-addresses', ClientAddressController::class);

Route::resource('client-services', ClientServiceController::class);

Route::resource('client-documents', ClientDocumentController::class);

Route::resource('client-credentials', ClientCredentialController::class);

Route::resource('client-remarks', ClientRemarkController::class);
Route::post(

    'client-remarks/{clientRemark}/resolve',

    [ClientRemarkController::class, 'resolve']

)->name('client-remarks.resolve');

Route::post(

    'client-remarks/{clientRemark}/reopen',

    [ClientRemarkController::class, 'reopen']

)->name('client-remarks.reopen');

Route::post(

    'client-remarks/{clientRemark}/pin',

    [ClientRemarkController::class, 'pin']

)->name('client-remarks.pin');

Route::post(

    'client-remarks/{clientRemark}/unpin',

    [ClientRemarkController::class, 'unpin']

)->name('client-remarks.unpin');

Route::delete(

    'client-remarks/bulk-delete',

    [ClientRemarkController::class, 'bulkDelete']

)->name('client-remarks.bulk-delete');

Route::get(

    'client-remarks/trashed',

    [ClientRemarkController::class, 'trashed']

)->name('client-remarks.trashed');

Route::post(

    'client-remarks/{id}/restore',

    [ClientRemarkController::class, 'restore']

)->name('client-remarks.restore');

Route::delete(

    'client-remarks/{id}/force-delete',

    [ClientRemarkController::class, 'forceDelete']

)->name('client-remarks.force-delete');

Route::post(

    'client-remarks/bulk-restore',

    [ClientRemarkController::class, 'bulkRestore']

)->name('client-remarks.bulk-restore');

Route::delete(

    'client-remarks/empty-trash',

    [ClientRemarkController::class, 'emptyTrash']

)->name('client-remarks.empty-trash');

Route::resource('client-communications', ClientCommunicationController::class);
Route::get(

    'client-communications/trashed',

    [ClientCommunicationController::class, 'trashed']

)->name('client-communications.trashed');

Route::post(

    'client-communications/{id}/restore',

    [ClientCommunicationController::class, 'restore']

)->name('client-communications.restore');

Route::delete(

    'client-communications/{id}/force-delete',

    [ClientCommunicationController::class, 'forceDelete']

)->name('client-communications.force-delete');

Route::delete(

    'client-communications/bulk-delete',

    [ClientCommunicationController::class, 'bulkDelete']

)->name('client-communications.bulk-delete');

Route::post(

    'client-communications/bulk-restore',

    [ClientCommunicationController::class, 'bulkRestore']

)->name('client-communications.bulk-restore');

Route::delete(

    'client-communications/empty-trash',

    [ClientCommunicationController::class, 'emptyTrash']

)->name('client-communications.empty-trash');

Route::get(

    'client-communications/datatable',

    [ClientCommunicationController::class, 'datatable']

)->name('client-communications.datatable');

Route::get(

    'client-communications/search',

    [ClientCommunicationController::class, 'search']

)->name('client-communications.search');

Route::delete(

    'client-communications/{clientCommunication}/ajax-delete',

    [ClientCommunicationController::class, 'ajaxDelete']

)->name('client-communications.ajax-delete');

Route::patch(

    'client-communications/{clientCommunication}/change-status',

    [ClientCommunicationController::class, 'changeStatus']

)->name('client-communications.change-status');

Route::resource('client-tags', ClientTagController::class);
Route::get(
    'client-tags/trashed',
    [ClientTagController::class, 'trashed']
)->name('client-tags.trashed');

Route::post(
    'client-tags/{id}/restore',
    [ClientTagController::class, 'restore']
)->name('client-tags.restore');

Route::delete(
    'client-tags/{id}/force-delete',
    [ClientTagController::class, 'forceDelete']
)->name('client-tags.force-delete');

Route::post(
    'client-tags/bulk-delete',
    [ClientTagController::class, 'bulkDelete']
)->name('client-tags.bulk-delete');

Route::post(
    'client-tags/bulk-restore',
    [ClientTagController::class, 'bulkRestore']
)->name('client-tags.bulk-restore');

Route::delete(
    'client-tags/empty-trash',
    [ClientTagController::class, 'emptyTrash']
)->name('client-tags.empty-trash');

Route::get(
    'client-tags/datatable',
    [ClientTagController::class, 'datatable']
)->name('client-tags.datatable');

Route::get(
    'client-tags/search',
    [ClientTagController::class, 'search']
)->name('client-tags.search');

Route::get(
    'client-tags/options',
    [ClientTagController::class, 'options']
)->name('client-tags.options');

Route::patch(
    'client-tags/{clientTag}/toggle-status',
    [ClientTagController::class, 'toggleStatus']
)->name('client-tags.toggle-status');

Route::resource('client-documents', ClientDocumentController::class);

Route::get(
    'client-documents/{clientDocument}/download',
    [ClientDocumentController::class, 'download']
)->name('client-documents.download');

Route::get(
    'client-documents/{clientDocument}/preview',
    [ClientDocumentController::class, 'preview']
)->name('client-documents.preview');

Route::post(
    'client-documents/{clientDocument}/replace',
    [ClientDocumentController::class, 'replace']
)->name('client-documents.replace');

Route::get(
    'client-documents/{clientDocument}/view-pdf',
    [ClientDocumentController::class, 'viewPdf']
)->name('client-documents.view-pdf');

Route::get(

    'client-documents/trashed',

    [ClientDocumentController::class, 'trashed']

)->name('client-documents.trashed');

Route::post(

    'client-documents/bulk-delete',

    [ClientDocumentController::class, 'bulkDelete']

)->name('client-documents.bulk-delete');

Route::post(

    'client-documents/bulk-restore',

    [ClientDocumentController::class, 'bulkRestore']

)->name('client-documents.bulk-restore');

Route::delete(

    'client-documents/empty-trash',

    [ClientDocumentController::class, 'emptyTrash']

)->name('client-documents.empty-trash');

Route::post(

    'client-documents/{id}/restore',

    [ClientDocumentController::class, 'restore']

)->name('client-documents.restore');

Route::delete(

    'client-documents/{id}/force-delete',

    [ClientDocumentController::class, 'forceDelete']

)->name('client-documents.force-delete');

Route::get(

    'client-documents/{clientDocument}/download',

    [ClientDocumentController::class, 'download']

)->name('client-documents.download');

Route::get(

    'client-documents/{clientDocument}/preview',

    [ClientDocumentController::class, 'preview']

)->name('client-documents.preview');

Route::post(

    'client-documents/{clientDocument}/replace',

    [ClientDocumentController::class, 'replace']

)->name('client-documents.replace');

Route::get(

    'client-documents/{clientDocument}/view-pdf',

    [ClientDocumentController::class, 'viewPdf']

)->name('client-documents.view-pdf');

Route::post(

    'client-documents/multiple-upload',

    [ClientDocumentController::class, 'multipleUpload']

)->name('client-documents.multiple-upload');

Route::get(

    'clients/{client}/documents/download-zip',

    [ClientDocumentController::class, 'downloadZip']

)->name('client-documents.download-zip');
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

    Route::get(
    'client-credentials/trashed',
    [ClientCredentialController::class, 'trashed']
)->name('client-credentials.trashed');

Route::post(
    'client-credentials/{id}/restore',
    [ClientCredentialController::class, 'restore']
)->name('client-credentials.restore');

Route::delete(
    'client-credentials/{id}/force-delete',
    [ClientCredentialController::class, 'forceDelete']
)->name('client-credentials.force-delete');

Route::delete(
    'client-credentials/trash/empty',
    [ClientCredentialController::class, 'emptyTrash']
)->name('client-credentials.empty-trash');

Route::post(
    'client-credentials/bulk-restore',
    [ClientCredentialController::class, 'bulkRestore']
)->name('client-credentials.bulk-restore');


Route::delete(
    'client-credentials/bulk-delete',
    [ClientCredentialController::class, 'bulkDelete']
)->name('client-credentials.bulk-delete');


Route::middleware(['auth'])
    ->prefix('chat')
    ->name('chat.')
    ->group(function () {

        // inbox
        Route::get('/', [ChatController::class, 'index'])->name('index');

        // create/start conversation (FIXED MISSING ROUTE)
        Route::get('/start', [ChatController::class, 'start'])->name('start');

        // open chat
        Route::get('/{conversation}', [ChatController::class, 'show'])->name('show');

        // send message
        Route::post('/{conversation}/send', [ChatController::class, 'send'])->name('send');

        // inbox live data (AJAX refresh)
        Route::get('/inbox/data', [ChatController::class, 'inboxData'])->name('inbox.data');

        // messages API (polling)
        Route::get('/{conversation}/messages', [ChatController::class, 'messages'])->name('messages');
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