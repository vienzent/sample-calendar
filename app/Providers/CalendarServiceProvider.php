<?php

namespace App\Providers;

use App\Contracts\Services\CalendarEventDateServiceInterface;
use App\Contracts\Services\CalendarEventServiceInterface;
use App\Services\CalendarEventDateService;
use App\Services\CalendarEventService;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;

class CalendarServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
         $this->app->bind(CalendarEventServiceInterface::class, CalendarEventService::class);
         $this->app->bind(CalendarEventDateServiceInterface::class, CalendarEventDateService::class);
    }

}
