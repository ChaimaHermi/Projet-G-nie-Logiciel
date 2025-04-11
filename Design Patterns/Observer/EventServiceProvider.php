<?php

namespace App\Providers;

use App\Events\UserLoginHistoryEvent;
use App\Listeners\UserLoginHistoryListener;
use App\Models\AssessmentWorkEvaluation;
use App\Models\User;
use App\Observers\AssessmentWorkEvaluationObserver;
use App\Observers\UserObserver;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        UserLoginHistoryEvent::class=>[
            UserLoginHistoryListener::class ,
        ]
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
       User::observe(UserObserver::class);
       AssessmentWorkEvaluation::observe(AssessmentWorkEvaluationObserver::class);
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
