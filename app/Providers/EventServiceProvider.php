<?php

namespace App\Providers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;
use App\Events\CreatedNews;
use App\Events\UpdatedNews;
use App\Listeners\LogNewsCreated;
use App\Listeners\LogUpdateNews;
use App\Events\DeletedNews;
use App\Listeners\LogDeletedNews;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */

    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        CreatedNews::class => [
            LogNewsCreated::class,
        ],
        UpdatedNews::class => [
            LogUpdateNews::class,
        ],
        DeletedNews::class => [
            LogDeletedNews::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
