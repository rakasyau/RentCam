<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        // Paksa skema HTTPS jika aplikasi berjalan di production atau environment ngrok
        if($this->app->environment('production')) {
            URL::forceScheme('https');
        }
    }

    
}
