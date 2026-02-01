<?php

namespace App\Helpers;

use App\Models\Setting;
use App\Services\CacheService;
use Illuminate\Support\Facades\Cache;

class SettingHelper
{
    /**
     * Get setting value by key with caching
     * Uses CacheService for better performance by loading all settings at once
     */
    public static function get(string $key, mixed $default = null): mixed
    {
        return CacheService::getSetting($key, $default);
    }

    /**
     * Get all settings in a group
     */
    public static function group(string $group): array
    {
        return Cache::remember("settings_group_{$group}", 3600, function () use ($group) {
            return Setting::inGroup($group)
                ->orderBy('order')
                ->pluck('value', 'key')
                ->toArray();
        });
    }

    /**
     * Set setting value and clear cache
     */
    public static function set(string $key, mixed $value, string $type = 'text'): bool
    {
        Cache::forget("setting_{$key}");
        CacheService::clearSettingsCache();
        Setting::set($key, $value, $type);
        return true;
    }

    /**
     * Clear all settings cache
     */
    public static function clearCache(): void
    {
        CacheService::clearSettingsCache();
        
        // Also clear group caches
        $groups = Setting::distinct('group')->pluck('group');
        foreach ($groups as $group) {
            Cache::forget("settings_group_{$group}");
        }
    }
}
