<?php

namespace App\Providers;

use App\Logging\BasicLogger;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
        app()->bind('BasicLogger', BasicLogger::class);
    }

    public function boot()
    {
        if (config('app.env') == 'production') {
            URL::forceScheme('https');
        }
    }
}
