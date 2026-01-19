<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            // Categories for News
            [
                'name' => 'Berita Umum',
                'slug' => 'berita-umum',
                'description' => 'Berita umum seputar BUMNag',
                'type' => 'news',
                'icon' => 'heroicon-o-newspaper',
                'color' => '#3b82f6',
                'is_active' => true,
                'order' => 1,
            ],
            [
                'name' => 'Kegiatan',
                'slug' => 'kegiatan',
                'description' => 'Kegiatan dan acara BUMNag',
                'type' => 'news',
                'icon' => 'heroicon-o-calendar',
                'color' => '#10b981',
                'is_active' => true,
                'order' => 2,
            ],
            [
                'name' => 'Pengumuman',
                'slug' => 'pengumuman',
                'description' => 'Pengumuman resmi dari BUMNag',
                'type' => 'news',
                'icon' => 'heroicon-o-megaphone',
                'color' => '#f59e0b',
                'is_active' => true,
                'order' => 3,
            ],
            
            // Categories for Reports
            [
                'name' => 'Laporan Keuangan',
                'slug' => 'laporan-keuangan',
                'description' => 'Laporan keuangan BUMNag',
                'type' => 'report',
                'icon' => 'heroicon-o-currency-dollar',
                'color' => '#8b5cf6',
                'is_active' => true,
                'order' => 4,
            ],
            [
                'name' => 'Laporan Kegiatan',
                'slug' => 'laporan-kegiatan',
                'description' => 'Laporan kegiatan BUMNag',
                'type' => 'report',
                'icon' => 'heroicon-o-document-text',
                'color' => '#06b6d4',
                'is_active' => true,
                'order' => 5,
            ],
            
            // Categories for Promotions
            [
                'name' => 'Produk Unggulan',
                'slug' => 'produk-unggulan',
                'description' => 'Promosi produk unggulan',
                'type' => 'promotion',
                'icon' => 'heroicon-o-star',
                'color' => '#eab308',
                'is_active' => true,
                'order' => 6,
            ],
            [
                'name' => 'Layanan',
                'slug' => 'layanan',
                'description' => 'Promosi layanan BUMNag',
                'type' => 'promotion',
                'icon' => 'heroicon-o-wrench-screwdriver',
                'color' => '#ec4899',
                'is_active' => true,
                'order' => 7,
            ],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
