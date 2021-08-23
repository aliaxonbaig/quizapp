<?php

namespace App\Providers;

use Carbon\Carbon;
use Illuminate\Support\ServiceProvider;
use ConsoleTVs\Charts\Registrar as Charts;

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
    public function boot(Charts $charts)
    {
        // Carbon::macro('isDayOff', function ($date) {
        //     return $date->isFriday() || $date->isSaturday();
        // });
        // Carbon::macro('isNotDayOff', function ($date) {
        //     return !$date->isDayOff();
        // });
        $charts->register([
            \App\Charts\UserQuiz::class,
        ]);
    }
}
