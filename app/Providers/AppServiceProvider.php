<?php

namespace App\Providers;

use Carbon\Carbon;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Carbon::macro('isDayOff', function ($date) {
        //     return $date->isFriday() || $date->isSaturday();
        // });
        // Carbon::macro('isNotDayOff', function ($date) {
        //     return !$date->isDayOff();
        // });
    }
}
