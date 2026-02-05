<?php

namespace App\Providers;

use App\Helpers\SettingHelper;
use App\Models\BumnagProfile;
use App\Models\Catalog;
use App\Models\Gallery;
use App\Models\News;
use App\Models\Promotion;
use App\Models\Report;
use App\Models\Setting;
use App\Observers\CacheObserver;
use App\Observers\SettingObserver;
use App\Services\CacheService;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

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
    public function boot(): void
    {
        // Register Setting Observer
        Setting::observe(SettingObserver::class);
        
        // Register Cache Observer for homepage-related models
        // This automatically clears cache when these models are created/updated/deleted
        News::observe(CacheObserver::class);
        Report::observe(CacheObserver::class);
        Promotion::observe(CacheObserver::class);
        Gallery::observe(CacheObserver::class);
        Catalog::observe(CacheObserver::class);
        BumnagProfile::observe(CacheObserver::class);
        
        // Share settings to all views (use CacheService for better performance)
        View::composer('*', function ($view) {
            $settings = CacheService::getAllSettings();
            
            $view->with('globalSettings', [
                'site_name' => $settings['site_name'] ?? 'Lubas Mandiri',
                'site_tagline' => $settings['site_tagline'] ?? 'BUMNag Nagari Lubuk Basung',
                'site_description' => $settings['site_description'] ?? 'BUMNag Lubas Mandiri',
                'site_logo' => $settings['site_logo'] ?? null,
                'site_logo_white' => $settings['site_logo_white'] ?? null,
                'site_favicon' => $settings['site_favicon'] ?? null,
                'contact_address' => $settings['contact_address'] ?? 'Desa Lubas, Kecamatan Lubuk Alung',
                'contact_phone' => $settings['contact_phone'] ?? '+62 812-3456-7890',
                'contact_email' => $settings['contact_email'] ?? 'info@lubasmandiri.id',
                'contact_whatsapp' => $settings['contact_whatsapp'] ?? '6281234567890',
                'social_facebook' => $settings['social_facebook'] ?? '#',
                'social_instagram' => $settings['social_instagram'] ?? '#',
                'social_twitter' => $settings['social_twitter'] ?? '#',
                'social_youtube' => $settings['social_youtube'] ?? '#',
            ]);
        });
    }
}
