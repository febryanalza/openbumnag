<?php

namespace App\Providers;

use App\Helpers\SettingHelper;
use App\Models\Setting;
use App\Observers\SettingObserver;
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
        
        // Share settings to all views
        View::composer('*', function ($view) {
            $view->with('globalSettings', [
                'site_name' => SettingHelper::get('site_name', 'Lubas Mandiri'),
                'site_tagline' => SettingHelper::get('site_tagline', 'BUMNag Nagari Lubuk Basung'),
                'site_description' => SettingHelper::get('site_description', 'BUMNag Lubas Mandiri'),
                'contact_address' => SettingHelper::get('contact_address', 'Desa Lubas, Kecamatan Lubuk Alung'),
                'contact_phone' => SettingHelper::get('contact_phone', '+62 812-3456-7890'),
                'contact_email' => SettingHelper::get('contact_email', 'info@lubasmandiri.id'),
                'contact_whatsapp' => SettingHelper::get('contact_whatsapp', '6281234567890'),
                'social_facebook' => SettingHelper::get('social_facebook', '#'),
                'social_instagram' => SettingHelper::get('social_instagram', '#'),
                'social_twitter' => SettingHelper::get('social_twitter', '#'),
                'social_youtube' => SettingHelper::get('social_youtube', '#'),
            ]);
        });
    }
}
