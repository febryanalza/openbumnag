<?php

namespace App\Http\Controllers;

use App\Helpers\SettingHelper;
use App\Models\Catalog;
use App\Models\BumnagProfile;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CatalogController extends Controller
{
    /**
     * Display a listing of catalogs.
     */
    public function index(): View
    {
        $catalogs = Catalog::with('bumnagProfile:id,name,slug')
            ->withCount(['approvedReviews as reviews_count'])
            ->withAvg('approvedReviews as average_rating', 'rating')
            ->where('is_available', true)
            ->orderBy('is_featured', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        $settings = [
            'catalog_title' => SettingHelper::get('catalog_title', 'Kodai Kami'),
            'catalog_description' => SettingHelper::get('catalog_description', 'Produk-produk berkualitas dari unit usaha kami'),
        ];

        // Get categories for filter
        $categories = Catalog::select('category')
            ->distinct()
            ->whereNotNull('category')
            ->pluck('category');

        // Get all unit usaha for filter
        $bumnagProfiles = BumnagProfile::where('is_active', true)
            ->orderBy('name', 'asc')
            ->get(['id', 'name']);

        return view('catalogs.index', compact('catalogs', 'settings', 'categories', 'bumnagProfiles'));
    }

    /**
     * Display the specified catalog.
     */
    public function show(string $slug): View
    {
        $catalog = Catalog::with('bumnagProfile')
            ->where('slug', $slug)
            ->firstOrFail();

        // Increment view count
        $catalog->increment('view_count');

        // Get related products from same unit usaha
        $relatedProducts = Catalog::with('bumnagProfile:id,name,slug')
            ->where('bumnag_profile_id', $catalog->bumnag_profile_id)
            ->where('id', '!=', $catalog->id)
            ->where('is_available', true)
            ->orderBy('is_featured', 'desc')
            ->take(4)
            ->get();

        // Get reviews
        $reviews = $catalog->approvedReviews()
            ->latest()
            ->paginate(10);

        // Get rating stats
        $reviewStats = $catalog->rating_stats;

        return view('catalogs.show', compact('catalog', 'relatedProducts', 'reviews', 'reviewStats'));
    }
}
