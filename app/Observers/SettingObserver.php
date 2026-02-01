<?php

namespace App\Observers;

use App\Helpers\SettingHelper;
use App\Models\Setting;
use App\Services\CacheService;
use Illuminate\Support\Facades\Cache;

class SettingObserver
{
    /**
     * Handle the Setting "created" event.
     */
    public function created(Setting $setting): void
    {
        $this->clearCache($setting);
    }

    /**
     * Handle the Setting "updated" event.
     */
    public function updated(Setting $setting): void
    {
        $this->clearCache($setting);
    }

    /**
     * Handle the Setting "deleted" event.
     */
    public function deleted(Setting $setting): void
    {
        $this->clearCache($setting);
    }

    /**
     * Clear cache for the setting
     */
    protected function clearCache(Setting $setting): void
    {
        // Clear the centralized settings cache
        CacheService::clearSettingsCache();
        
        // Also clear group cache
        if ($setting->group) {
            Cache::forget("settings_group_{$setting->group}");
        }
    }
}
