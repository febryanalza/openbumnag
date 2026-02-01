<?php

namespace App\Observers;

use App\Services\CacheService;
use Illuminate\Database\Eloquent\Model;

/**
 * Observer to automatically clear relevant caches when models are updated.
 * Attach this observer to models that appear on the homepage or frequently accessed pages.
 */
class CacheObserver
{
    /**
     * Handle the created event.
     */
    public function created(Model $model): void
    {
        $this->clearRelevantCache($model);
    }

    /**
     * Handle the updated event.
     */
    public function updated(Model $model): void
    {
        $this->clearRelevantCache($model);
    }

    /**
     * Handle the deleted event.
     */
    public function deleted(Model $model): void
    {
        $this->clearRelevantCache($model);
    }

    /**
     * Clear relevant cache based on model type.
     */
    protected function clearRelevantCache(Model $model): void
    {
        $className = class_basename($model);

        match ($className) {
            'News', 'Report', 'Promotion', 'Gallery', 'Catalog', 'BumnagProfile' 
                => CacheService::clearHomepageCache(),
            'Setting' 
                => CacheService::clearSettingsCache(),
            default 
                => null,
        };
    }
}
