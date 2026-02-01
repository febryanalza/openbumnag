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
use App\Services\CacheService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class HomeController extends Controller
{
    /**
     * Display the landing page.
     * 
     * Optimized: All homepage data is cached to reduce database queries.
     * Cache is cleared when content is updated via admin panel.
     */
    public function index(): View
    {
        // Get cached homepage data (single cache call instead of multiple queries)
        $homepageData = CacheService::getHomepageData();
        $settings = CacheService::getHomepageSettings();

        return view('home', [
            'heroImages' => $homepageData['heroImages'],
            'bumnagProfiles' => $homepageData['bumnagProfiles'],
            'latestNews' => $homepageData['latestNews'],
            'latestReports' => $homepageData['latestReports'],
            'promotions' => $homepageData['promotions'],
            'featuredCatalogs' => $homepageData['featuredCatalogs'],
            'settings' => $settings,
        ]);
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
     * Display single BUMNag profile detail with products.
     */
    public function bumnagDetail(string $slug): View
    {
        // Get BUMNag profile
        $bumnag = BumnagProfile::where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        // Get all products/catalogs related to this BUMNag
        $products = Catalog::where('bumnag_profile_id', $bumnag->id)
            ->where('is_available', true)
            ->orderBy('is_featured', 'desc')
            ->orderBy('name', 'asc')
            ->paginate(12);

        // Get statistics
        $stats = [
            'total_products' => Catalog::where('bumnag_profile_id', $bumnag->id)->count(),
            'available_products' => Catalog::where('bumnag_profile_id', $bumnag->id)
                ->where('is_available', true)
                ->count(),
            'featured_products' => Catalog::where('bumnag_profile_id', $bumnag->id)
                ->where('is_featured', true)
                ->count(),
        ];

        return view('bumnag.show', compact('bumnag', 'products', 'stats'));
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
                $news->setRelation('user', Auth::user());
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
                $report->setRelation('user', Auth::user());
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
}
