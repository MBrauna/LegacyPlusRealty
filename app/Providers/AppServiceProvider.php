<?php

    namespace App\Providers;

    use Illuminate\Support\ServiceProvider;
    use Carbon\Carbon;

    class AppServiceProvider extends ServiceProvider
    {
        public function register() {
            //
        }

        public function boot() {
            date_default_timezone_set('America/Mexico_City');
            Carbon::setLocale('us_FL');
        }
    }
