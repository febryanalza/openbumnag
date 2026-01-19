<?php

namespace App\Http\Controllers;

use App\Models\BumnagProfile;
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
        // Get hero images from gallery (featured or type gallery)
        $heroImages = Gallery::where('is_featured', true)
            ->where('file_type', 'image')
            ->orderBy('order', 'asc')
            ->take(5)
            ->get(['id', 'title', 'file_path', 'description']);

        // Get all BUMNAG profiles/unit usaha
        $bumnagProfiles = BumnagProfile::where('is_active', true)
            ->orderBy('name', 'asc')
            ->get(['id', 'name', 'slug', 'tagline', 'about', 'logo', 'banner', 'address', 'phone', 'email']);

        // Get latest news (6 items)
        $latestNews = News::where('status', 'published')
            ->orderBy('published_at', 'desc')
            ->take(6)
            ->get(['id', 'title', 'slug', 'excerpt', 'featured_image', 'published_at', 'category_id']);

        // Get latest reports (6 items)
        $latestReports = Report::where('status', 'published')
            ->orderBy('published_at', 'desc')
            ->take(6)
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
            ->get(['id', 'title', 'slug', 'excerpt', 'description', 'featured_image', 'discount_percentage', 'promotion_type']);

        // Get site settings
        $siteName = Setting::where('key', 'site_name')->value('value') ?? 'Lubas Mandiri';
        $siteTagline = Setting::where('key', 'site_tagline')->value('value') ?? 'BUMNag Desa Lubas';
        $siteDescription = Setting::where('key', 'site_description')->value('value') ?? 'Badan Usaha Milik Nagari Lubas Mandiri';

        return view('home', compact(
            'heroImages',
            'bumnagProfiles',
            'latestNews',
            'latestReports',
            'promotions',
            'siteName',
            'siteTagline',
            'siteDescription'
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
        $query = News::where('status', 'published');

        // Search
        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('content', 'like', "%{$search}%");
            });
        }

        // Filter by category
        if ($request->has('category')) {
            $query->where('category_id', $request->input('category'));
        }

        $news = $query->orderBy('published_at', 'desc')
            ->paginate(12);

        return view('news.index', compact('news'));
    }

    /**
     * Display single news detail.
     */
    public function newsDetail(string $slug): View
    {
        $news = News::where('slug', $slug)
            ->where('status', 'published')
            ->firstOrFail();

        // Increment views
        $news->increment('views');

        // Get related news (same category)
        $relatedNews = News::where('status', 'published')
            ->where('category_id', $news->category_id)
            ->where('id', '!=', $news->id)
            ->orderBy('published_at', 'desc')
            ->take(3)
            ->get();

        return view('news.show', compact('news', 'relatedNews'));
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
