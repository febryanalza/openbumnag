<?php

namespace App\Helpers;

use App\Models\Setting;
use Illuminate\Support\Facades\Cache;

class SettingHelper
{
    /**
     * Get setting value by key with caching
     */
    public static function get(string $key, mixed $default = null): mixed
    {
        return Cache::remember("setting_{$key}", 3600, function () use ($key, $default) {
            return Setting::get($key, $default);
        });
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
        Setting::set($key, $value, $type);
        return true;
    }

    /**
     * Clear all settings cache
     */
    public static function clearCache(): void
    {
        // Get all settings keys and forget each cache individually
        $settings = Setting::all();
        foreach ($settings as $setting) {
            Cache::forget("setting_{$setting->key}");
        }
        
        // Also clear group caches
        $groups = Setting::distinct('group')->pluck('group');
        foreach ($groups as $group) {
            Cache::forget("settings_group_{$group}");
        }
    }
}
