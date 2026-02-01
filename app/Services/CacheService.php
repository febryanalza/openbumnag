<?php

namespace App\Services;

use App\Models\BumnagProfile;
use App\Models\Catalog;
use App\Models\Gallery;
use App\Models\News;
use App\Models\Promotion;
use App\Models\Report;
use App\Models\Setting;
use Illuminate\Support\Facades\Cache;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

/**
 * Centralized caching service for frequently accessed data.
 * Helps reduce database queries and improve performance.
 */
class CacheService
{
    /**
     * Cache TTL in seconds (1 hour default)
     */
    public const CACHE_TTL = 3600;
    
    /**
     * Short cache TTL for frequently changing data (5 minutes)
     */
    public const SHORT_CACHE_TTL = 300;

    /**
     * Get all settings at once (cached)
     */
    public static function getAllSettings(): array
    {
        return Cache::remember('all_settings', self::CACHE_TTL, function () {
            $settings = Setting::all();
            $result = [];
            
            foreach ($settings as $setting) {
                $result[$setting->key] = self::castSettingValue($setting->value, $setting->type);
            }
            
            return $result;
        });
    }

    /**
     * Get a specific setting from cache
     */
    public static function getSetting(string $key, mixed $default = null): mixed
    {
        $settings = self::getAllSettings();
        return $settings[$key] ?? $default;
    }

    /**
     * Cast setting value based on type
     */
    protected static function castSettingValue(mixed $value, ?string $type): mixed
    {
        return match ($type) {
            'boolean' => filter_var($value, FILTER_VALIDATE_BOOLEAN),
            'number' => is_numeric($value) ? (float) $value : 0,
            'json' => is_string($value) ? json_decode($value, true) : $value,
            default => $value,
        };
    }

    /**
     * Get all permissions grouped (cached)
     */
    public static function getGroupedPermissions(): \Illuminate\Support\Collection
    {
        return Cache::remember('grouped_permissions', self::CACHE_TTL, function () {
            return Permission::all()->groupBy(function ($permission) {
                $parts = explode('.', $permission->name);
                return $parts[0] ?? 'other';
            });
        });
    }

    /**
     * Get all permissions (cached)
     */
    public static function getAllPermissions(): \Illuminate\Database\Eloquent\Collection
    {
        return Cache::remember('all_permissions', self::CACHE_TTL, function () {
            return Permission::all();
        });
    }

    /**
     * Get all roles with counts (cached)
     */
    public static function getAllRoles(): \Illuminate\Database\Eloquent\Collection
    {
        return Cache::remember('all_roles', self::SHORT_CACHE_TTL, function () {
            return Role::withCount(['permissions', 'users'])->get();
        });
    }

    /**
     * Get permission stats (cached)
     */
    public static function getPermissionStats(): array
    {
        return Cache::remember('permission_stats', self::SHORT_CACHE_TTL, function () {
            return [
                'total' => Permission::count(),
                'groups' => self::getGroupedPermissions()->count(),
                'roles_count' => Role::count(),
            ];
        });
    }

    /**
     * Get homepage data (cached)
     */
    public static function getHomepageData(): array
    {
        return Cache::remember('homepage_data', self::SHORT_CACHE_TTL, function () {
            $settings = self::getAllSettings();
            
            $heroMaxSlides = (int) ($settings['hero_max_slides'] ?? 5);
            $newsLimit = (int) ($settings['news_homepage_limit'] ?? 6);
            $reportsLimit = (int) ($settings['reports_homepage_limit'] ?? 6);
            
            // Process hero images
            $heroImagesData = $settings['hero_images'] ?? '[]';
            $heroImagesPaths = is_string($heroImagesData) 
                ? (json_decode($heroImagesData, true) ?? []) 
                : (is_array($heroImagesData) ? $heroImagesData : []);
            $heroImagesPaths = array_slice($heroImagesPaths, 0, $heroMaxSlides);
            
            // Get hero images
            if (empty($heroImagesPaths)) {
                $heroImages = Gallery::where('is_featured', true)
                    ->where('file_type', 'image')
                    ->orderBy('order', 'asc')
                    ->take($heroMaxSlides)
                    ->get(['id', 'title', 'file_path']);
            } else {
                $heroImages = collect($heroImagesPaths)->map(function($path, $index) {
                    return (object)[
                        'id' => $index,
                        'title' => 'Hero Slide ' . ($index + 1),
                        'file_path' => $path
                    ];
                });
            }
            
            return [
                'heroImages' => $heroImages,
                'heroAutoplayDuration' => (int) ($settings['hero_autoplay_duration'] ?? 5000),
                
                'bumnagProfiles' => BumnagProfile::where('is_active', true)
                    ->orderBy('name', 'asc')
                    ->get(['id', 'name', 'slug', 'tagline', 'about', 'logo', 'banner']),
                
                'latestNews' => News::where('status', 'published')
                    ->with(['category:id,name'])
                    ->orderBy('published_at', 'desc')
                    ->take($newsLimit)
                    ->get(['id', 'title', 'slug', 'excerpt', 'featured_image', 'published_at', 'category_id', 'views']),
                
                'latestReports' => Report::where('status', 'published')
                    ->orderBy('published_at', 'desc')
                    ->take($reportsLimit)
                    ->get(['id', 'title', 'slug', 'description', 'file_path', 'published_at', 'type', 'year']),
                
                'promotions' => Promotion::where('status', 'active')
                    ->where('start_date', '<=', now())
                    ->where(function ($query) {
                        $query->whereNull('end_date')
                            ->orWhere('end_date', '>=', now());
                    })
                    ->orderBy('created_at', 'desc')
                    ->take(3)
                    ->get(['id', 'title', 'slug', 'excerpt', 'featured_image', 'discount_percentage']),
                
                'featuredCatalogs' => Catalog::with('bumnagProfile:id,name,slug')
                    ->where('is_available', true)
                    ->where('is_featured', true)
                    ->orderBy('created_at', 'desc')
                    ->get(['id', 'name', 'slug', 'description', 'price', 'unit', 'featured_image', 'bumnag_profile_id', 'category', 'stock', 'is_featured']),
            ];
        });
    }

    /**
     * Get homepage settings formatted
     */
    public static function getHomepageSettings(): array
    {
        $settings = self::getAllSettings();
        
        return [
            // General
            'site_name' => $settings['site_name'] ?? 'Lubas Mandiri',
            'site_tagline' => $settings['site_tagline'] ?? 'Badan Usaha Milik Nagari',
            'site_description' => $settings['site_description'] ?? 'BUMNag Lubas Mandiri',
            
            // Hero Section
            'hero_title' => $settings['hero_title'] ?? 'Selamat Datang di',
            'hero_subtitle' => $settings['hero_subtitle'] ?? 'Lubas Mandiri',
            'hero_description' => $settings['hero_description'] ?? 'Badan Usaha Milik Nagari yang berkomitmen untuk kesejahteraan masyarakat',
            'hero_autoplay_duration' => (int) ($settings['hero_autoplay_duration'] ?? 5000),
            
            // About Section
            'about_title' => $settings['about_title'] ?? 'Unit Usaha Kami',
            'about_description' => $settings['about_description'] ?? 'Berbagai unit usaha yang kami kelola',
            
            // News Section
            'news_title' => $settings['news_title'] ?? 'Berita Terbaru',
            'news_description' => $settings['news_description'] ?? 'Informasi dan update terkini',
            
            // Reports Section
            'reports_title' => $settings['reports_title'] ?? 'Laporan & Transparansi',
            'reports_description' => $settings['reports_description'] ?? 'Laporan keuangan dan kegiatan',
            
            // Catalog Section
            'catalog_title' => $settings['catalog_title'] ?? 'Kodai Kami',
            'catalog_description' => $settings['catalog_description'] ?? 'Produk-produk berkualitas dari unit usaha kami',
            
            // CTA Section
            'cta_title' => $settings['cta_title'] ?? 'Mari Berkembang Bersama',
            'cta_description' => $settings['cta_description'] ?? 'Bergabunglah dengan kami dalam membangun ekonomi nagari',
        ];
    }

    /**
     * Clear all cache
     */
    public static function clearAll(): void
    {
        Cache::forget('all_settings');
        Cache::forget('grouped_permissions');
        Cache::forget('all_permissions');
        Cache::forget('all_roles');
        Cache::forget('permission_stats');
        Cache::forget('homepage_data');
    }

    /**
     * Clear settings cache
     */
    public static function clearSettingsCache(): void
    {
        Cache::forget('all_settings');
        Cache::forget('homepage_data');
    }

    /**
     * Clear permissions cache
     */
    public static function clearPermissionsCache(): void
    {
        Cache::forget('grouped_permissions');
        Cache::forget('all_permissions');
        Cache::forget('permission_stats');
    }

    /**
     * Clear roles cache
     */
    public static function clearRolesCache(): void
    {
        Cache::forget('all_roles');
        Cache::forget('permission_stats');
    }

    /**
     * Clear homepage cache
     */
    public static function clearHomepageCache(): void
    {
        Cache::forget('homepage_data');
    }
}
