<?php

namespace App\Console\Commands;

use App\Services\CacheService;
use Illuminate\Console\Command;

class ClearAppCache extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:clear-cache {--type= : Specify cache type (settings, permissions, roles, homepage, all)}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear application-specific caches (settings, permissions, roles, homepage)';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $type = $this->option('type') ?? 'all';

        switch ($type) {
            case 'settings':
                CacheService::clearSettingsCache();
                $this->info('Settings cache cleared.');
                break;

            case 'permissions':
                CacheService::clearPermissionsCache();
                $this->info('Permissions cache cleared.');
                break;

            case 'roles':
                CacheService::clearRolesCache();
                $this->info('Roles cache cleared.');
                break;

            case 'homepage':
                CacheService::clearHomepageCache();
                $this->info('Homepage cache cleared.');
                break;

            case 'all':
            default:
                CacheService::clearAll();
                $this->info('All application caches cleared.');
                break;
        }

        return Command::SUCCESS;
    }
}
