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
        Gate::policy(Client::class, ClientPolicy::class);

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