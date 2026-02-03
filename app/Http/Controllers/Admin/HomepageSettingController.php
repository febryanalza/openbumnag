<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Services\CacheService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

/**
 * Controller untuk mengatur semua konten halaman depan website.
 * Best Practice: 
 * - Memisahkan pengaturan homepage dari setting umum
 * - Mendukung multiple hero images dengan ordering
 * - Semua teks dapat diedit secara dinamis
 * - Cache otomatis di-clear saat ada perubahan
 */
class HomepageSettingController extends Controller
{
    /**
     * Homepage setting sections with their keys and labels
     */
    protected array $sections = [
        'hero' => [
            'label' => 'Hero Section',
            'icon' => 'photo',
            'settings' => [
                'hero_title' => ['label' => 'Judul Hero', 'type' => 'text', 'placeholder' => 'Selamat Datang di'],
                'hero_subtitle' => ['label' => 'Sub Judul Hero', 'type' => 'text', 'placeholder' => 'Lubas Mandiri'],
                'hero_description' => ['label' => 'Deskripsi Hero', 'type' => 'textarea', 'placeholder' => 'Badan Usaha Milik Nagari yang berkomitmen untuk kesejahteraan masyarakat'],
                'hero_cta_primary_text' => ['label' => 'Teks Tombol Utama', 'type' => 'text', 'placeholder' => 'Jelajahi Produk'],
                'hero_cta_primary_link' => ['label' => 'Link Tombol Utama', 'type' => 'text', 'placeholder' => '/katalog'],
                'hero_cta_secondary_text' => ['label' => 'Teks Tombol Sekunder', 'type' => 'text', 'placeholder' => 'Tentang Kami'],
                'hero_cta_secondary_link' => ['label' => 'Link Tombol Sekunder', 'type' => 'text', 'placeholder' => '/tentang'],
                'hero_autoplay_duration' => ['label' => 'Durasi Slide (ms)', 'type' => 'number', 'placeholder' => '5000'],
                'hero_max_slides' => ['label' => 'Maksimal Gambar Slider', 'type' => 'number', 'placeholder' => '5'],
            ],
        ],
        'about' => [
            'label' => 'Unit Usaha Section',
            'icon' => 'building-office',
            'settings' => [
                'about_title' => ['label' => 'Judul Section', 'type' => 'text', 'placeholder' => 'Unit Usaha Kami'],
                'about_description' => ['label' => 'Deskripsi Section', 'type' => 'textarea', 'placeholder' => 'Berbagai unit usaha yang kami kelola'],
                'about_cta_text' => ['label' => 'Teks Tombol', 'type' => 'text', 'placeholder' => 'Lihat Semua Unit Usaha'],
            ],
        ],
        'news' => [
            'label' => 'Berita Section',
            'icon' => 'newspaper',
            'settings' => [
                'news_title' => ['label' => 'Judul Section', 'type' => 'text', 'placeholder' => 'Berita Terbaru'],
                'news_description' => ['label' => 'Deskripsi Section', 'type' => 'textarea', 'placeholder' => 'Informasi dan update terkini'],
                'news_homepage_limit' => ['label' => 'Jumlah Berita Ditampilkan', 'type' => 'number', 'placeholder' => '6'],
                'news_cta_text' => ['label' => 'Teks Tombol', 'type' => 'text', 'placeholder' => 'Lihat Semua Berita'],
            ],
        ],
        'reports' => [
            'label' => 'Laporan Section',
            'icon' => 'document-chart-bar',
            'settings' => [
                'reports_title' => ['label' => 'Judul Section', 'type' => 'text', 'placeholder' => 'Laporan & Transparansi'],
                'reports_description' => ['label' => 'Deskripsi Section', 'type' => 'textarea', 'placeholder' => 'Laporan keuangan dan kegiatan'],
                'reports_homepage_limit' => ['label' => 'Jumlah Laporan Ditampilkan', 'type' => 'number', 'placeholder' => '6'],
                'reports_cta_text' => ['label' => 'Teks Tombol', 'type' => 'text', 'placeholder' => 'Lihat Semua Laporan'],
            ],
        ],
        'catalog' => [
            'label' => 'Katalog Section',
            'icon' => 'shopping-bag',
            'settings' => [
                'catalog_title' => ['label' => 'Judul Section', 'type' => 'text', 'placeholder' => 'Kodai Kami'],
                'catalog_description' => ['label' => 'Deskripsi Section', 'type' => 'textarea', 'placeholder' => 'Produk-produk berkualitas dari unit usaha kami'],
                'catalog_homepage_limit' => ['label' => 'Jumlah Produk Ditampilkan', 'type' => 'number', 'placeholder' => '6'],
                'catalog_cta_text' => ['label' => 'Teks Tombol', 'type' => 'text', 'placeholder' => 'Lihat Semua Produk'],
            ],
        ],
        'cta' => [
            'label' => 'Call to Action Section',
            'icon' => 'megaphone',
            'settings' => [
                'cta_title' => ['label' => 'Judul CTA', 'type' => 'text', 'placeholder' => 'Mari Berkembang Bersama'],
                'cta_description' => ['label' => 'Deskripsi CTA', 'type' => 'textarea', 'placeholder' => 'Bergabunglah dengan kami dalam membangun ekonomi nagari'],
                'cta_primary_text' => ['label' => 'Teks Tombol Utama', 'type' => 'text', 'placeholder' => 'Hubungi Kami'],
                'cta_primary_link' => ['label' => 'Link Tombol Utama', 'type' => 'text', 'placeholder' => '#kontak'],
                'cta_secondary_text' => ['label' => 'Teks Tombol Sekunder', 'type' => 'text', 'placeholder' => 'Pelajari Lebih Lanjut'],
                'cta_secondary_link' => ['label' => 'Link Tombol Sekunder', 'type' => 'text', 'placeholder' => '/tentang'],
            ],
        ],
        'general' => [
            'label' => 'Pengaturan Umum',
            'icon' => 'cog-6-tooth',
            'settings' => [
                'site_name' => ['label' => 'Nama Website', 'type' => 'text', 'placeholder' => 'Lubas Mandiri'],
                'site_tagline' => ['label' => 'Tagline', 'type' => 'text', 'placeholder' => 'Badan Usaha Milik Nagari'],
                'site_description' => ['label' => 'Deskripsi Website', 'type' => 'textarea', 'placeholder' => 'BUMNag Lubas Mandiri'],
                'site_keywords' => ['label' => 'Keywords (SEO)', 'type' => 'text', 'placeholder' => 'bumnag, lubas mandiri, nagari'],
                'footer_copyright' => ['label' => 'Teks Copyright', 'type' => 'text', 'placeholder' => '© 2026 Lubas Mandiri. All rights reserved.'],
            ],
        ],
    ];

    /**
     * Display homepage settings management page.
     */
    public function index(Request $request)
    {
        $currentSection = $request->get('section', 'hero');
        
        // Validate section
        if (!array_key_exists($currentSection, $this->sections)) {
            $currentSection = 'hero';
        }

        // Get all current settings
        $settings = Setting::whereIn('key', $this->getAllSettingKeys())
            ->pluck('value', 'key')
            ->toArray();

        // Get hero images
        $heroImages = $this->getHeroImages();

        return view('admin.homepage-settings.index', [
            'sections' => $this->sections,
            'currentSection' => $currentSection,
            'settings' => $settings,
            'heroImages' => $heroImages,
        ]);
    }

    /**
     * Update homepage settings.
     */
    public function update(Request $request)
    {
        $section = $request->input('section', 'hero');
        
        // Validate section exists
        if (!array_key_exists($section, $this->sections)) {
            return back()->with('error', 'Section tidak valid.');
        }

        $sectionSettings = $this->sections[$section]['settings'];
        
        foreach ($sectionSettings as $key => $config) {
            $value = $request->input("settings.{$key}");
            
            // Handle empty values
            if ($value === null || $value === '') {
                continue;
            }

            // Determine type for storage
            $type = match($config['type']) {
                'number' => 'number',
                'textarea' => 'textarea',
                default => 'text',
            };

            Setting::updateOrCreate(
                ['key' => $key],
                [
                    'value' => $value,
                    'type' => $type,
                    'group' => 'homepage',
                    'description' => $config['label'],
                ]
            );
        }

        // Clear cache
        CacheService::clearSettingsCache();
        CacheService::clearHomepageCache();

        return back()->with('success', 'Pengaturan ' . $this->sections[$section]['label'] . ' berhasil disimpan.');
    }

    /**
     * Hero images management page.
     */
    public function heroImages()
    {
        $heroImages = $this->getHeroImages();
        $maxSlides = (int) Setting::get('hero_max_slides', 5);

        return view('admin.homepage-settings.hero-images', [
            'heroImages' => $heroImages,
            'maxSlides' => $maxSlides,
        ]);
    }

    /**
     * Upload hero image.
     */
    public function uploadHeroImage(Request $request)
    {
        $request->validate([
            'image' => ['required', 'image', 'mimes:jpeg,png,jpg,webp', 'max:5120'], // Max 5MB
            'title' => ['nullable', 'string', 'max:255'],
        ]);

        $heroImages = $this->getHeroImages();
        $maxSlides = (int) Setting::get('hero_max_slides', 10);

        if (count($heroImages) >= $maxSlides) {
            return back()->with('error', "Maksimal {$maxSlides} gambar hero yang dapat diupload.");
        }

        $file = $request->file('image');
        $path = $file->store('hero-images', 'public');

        // Add to hero images array
        $heroImages[] = [
            'path' => $path,
            'title' => $request->input('title', 'Hero Slide ' . (count($heroImages) + 1)),
            'order' => count($heroImages),
        ];

        // Save to settings
        $this->saveHeroImages($heroImages);

        // Clear cache
        CacheService::clearSettingsCache();
        CacheService::clearHomepageCache();

        return back()->with('success', 'Gambar hero berhasil diupload.');
    }

    /**
     * Update hero image order.
     */
    public function updateHeroImageOrder(Request $request)
    {
        $request->validate([
            'order' => ['required', 'array'],
            'order.*' => ['integer'],
        ]);

        $heroImages = $this->getHeroImages();
        $newOrder = $request->input('order');
        
        // Reorder images
        $reorderedImages = [];
        foreach ($newOrder as $index) {
            if (isset($heroImages[$index])) {
                $heroImages[$index]['order'] = count($reorderedImages);
                $reorderedImages[] = $heroImages[$index];
            }
        }

        $this->saveHeroImages($reorderedImages);

        // Clear cache
        CacheService::clearSettingsCache();
        CacheService::clearHomepageCache();

        return response()->json(['success' => true, 'message' => 'Urutan gambar berhasil diperbarui.']);
    }

    /**
     * Update hero image title.
     */
    public function updateHeroImageTitle(Request $request, int $index)
    {
        $request->validate([
            'title' => ['required', 'string', 'max:255'],
        ]);

        $heroImages = $this->getHeroImages();
        
        if (!isset($heroImages[$index])) {
            return back()->with('error', 'Gambar tidak ditemukan.');
        }

        $heroImages[$index]['title'] = $request->input('title');
        $this->saveHeroImages($heroImages);

        // Clear cache
        CacheService::clearSettingsCache();
        CacheService::clearHomepageCache();

        return back()->with('success', 'Judul gambar berhasil diperbarui.');
    }

    /**
     * Delete hero image.
     */
    public function deleteHeroImage(int $index)
    {
        $heroImages = $this->getHeroImages();
        
        if (!isset($heroImages[$index])) {
            return back()->with('error', 'Gambar tidak ditemukan.');
        }

        // Delete file from storage
        $imagePath = $heroImages[$index]['path'];
        if (Storage::disk('public')->exists($imagePath)) {
            Storage::disk('public')->delete($imagePath);
        }

        // Remove from array
        unset($heroImages[$index]);
        
        // Re-index and update order
        $heroImages = array_values($heroImages);
        foreach ($heroImages as $i => &$image) {
            $image['order'] = $i;
        }

        $this->saveHeroImages($heroImages);

        // Clear cache
        CacheService::clearSettingsCache();
        CacheService::clearHomepageCache();

        return back()->with('success', 'Gambar hero berhasil dihapus.');
    }

    /**
     * Get all setting keys from all sections.
     */
    protected function getAllSettingKeys(): array
    {
        $keys = [];
        foreach ($this->sections as $section) {
            $keys = array_merge($keys, array_keys($section['settings']));
        }
        return $keys;
    }

    /**
     * Get hero images from settings.
     */
    protected function getHeroImages(): array
    {
        $heroImagesData = Setting::get('hero_images', []);
        
        // Handle both array (already decoded) and string (JSON) formats
        if (is_string($heroImagesData)) {
            $heroImages = json_decode($heroImagesData, true) ?? [];
        } else {
            $heroImages = is_array($heroImagesData) ? $heroImagesData : [];
        }
        
        // Ensure all images have proper structure
        return array_map(function ($image, $index) {
            if (is_string($image)) {
                return [
                    'path' => $image,
                    'title' => 'Hero Slide ' . ($index + 1),
                    'order' => $index,
                ];
            }
            return $image;
        }, $heroImages, array_keys($heroImages));
    }

    /**
     * Save hero images to settings.
     */
    protected function saveHeroImages(array $heroImages): void
    {
        Setting::updateOrCreate(
            ['key' => 'hero_images'],
            [
                'value' => json_encode($heroImages),
                'type' => 'json',
                'group' => 'homepage',
                'description' => 'Hero slider images',
            ]
        );
    }
}
