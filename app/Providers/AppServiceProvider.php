<?php

namespace App\Providers;

use App\Events\TaskCompleted;
use App\Listeners\UpdateTaskStatistics;

use App\Models\FocusSession;
use App\Models\Notification;
use App\Models\Remark;
use App\Models\Task;
use App\Policies\ClientPolicy;

use App\Policies\FocusSessionPolicy;
use App\Policies\RemarkPolicy;
use App\Policies\TaskPolicy;
use App\Models\Client;
use App\Models\ClientAddress;
use App\Models\ClientCommunication;
use App\Models\ClientContact;
use App\Models\ClientCredential;
use App\Models\ClientDocument;
use App\Models\ClientRemark;
use App\Models\ClientService;

use App\Policies\ClientAddressPolicy;
use App\Policies\ClientCommunicationPolicy;
use App\Policies\ClientContactPolicy;
use App\Policies\ClientCredentialPolicy;
use App\Policies\ClientDocumentPolicy;
use App\Policies\ClientRemarkPolicy;
use App\Policies\ClientServicePolicy;

use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        /*
        |--------------------------------------------------------------------------
        | Policies
        |--------------------------------------------------------------------------
        */

        Gate::policy(Task::class, TaskPolicy::class);
        Gate::policy(Remark::class, RemarkPolicy::class);
        Gate::policy(FocusSession::class, FocusSessionPolicy::class);
        
        /*
        |--------------------------------------------------------------------------
        | CRM Policies
        |--------------------------------------------------------------------------
        */

        Gate::policy(Client::class, ClientPolicy::class);

        Gate::policy(
            ClientContact::class,
            ClientContactPolicy::class
        );

        Gate::policy(
            ClientAddress::class,
            ClientAddressPolicy::class
        );

        Gate::policy(
            ClientService::class,
            ClientServicePolicy::class
        );

        Gate::policy(
            ClientDocument::class,
            ClientDocumentPolicy::class
        );

        Gate::policy(
            ClientCredential::class,
            ClientCredentialPolicy::class
        );

        Gate::policy(
            ClientRemark::class,
            ClientRemarkPolicy::class
        );

        Gate::policy(
            ClientCommunication::class,
            ClientCommunicationPolicy::class
        );

        /*
        |--------------------------------------------------------------------------
        | Events
        |--------------------------------------------------------------------------
        */

        Event::listen(
            TaskCompleted::class,
            UpdateTaskStatistics::class
        );

        /*
        |--------------------------------------------------------------------------
        | Database
        |--------------------------------------------------------------------------
        */

        Schema::defaultStringLength(191);

        /*
        |--------------------------------------------------------------------------
        | Global View Data
        |--------------------------------------------------------------------------
        */

        View::composer('*', function ($view) {

            if (auth()->check()) {

                $view->with(
                    'unreadNotifications',
                    Notification::where('user_id', auth()->id())
                        ->whereNull('read_at')
                        ->count()
                );
            }

        });
    }
}