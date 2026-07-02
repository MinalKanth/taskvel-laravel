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
use App\Observers\ClientDocumentObserver;
use App\Observers\ClientCredentialObserver;
use App\Observers\ClientRemarkObserver;
use App\Observers\ClientCommunicationObserver;

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


use App\Events\ClientCreated;
use App\Events\ClientUpdated;
use App\Events\ClientDeleted;
use App\Events\DocumentUploaded;
use App\Events\CredentialUpdated;
use App\Events\RemarkCreated;
use App\Events\CommunicationSent;

use App\Listeners\CreateTimeline;
use App\Listeners\CreateActivityLog;
use App\Listeners\SendEmailNotification;
use App\Listeners\SendPushNotification;
use App\Listeners\SendWhatsappNotification;

use App\Observers\ClientObserver;

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

        Client::observe(ClientObserver::class);


        ClientDocument::observe(ClientDocumentObserver::class);
        ClientCredential::observe(ClientCredentialObserver::class);
        ClientRemark::observe(ClientRemarkObserver::class);
        ClientCommunication::observe(ClientCommunicationObserver::class);
        
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
        | CRM Events & Listeners
        |--------------------------------------------------------------------------
        */

        Event::listen(ClientCreated::class, CreateTimeline::class);
        Event::listen(ClientUpdated::class, CreateTimeline::class);
        Event::listen(ClientDeleted::class, CreateTimeline::class);
        Event::listen(DocumentUploaded::class, CreateTimeline::class);
        Event::listen(CredentialUpdated::class, CreateTimeline::class);
        Event::listen(RemarkCreated::class, CreateTimeline::class);
        Event::listen(CommunicationSent::class, CreateTimeline::class);

        Event::listen(ClientCreated::class, CreateActivityLog::class);
        Event::listen(ClientUpdated::class, CreateActivityLog::class);
        Event::listen(ClientDeleted::class, CreateActivityLog::class);
        Event::listen(DocumentUploaded::class, CreateActivityLog::class);
        Event::listen(CredentialUpdated::class, CreateActivityLog::class);
        Event::listen(RemarkCreated::class, CreateActivityLog::class);
        Event::listen(CommunicationSent::class, CreateActivityLog::class);

        Event::listen(ClientCreated::class, SendEmailNotification::class);
        Event::listen(ClientUpdated::class, SendEmailNotification::class);
        Event::listen(DocumentUploaded::class, SendEmailNotification::class);
        Event::listen(CredentialUpdated::class, SendEmailNotification::class);
        Event::listen(RemarkCreated::class, SendEmailNotification::class);
        Event::listen(CommunicationSent::class, SendEmailNotification::class);

        Event::listen(ClientCreated::class, SendPushNotification::class);
        Event::listen(ClientUpdated::class, SendPushNotification::class);
        Event::listen(ClientDeleted::class, SendPushNotification::class);
        Event::listen(DocumentUploaded::class, SendPushNotification::class);
        Event::listen(CredentialUpdated::class, SendPushNotification::class);
        Event::listen(RemarkCreated::class, SendPushNotification::class);
        Event::listen(CommunicationSent::class, SendPushNotification::class);

        Event::listen(ClientCreated::class, SendWhatsappNotification::class);
        Event::listen(ClientUpdated::class, SendWhatsappNotification::class);
        Event::listen(ClientDeleted::class, SendWhatsappNotification::class);
        Event::listen(DocumentUploaded::class, SendWhatsappNotification::class);
        Event::listen(CredentialUpdated::class, SendWhatsappNotification::class);
        Event::listen(RemarkCreated::class, SendWhatsappNotification::class);
        Event::listen(CommunicationSent::class, SendWhatsappNotification::class);

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