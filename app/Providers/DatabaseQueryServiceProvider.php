<?php

namespace App\Providers;

use Illuminate\Database\Events\QueryExecuted;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;

/**
 * Service provider for database query logging and performance monitoring.
 * Enable this in development to identify slow queries.
 */
class DatabaseQueryServiceProvider extends ServiceProvider
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
        // Only log queries in local/development environment
        if (!$this->app->environment('local', 'development')) {
            return;
        }

        // Skip if query logging is disabled via env
        if (!config('app.log_queries', false)) {
            return;
        }

        DB::listen(function (QueryExecuted $query) {
            // Log slow queries (> 100ms)
            if ($query->time > 100) {
                Log::channel('daily')->warning('Slow Query Detected', [
                    'sql' => $query->sql,
                    'bindings' => $query->bindings,
                    'time_ms' => $query->time,
                    'connection' => $query->connectionName,
                ]);
            }

            // Log very slow queries (> 500ms) as error
            if ($query->time > 500) {
                Log::channel('daily')->error('Very Slow Query!', [
                    'sql' => $query->sql,
                    'bindings' => $query->bindings,
                    'time_ms' => $query->time,
                    'connection' => $query->connectionName,
                ]);
            }
        });
    }
}
