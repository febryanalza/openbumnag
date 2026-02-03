<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

/**
 * Seeder untuk mengisi pengaturan homepage default.
 * 
 * Best Practice:
 * - Semua setting memiliki nilai default
 * - Pengelompokan berdasarkan section
 * - Tipe data yang tepat untuk setiap setting
 */
class HomepageSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            // General Settings
            [
                'key' => 'site_name',
                'value' => 'Lubas Mandiri',
                'type' => 'text',
                'group' => 'homepage',
                'description' => 'Nama Website',
                'order' => 1,
            ],
            [
                'key' => 'site_tagline',
                'value' => 'Badan Usaha Milik Nagari',
                'type' => 'text',
                'group' => 'homepage',
                'description' => 'Tagline',
                'order' => 2,
            ],
            [
                'key' => 'site_description',
                'value' => 'BUMNag Lubas Mandiri - Badan Usaha Milik Nagari yang berkomitmen untuk kesejahteraan masyarakat',
                'type' => 'textarea',
                'group' => 'homepage',
                'description' => 'Deskripsi Website',
                'order' => 3,
            ],
            [
                'key' => 'site_keywords',
                'value' => 'bumnag, lubas mandiri, nagari, badan usaha milik nagari',
                'type' => 'text',
                'group' => 'homepage',
                'description' => 'Keywords (SEO)',
                'order' => 4,
            ],
            [
                'key' => 'footer_copyright',
                'value' => '© 2026 Lubas Mandiri. All rights reserved.',
                'type' => 'text',
                'group' => 'homepage',
                'description' => 'Teks Copyright',
                'order' => 5,
            ],
            
            // Hero Section
            [
                'key' => 'hero_title',
                'value' => 'Selamat Datang di',
                'type' => 'text',
                'group' => 'homepage',
                'description' => 'Judul Hero',
                'order' => 10,
            ],
            [
                'key' => 'hero_subtitle',
                'value' => 'Lubas Mandiri',
                'type' => 'text',
                'group' => 'homepage',
                'description' => 'Sub Judul Hero',
                'order' => 11,
            ],
            [
                'key' => 'hero_description',
                'value' => 'Badan Usaha Milik Nagari yang berkomitmen untuk kesejahteraan masyarakat',
                'type' => 'textarea',
                'group' => 'homepage',
                'description' => 'Deskripsi Hero',
                'order' => 12,
            ],
            [
                'key' => 'hero_cta_primary_text',
                'value' => 'Jelajahi Produk',
                'type' => 'text',
                'group' => 'homepage',
                'description' => 'Teks Tombol Utama',
                'order' => 13,
            ],
            [
                'key' => 'hero_cta_primary_link',
                'value' => '/katalog',
                'type' => 'text',
                'group' => 'homepage',
                'description' => 'Link Tombol Utama',
                'order' => 14,
            ],
            [
                'key' => 'hero_cta_secondary_text',
                'value' => 'Tentang Kami',
                'type' => 'text',
                'group' => 'homepage',
                'description' => 'Teks Tombol Sekunder',
                'order' => 15,
            ],
            [
                'key' => 'hero_cta_secondary_link',
                'value' => '/tentang',
                'type' => 'text',
                'group' => 'homepage',
                'description' => 'Link Tombol Sekunder',
                'order' => 16,
            ],
            [
                'key' => 'hero_autoplay_duration',
                'value' => '5000',
                'type' => 'number',
                'group' => 'homepage',
                'description' => 'Durasi Slide (ms)',
                'order' => 17,
            ],
            [
                'key' => 'hero_max_slides',
                'value' => '5',
                'type' => 'number',
                'group' => 'homepage',
                'description' => 'Maksimal Gambar Slider',
                'order' => 18,
            ],
            [
                'key' => 'hero_images',
                'value' => '[]',
                'type' => 'json',
                'group' => 'homepage',
                'description' => 'Hero slider images',
                'order' => 19,
            ],
            
            // About Section (Unit Usaha)
            [
                'key' => 'about_title',
                'value' => 'Unit Usaha Kami',
                'type' => 'text',
                'group' => 'homepage',
                'description' => 'Judul Section Unit Usaha',
                'order' => 20,
            ],
            [
                'key' => 'about_description',
                'value' => 'Berbagai unit usaha yang kami kelola untuk kesejahteraan masyarakat',
                'type' => 'textarea',
                'group' => 'homepage',
                'description' => 'Deskripsi Section Unit Usaha',
                'order' => 21,
            ],
            [
                'key' => 'about_cta_text',
                'value' => 'Lihat Semua Unit Usaha',
                'type' => 'text',
                'group' => 'homepage',
                'description' => 'Teks Tombol Unit Usaha',
                'order' => 22,
            ],
            
            // News Section
            [
                'key' => 'news_title',
                'value' => 'Berita Terbaru',
                'type' => 'text',
                'group' => 'homepage',
                'description' => 'Judul Section Berita',
                'order' => 30,
            ],
            [
                'key' => 'news_description',
                'value' => 'Informasi dan update terkini dari kegiatan kami',
                'type' => 'textarea',
                'group' => 'homepage',
                'description' => 'Deskripsi Section Berita',
                'order' => 31,
            ],
            [
                'key' => 'news_homepage_limit',
                'value' => '6',
                'type' => 'number',
                'group' => 'homepage',
                'description' => 'Jumlah Berita Ditampilkan',
                'order' => 32,
            ],
            [
                'key' => 'news_cta_text',
                'value' => 'Lihat Semua Berita',
                'type' => 'text',
                'group' => 'homepage',
                'description' => 'Teks Tombol Berita',
                'order' => 33,
            ],
            
            // Reports Section
            [
                'key' => 'reports_title',
                'value' => 'Laporan & Transparansi',
                'type' => 'text',
                'group' => 'homepage',
                'description' => 'Judul Section Laporan',
                'order' => 40,
            ],
            [
                'key' => 'reports_description',
                'value' => 'Laporan keuangan dan kegiatan untuk transparansi publik',
                'type' => 'textarea',
                'group' => 'homepage',
                'description' => 'Deskripsi Section Laporan',
                'order' => 41,
            ],
            [
                'key' => 'reports_homepage_limit',
                'value' => '6',
                'type' => 'number',
                'group' => 'homepage',
                'description' => 'Jumlah Laporan Ditampilkan',
                'order' => 42,
            ],
            [
                'key' => 'reports_cta_text',
                'value' => 'Lihat Semua Laporan',
                'type' => 'text',
                'group' => 'homepage',
                'description' => 'Teks Tombol Laporan',
                'order' => 43,
            ],
            
            // Catalog Section
            [
                'key' => 'catalog_title',
                'value' => 'Kodai Kami',
                'type' => 'text',
                'group' => 'homepage',
                'description' => 'Judul Section Katalog',
                'order' => 50,
            ],
            [
                'key' => 'catalog_description',
                'value' => 'Produk-produk berkualitas dari unit usaha kami',
                'type' => 'textarea',
                'group' => 'homepage',
                'description' => 'Deskripsi Section Katalog',
                'order' => 51,
            ],
            [
                'key' => 'catalog_homepage_limit',
                'value' => '6',
                'type' => 'number',
                'group' => 'homepage',
                'description' => 'Jumlah Produk Ditampilkan',
                'order' => 52,
            ],
            [
                'key' => 'catalog_cta_text',
                'value' => 'Lihat Semua Produk',
                'type' => 'text',
                'group' => 'homepage',
                'description' => 'Teks Tombol Katalog',
                'order' => 53,
            ],
            
            // CTA Section
            [
                'key' => 'cta_title',
                'value' => 'Mari Berkembang Bersama',
                'type' => 'text',
                'group' => 'homepage',
                'description' => 'Judul CTA',
                'order' => 60,
            ],
            [
                'key' => 'cta_description',
                'value' => 'Bergabunglah dengan kami dalam membangun ekonomi nagari',
                'type' => 'textarea',
                'group' => 'homepage',
                'description' => 'Deskripsi CTA',
                'order' => 61,
            ],
            [
                'key' => 'cta_primary_text',
                'value' => 'Hubungi Kami',
                'type' => 'text',
                'group' => 'homepage',
                'description' => 'Teks Tombol Utama CTA',
                'order' => 62,
            ],
            [
                'key' => 'cta_primary_link',
                'value' => '#kontak',
                'type' => 'text',
                'group' => 'homepage',
                'description' => 'Link Tombol Utama CTA',
                'order' => 63,
            ],
            [
                'key' => 'cta_secondary_text',
                'value' => 'Pelajari Lebih Lanjut',
                'type' => 'text',
                'group' => 'homepage',
                'description' => 'Teks Tombol Sekunder CTA',
                'order' => 64,
            ],
            [
                'key' => 'cta_secondary_link',
                'value' => '/tentang',
                'type' => 'text',
                'group' => 'homepage',
                'description' => 'Link Tombol Sekunder CTA',
                'order' => 65,
            ],
        ];

        foreach ($settings as $setting) {
            Setting::updateOrCreate(
                ['key' => $setting['key']],
                $setting
            );
        }

        $this->command->info('Homepage settings seeded successfully!');
    }
}
