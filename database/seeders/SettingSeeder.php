<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            // General Settings
            [
                'key' => 'site_name',
                'value' => 'Lubas Mandiri',
                'type' => 'text',
                'group' => 'general',
                'description' => 'Nama website/BUMNag',
                'order' => 1,
            ],
            [
                'key' => 'site_tagline',
                'value' => 'Badan Usaha Milik Nagari',
                'type' => 'text',
                'group' => 'general',
                'description' => 'Tagline website',
                'order' => 2,
            ],
            [
                'key' => 'site_description',
                'value' => 'BUMNag Lubas Mandiri - Badan Usaha Milik Nagari yang berkomitmen untuk kesejahteraan masyarakat Desa Lubas',
                'type' => 'textarea',
                'group' => 'general',
                'description' => 'Deskripsi website untuk meta description',
                'order' => 3,
            ],
            
            // Hero Section
            [
                'key' => 'hero_images',
                'value' => json_encode([]),
                'type' => 'json',
                'group' => 'hero',
                'description' => 'Array gambar untuk hero slider',
                'order' => 0,
            ],
            [
                'key' => 'hero_title',
                'value' => 'Selamat Datang di',
                'type' => 'text',
                'group' => 'hero',
                'description' => 'Judul utama hero section',
                'order' => 1,
            ],
            [
                'key' => 'hero_subtitle',
                'value' => 'Lubas Mandiri',
                'type' => 'text',
                'group' => 'hero',
                'description' => 'Sub-judul hero section (highlight)',
                'order' => 2,
            ],
            [
                'key' => 'hero_description',
                'value' => 'Badan Usaha Milik Nagari yang berkomitmen untuk meningkatkan kesejahteraan masyarakat Desa Lubas melalui berbagai unit usaha yang berkelanjutan',
                'type' => 'textarea',
                'group' => 'hero',
                'description' => 'Deskripsi hero section',
                'order' => 3,
            ],
            [
                'key' => 'hero_max_slides',
                'value' => '5',
                'type' => 'number',
                'group' => 'hero',
                'description' => 'Maksimal jumlah gambar slider hero',
                'order' => 4,
            ],
            [
                'key' => 'hero_autoplay_duration',
                'value' => '5000',
                'type' => 'number',
                'group' => 'hero',
                'description' => 'Durasi autoplay slider (millisecond)',
                'order' => 5,
            ],
            
            // About Section
            [
                'key' => 'about_title',
                'value' => 'Unit Usaha Kami',
                'type' => 'text',
                'group' => 'about',
                'description' => 'Judul section unit usaha',
                'order' => 1,
            ],
            [
                'key' => 'about_description',
                'value' => 'Berbagai unit usaha yang kami kelola untuk meningkatkan perekonomian masyarakat',
                'type' => 'textarea',
                'group' => 'about',
                'description' => 'Deskripsi section unit usaha',
                'order' => 2,
            ],
            
            // News Section
            [
                'key' => 'news_title',
                'value' => 'Berita Terbaru',
                'type' => 'text',
                'group' => 'news',
                'description' => 'Judul section berita',
                'order' => 1,
            ],
            [
                'key' => 'news_description',
                'value' => 'Informasi dan update terkini dari Lubas Mandiri',
                'type' => 'textarea',
                'group' => 'news',
                'description' => 'Deskripsi section berita',
                'order' => 2,
            ],
            [
                'key' => 'news_homepage_limit',
                'value' => '6',
                'type' => 'number',
                'group' => 'news',
                'description' => 'Jumlah berita yang ditampilkan di homepage',
                'order' => 3,
            ],
            
            // Reports Section
            [
                'key' => 'reports_title',
                'value' => 'Laporan & Transparansi',
                'type' => 'text',
                'group' => 'reports',
                'description' => 'Judul section laporan',
                'order' => 1,
            ],
            [
                'key' => 'reports_description',
                'value' => 'Laporan keuangan dan kegiatan untuk transparansi dan akuntabilitas',
                'type' => 'textarea',
                'group' => 'reports',
                'description' => 'Deskripsi section laporan',
                'order' => 2,
            ],
            [
                'key' => 'reports_homepage_limit',
                'value' => '6',
                'type' => 'number',
                'group' => 'reports',
                'description' => 'Jumlah laporan yang ditampilkan di homepage',
                'order' => 3,
            ],
            
            // CTA Section
            [
                'key' => 'cta_title',
                'value' => 'Mari Berkembang Bersama',
                'type' => 'text',
                'group' => 'general',
                'description' => 'Judul section CTA',
                'order' => 10,
            ],
            [
                'key' => 'cta_description',
                'value' => 'Bergabunglah dengan kami dalam membangun ekonomi nagari yang lebih kuat dan berkelanjutan',
                'type' => 'textarea',
                'group' => 'general',
                'description' => 'Deskripsi section CTA',
                'order' => 11,
            ],
            
            // Contact Information
            [
                'key' => 'contact_address',
                'value' => 'Desa Lubas, Kecamatan Lubuk Alung, Kabupaten Padang Pariaman',
                'type' => 'textarea',
                'group' => 'contact',
                'description' => 'Alamat lengkap',
                'order' => 1,
            ],
            [
                'key' => 'contact_phone',
                'value' => '0751-1234567',
                'type' => 'text',
                'group' => 'contact',
                'description' => 'Nomor telepon',
                'order' => 2,
            ],
            [
                'key' => 'contact_email',
                'value' => 'info@lubasmandiri.id',
                'type' => 'text',
                'group' => 'contact',
                'description' => 'Email',
                'order' => 3,
            ],
            [
                'key' => 'contact_whatsapp',
                'value' => '6281234567890',
                'type' => 'text',
                'group' => 'contact',
                'description' => 'Nomor WhatsApp (dengan kode negara)',
                'order' => 4,
            ],
            
            // Social Media
            [
                'key' => 'social_facebook',
                'value' => 'https://facebook.com/lubasmandiri',
                'type' => 'text',
                'group' => 'social',
                'description' => 'URL Facebook',
                'order' => 1,
            ],
            [
                'key' => 'social_instagram',
                'value' => 'https://instagram.com/lubasmandiri',
                'type' => 'text',
                'group' => 'social',
                'description' => 'URL Instagram',
                'order' => 2,
            ],
            [
                'key' => 'social_twitter',
                'value' => 'https://twitter.com/lubasmandiri',
                'type' => 'text',
                'group' => 'social',
                'description' => 'URL Twitter/X',
                'order' => 3,
            ],
            [
                'key' => 'social_youtube',
                'value' => 'https://youtube.com/@lubasmandiri',
                'type' => 'text',
                'group' => 'social',
                'description' => 'URL YouTube',
                'order' => 4,
            ],
            
            // Catalog/Kodai Section
            [
                'key' => 'catalog_title',
                'value' => 'Kodai Kami',
                'type' => 'text',
                'group' => 'catalog',
                'description' => 'Judul section katalog produk di homepage',
                'order' => 1,
            ],
            [
                'key' => 'catalog_description',
                'value' => 'Produk-produk berkualitas dari unit usaha kami',
                'type' => 'textarea',
                'group' => 'catalog',
                'description' => 'Deskripsi section katalog produk',
                'order' => 2,
            ],
            [
                'key' => 'catalog_homepage_limit',
                'value' => '6',
                'type' => 'number',
                'group' => 'catalog',
                'description' => 'Jumlah katalog yang ditampilkan di homepage',
                'order' => 3,
            ],
        ];

        foreach ($settings as $setting) {
            Setting::updateOrCreate(
                ['key' => $setting['key']],
                $setting
            );
        }
    }
}
