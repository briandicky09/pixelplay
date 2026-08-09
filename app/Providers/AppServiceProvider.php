<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // The API is public and read-only; the limiter keeps a single client
        // from hammering the catalog endpoints.
        RateLimiter::for('api', fn (Request $request) => Limit::perMinute(60)->by($request->ip()));

        // Missing eager loads surface as an exception while developing instead
        // of silently turning an index page into dozens of queries.
        Model::preventLazyLoading($this->app->isLocal());
    }
}
