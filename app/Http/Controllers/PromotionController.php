<?php

namespace App\Http\Controllers;

use App\Models\BumnagProfile;
use App\Models\Promotion;
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
        $query = Promotion::where('is_active', true)
            ->with(['bumnagProfile:id,name,slug']);

        // Search
        if ($request->has('search') && !empty($request->input('search'))) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Filter by unit usaha
        if ($request->has('unit_usaha') && !empty($request->input('unit_usaha'))) {
            $query->where('bumnag_profile_id', $request->input('unit_usaha'));
        }

        // Filter by status (active/expired)
        if ($request->has('status') && !empty($request->input('status'))) {
            $status = $request->input('status');
            if ($status === 'active') {
                $query->where(function ($q) {
                    $q->whereNull('valid_until')
                      ->orWhere('valid_until', '>=', now());
                });
            } elseif ($status === 'expired') {
                $query->where('valid_until', '<', now());
            }
        }

        // Order by validity and creation
        $promotions = $query->orderByRaw('CASE WHEN valid_until IS NULL OR valid_until >= NOW() THEN 0 ELSE 1 END')
            ->orderBy('created_at', 'desc')
            ->paginate(12)
            ->withQueryString();

        // Get BUMNag profiles for filter
        $bumnagProfiles = BumnagProfile::where('is_active', true)
            ->orderBy('name')
            ->get(['id', 'name']);

        // Get settings
        $settings = CacheService::getHomepageSettings();

        // Get global settings for contact info
        $globalSettings = CacheService::getGlobalSettings();

        return view('promotions.index', compact(
            'promotions',
            'bumnagProfiles',
            'settings',
            'globalSettings'
        ));
    }

    /**
     * Display single promotion detail.
     */
    public function show(string $slug): View
    {
        $promotion = Promotion::where('slug', $slug)
            ->where('is_active', true)
            ->with(['bumnagProfile:id,name,slug'])
            ->firstOrFail();

        // Get related promotions from same BUMNag
        $relatedPromotions = Promotion::where('is_active', true)
            ->where('id', '!=', $promotion->id)
            ->where(function ($q) use ($promotion) {
                if ($promotion->bumnag_profile_id) {
                    $q->where('bumnag_profile_id', $promotion->bumnag_profile_id);
                }
            })
            ->where(function ($q) {
                $q->whereNull('valid_until')
                  ->orWhere('valid_until', '>=', now());
            })
            ->orderBy('created_at', 'desc')
            ->limit(4)
            ->get();

        // Get global settings for contact info
        $globalSettings = CacheService::getGlobalSettings();

        return view('promotions.show', compact(
            'promotion',
            'relatedPromotions',
            'globalSettings'
        ));
    }
}
