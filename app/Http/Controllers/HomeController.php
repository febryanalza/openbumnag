<?php

namespace App\Http\Controllers;

use App\Helpers\SettingHelper;
use App\Models\BumnagProfile;
use App\Models\Catalog;
use App\Models\Gallery;
use App\Models\News;
use App\Models\Promotion;
use App\Models\Report;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HomeController extends Controller
{
    /**
     * Display the landing page.
     */
    public function index(): View
    {
        // Get settings for hero section
        $heroMaxSlides = (int) SettingHelper::get('hero_max_slides', 5);
        $heroAutoplayDuration = (int) SettingHelper::get('hero_autoplay_duration', 5000);
        $newsLimit = (int) SettingHelper::get('news_homepage_limit', 6);
        $reportsLimit = (int) SettingHelper::get('reports_homepage_limit', 6);
        $catalogLimit = (int) SettingHelper::get('catalog_homepage_limit', 6);

        // Get hero images from settings
        $heroImagesData = SettingHelper::get('hero_images', '[]');
        
        // Handle both string (JSON) and array formats
        if (is_string($heroImagesData)) {
            $heroImagesPaths = json_decode($heroImagesData, true) ?? [];
        } else {
            $heroImagesPaths = is_array($heroImagesData) ? $heroImagesData : [];
        }
        
        // Debug: Log the paths
        \Log::info('Hero Images Paths:', ['paths' => $heroImagesPaths]);
        
        // Limit hero images based on setting
        $heroImagesPaths = array_slice($heroImagesPaths, 0, $heroMaxSlides);
        
        // If no images in settings, fallback to gallery
        if (empty($heroImagesPaths)) {
            $heroImages = Gallery::where('is_featured', true)
                ->where('file_type', 'image')
                ->orderBy('order', 'asc')
                ->take($heroMaxSlides)
                ->get(['id', 'title', 'file_path']);
        } else {
            // Convert paths to collection for consistency
            $heroImages = collect($heroImagesPaths)->map(function($path, $index) {
                \Log::info('Processing hero image:', ['index' => $index, 'path' => $path]);
                return (object)[
                    'id' => $index,
                    'title' => 'Hero Slide ' . ($index + 1),
                    'file_path' => $path
                ];
            });
        }

        // Get all BUMNAG profiles/unit usaha - Only essential data for homepage cards
        $bumnagProfiles = BumnagProfile::where('is_active', true)
            ->orderBy('name', 'asc')
            ->get(['id', 'name', 'slug', 'tagline', 'about', 'logo', 'banner']);

        // Get latest news - Only essential data for homepage
        $latestNews = News::where('status', 'published')
            ->with(['category:id,name'])
            ->orderBy('published_at', 'desc')
            ->take($newsLimit)
            ->get(['id', 'title', 'slug', 'excerpt', 'featured_image', 'published_at', 'category_id', 'views']);

        // Get latest reports
        $latestReports = Report::where('status', 'published')
            ->orderBy('published_at', 'desc')
            ->take($reportsLimit)
            ->get(['id', 'title', 'slug', 'description', 'file_path', 'published_at', 'type', 'year']);

        // Get latest promotions (3 items)
        $promotions = Promotion::where('status', 'active')
            ->where('start_date', '<=', now())
            ->where(function ($query) {
                $query->whereNull('end_date')
                    ->orWhere('end_date', '>=', now());
            })
            ->orderBy('created_at', 'desc')
            ->take(3)
            ->get(['id', 'title', 'slug', 'excerpt', 'featured_image', 'discount_percentage']);

        // Get all featured catalogs for homepage (no limit, show all featured products)
        $featuredCatalogs = Catalog::with('bumnagProfile:id,name,slug')
            ->where('is_available', true)
            ->where('is_featured', true)
            ->orderBy('created_at', 'desc')
            ->get(['id', 'name', 'slug', 'description', 'price', 'unit', 'featured_image', 'bumnag_profile_id', 'category', 'stock', 'is_featured']);

        // Get all settings for the page
        $settings = [
            // General
            'site_name' => SettingHelper::get('site_name', 'Lubas Mandiri'),
            'site_tagline' => SettingHelper::get('site_tagline', 'Badan Usaha Milik Nagari'),
            'site_description' => SettingHelper::get('site_description', 'BUMNag Lubas Mandiri'),
            
            // Hero Section
            'hero_title' => SettingHelper::get('hero_title', 'Selamat Datang di'),
            'hero_subtitle' => SettingHelper::get('hero_subtitle', 'Lubas Mandiri'),
            'hero_description' => SettingHelper::get('hero_description', 'Badan Usaha Milik Nagari yang berkomitmen untuk kesejahteraan masyarakat'),
            'hero_autoplay_duration' => $heroAutoplayDuration,
            
            // About Section
            'about_title' => SettingHelper::get('about_title', 'Unit Usaha Kami'),
            'about_description' => SettingHelper::get('about_description', 'Berbagai unit usaha yang kami kelola'),
            
            // News Section
            'news_title' => SettingHelper::get('news_title', 'Berita Terbaru'),
            'news_description' => SettingHelper::get('news_description', 'Informasi dan update terkini'),
            
            // Reports Section
            'reports_title' => SettingHelper::get('reports_title', 'Laporan & Transparansi'),
            'reports_description' => SettingHelper::get('reports_description', 'Laporan keuangan dan kegiatan'),
            
            // Catalog Section
            'catalog_title' => SettingHelper::get('catalog_title', 'Kodai Kami'),
            'catalog_description' => SettingHelper::get('catalog_description', 'Produk-produk berkualitas dari unit usaha kami'),
            
            // CTA Section
            'cta_title' => SettingHelper::get('cta_title', 'Mari Berkembang Bersama'),
            'cta_description' => SettingHelper::get('cta_description', 'Bergabunglah dengan kami dalam membangun ekonomi nagari'),
        ];

        return view('home', compact(
            'heroImages',
            'bumnagProfiles',
            'latestNews',
            'latestReports',
            'promotions',
            'featuredCatalogs',
            'settings'
        ));
    }

    /**
     * Display about us page.
     */
    public function about(): View
    {
        $bumnagProfiles = BumnagProfile::where('is_active', true)
            ->orderBy('name', 'asc')
            ->get();
        
        return view('about', compact('bumnagProfiles'));
    }

    /**
     * Display news list page.
     */
    public function news(Request $request): View
    {
        $query = News::where('status', 'published')
            ->with(['category:id,name']); // Eager load only category id & name

        // Search
        if ($request->has('search') && !empty($request->input('search'))) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('content', 'like', "%{$search}%")
                    ->orWhere('excerpt', 'like', "%{$search}%");
            });
        }

        // Filter by category
        if ($request->has('category') && !empty($request->input('category'))) {
            $query->where('category_id', $request->input('category'));
        }

        // Only select columns needed for list view
        $news = $query->orderBy('published_at', 'desc')
            ->paginate(20, ['id', 'title', 'slug', 'excerpt', 'featured_image', 'published_at', 'category_id', 'views']);

        // Get all categories for filter (only id & name)
        $categories = \App\Models\Category::orderBy('name')->get(['id', 'name']);

        return view('news.index', compact('news', 'categories'));
    }

    /**
     * Display single news detail.
     */
    public function newsDetail(string $slug): View
    {
        $news = News::with(['category', 'user'])
            ->where('slug', $slug)
            ->where('status', 'published')
            ->firstOrFail();

        // Increment views
        $news->increment('views');

        // Get related news (same category)
        $relatedNews = News::where('status', 'published')
            ->where('category_id', $news->category_id)
            ->where('id', '!=', $news->id)
            ->orderBy('published_at', 'desc')
            ->take(4)
            ->get(['id', 'title', 'slug', 'excerpt', 'featured_image', 'published_at']);

        // Get latest news for sidebar
        $latestNews = News::where('status', 'published')
            ->where('id', '!=', $news->id)
            ->orderBy('published_at', 'desc')
            ->take(5)
            ->get(['id', 'title', 'slug', 'published_at', 'views']);

        return view('news.show', compact('news', 'relatedNews', 'latestNews'));
    }

    /**
     * Display preview of news (for admin before publishing).
     */
    public function newsPreview(Request $request, string $slug): View
    {
        // Get preview data from query parameter
        if ($request->has('data')) {
            $data = json_decode(base64_decode($request->input('data')), true);
            
            // Create a temporary News object with preview data
            $news = new News($data);
            $news->slug = $slug;
            
            // Load category if exists
            if (!empty($data['category_id'])) {
                $news->setRelation('category', \App\Models\Category::find($data['category_id']));
            }
            
            // Load user
            if (!empty($data['user_id'])) {
                $news->setRelation('user', \App\Models\User::find($data['user_id']));
            } else {
                $news->setRelation('user', auth()->user());
            }
            
            // Set published_at if not set
            if (empty($news->published_at)) {
                $news->published_at = now();
            }
        } else {
            // Fallback: load from database
            $news = News::with(['category', 'user'])->where('slug', $slug)->firstOrFail();
        }

        // Get related news (same category)
        $relatedNews = News::where('status', 'published')
            ->when($news->category_id, fn($q) => $q->where('category_id', $news->category_id))
            ->where('slug', '!=', $slug)
            ->orderBy('published_at', 'desc')
            ->take(4)
            ->get(['id', 'title', 'slug', 'excerpt', 'featured_image', 'published_at']);

        // Get latest news for sidebar
        $latestNews = News::where('status', 'published')
            ->orderBy('published_at', 'desc')
            ->take(5)
            ->get(['id', 'title', 'slug', 'published_at', 'views']);

        return view('news.show', compact('news', 'relatedNews', 'latestNews'))
            ->with('isPreview', true);
    }

    /**
     * Display reports list page.
     */
    public function reports(Request $request): View
    {
        $query = Report::where('status', 'published');

        // Filter by type
        if ($request->has('type')) {
            $query->where('type', $request->input('type'));
        }

        // Filter by year
        if ($request->has('year')) {
            $query->where('year', $request->input('year'));
        }

        $reports = $query->orderBy('published_at', 'desc')
            ->paginate(12);

        return view('reports.index', compact('reports'));
    }

    /**
     * Display single report detail.
     */
    public function reportDetail(string $slug): View
    {
        $report = Report::where('slug', $slug)
            ->where('status', 'published')
            ->firstOrFail();

        // Increment downloads
        $report->increment('downloads');

        return view('reports.show', compact('report'));
    }

    /**
     * Display preview of report (for admin before publishing).
     */
    public function reportPreview(Request $request, string $slug): View
    {
        // Get preview data from query parameter
        if ($request->has('data')) {
            $data = json_decode(base64_decode($request->input('data')), true);
            
            // Create a temporary Report object with preview data
            $report = new Report($data);
            $report->slug = $slug;
            
            // Load category if exists
            if (!empty($data['category_id'])) {
                $report->setRelation('category', \App\Models\Category::find($data['category_id']));
            }
            
            // Load user
            if (!empty($data['user_id'])) {
                $report->setRelation('user', \App\Models\User::find($data['user_id']));
            } else {
                $report->setRelation('user', auth()->user());
            }
            
            // Set published_at if not set
            if (empty($report->published_at)) {
                $report->published_at = now();
            }
        } else {
            // Fallback: load from database
            $report = Report::where('slug', $slug)->firstOrFail();
        }

        return view('reports.show', compact('report'))
            ->with('isPreview', true);
    }

    /**
     * Display gallery page.
     */
    public function gallery(Request $request): View
    {
        $query = Gallery::query();

        // Filter by type
        if ($request->has('type')) {
            $query->where('type', $request->input('type'));
        }

        // Filter by album
        if ($request->has('album')) {
            $query->where('album', $request->input('album'));
        }

        $galleries = $query->orderBy('taken_date', 'desc')
            ->orderBy('order', 'asc')
            ->paginate(24);

        return view('gallery', compact('galleries'));
    }
}
