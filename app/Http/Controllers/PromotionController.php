<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Promotion;
use App\Models\Review;
use App\Services\CacheService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PromotionController extends Controller
{
    /**
     * Display promotions list page.
     */
    public function index(Request $request): View
    {
        $query = Promotion::where('status', 'active')
            ->with(['category:id,name'])
            ->withCount(['approvedReviews as reviews_count'])
            ->withAvg('approvedReviews as average_rating', 'rating');

        // Search
        if ($request->has('search') && !empty($request->input('search'))) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Filter by category
        if ($request->has('category') && !empty($request->input('category'))) {
            $query->where('category_id', $request->input('category'));
        }

        // Filter by status (active/expired)
        if ($request->has('status') && !empty($request->input('status'))) {
            $status = $request->input('status');
            if ($status === 'active') {
                $query->where(function ($q) {
                    $q->whereNull('end_date')
                      ->orWhere('end_date', '>=', now());
                });
            } elseif ($status === 'expired') {
                $query->where('end_date', '<', now());
            }
        }

        // Order by validity and creation
        $promotions = $query->orderByRaw('CASE WHEN end_date IS NULL OR end_date >= NOW() THEN 0 ELSE 1 END')
            ->orderBy('created_at', 'desc')
            ->paginate(12)
            ->withQueryString();

        // Get categories for filter
        $categories = Category::orderBy('name')->get(['id', 'name']);

        // Get settings
        $settings = CacheService::getHomepageSettings();

        return view('promotions.index', compact(
            'promotions',
            'categories',
            'settings'
        ));
    }

    /**
     * Display single promotion detail.
     */
    public function show(string $slug): View
    {
        $promotion = Promotion::where('slug', $slug)
            ->where('status', 'active')
            ->with(['category:id,name'])
            ->firstOrFail();

        // Get related promotions from same category
        $relatedPromotions = Promotion::where('status', 'active')
            ->where('id', '!=', $promotion->id)
            ->where(function ($q) use ($promotion) {
                if ($promotion->category_id) {
                    $q->where('category_id', $promotion->category_id);
                }
            })
            ->where(function ($q) {
                $q->whereNull('end_date')
                  ->orWhere('end_date', '>=', now());
            })
            ->orderBy('created_at', 'desc')
            ->limit(4)
            ->get();

        // Get settings
        $settings = CacheService::getHomepageSettings();

        // Get reviews
        $reviews = $promotion->approvedReviews()
            ->latest()
            ->paginate(10);

        // Get rating stats
        $reviewStats = $promotion->rating_stats;

        return view('promotions.show', compact(
            'promotion',
            'relatedPromotions',
            'settings',
            'reviews',
            'reviewStats'
        ));
    }
}
