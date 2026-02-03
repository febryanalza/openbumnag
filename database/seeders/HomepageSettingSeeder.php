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
            
            // About Page Settings
            [
                'key' => 'about_page_title',
                'value' => 'Tentang Kami',
                'type' => 'text',
                'group' => 'homepage',
                'description' => 'Judul Halaman Tentang',
                'order' => 70,
            ],
            [
                'key' => 'about_page_subtitle',
                'value' => 'Mengenal BUMNag Lubas Mandiri',
                'type' => 'text',
                'group' => 'homepage',
                'description' => 'Sub Judul Halaman Tentang',
                'order' => 71,
            ],
            [
                'key' => 'about_page_description',
                'value' => 'BUMNag Lubas Mandiri adalah Badan Usaha Milik Nagari yang berkomitmen untuk meningkatkan kesejahteraan masyarakat Desa Lubas melalui berbagai unit usaha yang berkelanjutan dan berdaya saing.',
                'type' => 'textarea',
                'group' => 'homepage',
                'description' => 'Deskripsi Utama Halaman Tentang',
                'order' => 72,
            ],
            [
                'key' => 'about_vision_title',
                'value' => 'Visi Kami',
                'type' => 'text',
                'group' => 'homepage',
                'description' => 'Judul Visi',
                'order' => 73,
            ],
            [
                'key' => 'about_vision_content',
                'value' => 'Menjadi BUMNag terdepan yang mandiri, profesional, dan berkelanjutan dalam mengembangkan ekonomi nagari untuk kesejahteraan masyarakat.',
                'type' => 'textarea',
                'group' => 'homepage',
                'description' => 'Isi Visi',
                'order' => 74,
            ],
            [
                'key' => 'about_mission_title',
                'value' => 'Misi Kami',
                'type' => 'text',
                'group' => 'homepage',
                'description' => 'Judul Misi',
                'order' => 75,
            ],
            [
                'key' => 'about_mission_content',
                'value' => "1. Mengembangkan unit usaha yang produktif dan menguntungkan\n2. Meningkatkan kualitas SDM melalui pelatihan dan pembinaan\n3. Menciptakan lapangan kerja bagi masyarakat nagari\n4. Mengelola aset nagari secara profesional dan transparan\n5. Membangun kemitraan strategis dengan berbagai pihak",
                'type' => 'textarea',
                'group' => 'homepage',
                'description' => 'Isi Misi',
                'order' => 76,
            ],
            [
                'key' => 'about_values_title',
                'value' => 'Nilai-Nilai Kami',
                'type' => 'text',
                'group' => 'homepage',
                'description' => 'Judul Nilai-Nilai',
                'order' => 77,
            ],
            [
                'key' => 'about_values_content',
                'value' => 'Integritas • Transparansi • Profesionalisme • Inovasi • Keberlanjutan • Kebersamaan',
                'type' => 'textarea',
                'group' => 'homepage',
                'description' => 'Isi Nilai-Nilai',
                'order' => 78,
            ],
            [
                'key' => 'about_team_title',
                'value' => 'Tim Pengembang Website',
                'type' => 'text',
                'group' => 'homepage',
                'description' => 'Judul Tim Pengembang',
                'order' => 79,
            ],
            [
                'key' => 'about_team_description',
                'value' => 'Website ini dikembangkan melalui kolaborasi antara KKN UNP, BUMNag Lubas Mandiri, Pemerintah Nagari Lubuk Basung, dan Pemerintah Kabupaten Agam dalam upaya digitalisasi dan transparansi pengelolaan BUMNag.',
                'type' => 'textarea',
                'group' => 'homepage',
                'description' => 'Deskripsi Tim Pengembang',
                'order' => 80,
            ],
            [
                'key' => 'about_team_logo_1',
                'value' => '',
                'type' => 'image',
                'group' => 'homepage',
                'description' => 'Logo KKN UNP',
                'order' => 81,
            ],
            [
                'key' => 'about_team_name_1',
                'value' => 'KKN UNP',
                'type' => 'text',
                'group' => 'homepage',
                'description' => 'Nama Tim 1',
                'order' => 82,
            ],
            [
                'key' => 'about_team_logo_2',
                'value' => '',
                'type' => 'image',
                'group' => 'homepage',
                'description' => 'Logo BUMNag Lubas',
                'order' => 83,
            ],
            [
                'key' => 'about_team_name_2',
                'value' => 'BUMNag Lubas Mandiri',
                'type' => 'text',
                'group' => 'homepage',
                'description' => 'Nama Tim 2',
                'order' => 84,
            ],
            [
                'key' => 'about_team_logo_3',
                'value' => '',
                'type' => 'image',
                'group' => 'homepage',
                'description' => 'Logo Nagari Lubuk Basung',
                'order' => 85,
            ],
            [
                'key' => 'about_team_name_3',
                'value' => 'Nagari Lubuk Basung',
                'type' => 'text',
                'group' => 'homepage',
                'description' => 'Nama Tim 3',
                'order' => 86,
            ],
            [
                'key' => 'about_team_logo_4',
                'value' => '',
                'type' => 'image',
                'group' => 'homepage',
                'description' => 'Logo Kabupaten Agam',
                'order' => 87,
            ],
            [
                'key' => 'about_team_name_4',
                'value' => 'Kabupaten Agam',
                'type' => 'text',
                'group' => 'homepage',
                'description' => 'Nama Tim 4',
                'order' => 88,
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
