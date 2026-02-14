<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Catalog;
use App\Models\Promotion;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\RateLimiter;

class ReviewController extends Controller
{
    /**
     * Store a newly created review.
     */
    public function store(Request $request): RedirectResponse
    {
        // Rate limiting - 5 reviews per hour per IP
        $key = 'review:' . $request->ip();
        if (RateLimiter::tooManyAttempts($key, 5)) {
            $seconds = RateLimiter::availableIn($key);
            return back()->with('error', "Terlalu banyak ulasan. Silakan coba lagi dalam {$seconds} detik.");
        }

        $validated = $request->validate([
            'reviewable_type' => 'required|in:catalog,promotion',
            'reviewable_id' => 'required|integer',
            'reviewer_name' => 'required|string|max:100|min:2',
            'reviewer_email' => 'nullable|email|max:255',
            'reviewer_phone' => 'nullable|string|max:20',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ], [
            'reviewer_name.required' => 'Nama wajib diisi.',
            'reviewer_name.min' => 'Nama minimal 2 karakter.',
            'reviewer_name.max' => 'Nama maksimal 100 karakter.',
            'reviewer_email.email' => 'Format email tidak valid.',
            'rating.required' => 'Rating wajib dipilih.',
            'rating.min' => 'Rating minimal 1 bintang.',
            'rating.max' => 'Rating maksimal 5 bintang.',
            'comment.max' => 'Komentar maksimal 1000 karakter.',
        ]);

        // Resolve the reviewable model
        $reviewableModel = match($validated['reviewable_type']) {
            'catalog' => Catalog::findOrFail($validated['reviewable_id']),
            'promotion' => Promotion::findOrFail($validated['reviewable_id']),
            default => abort(400, 'Invalid reviewable type'),
        };

        // Check for duplicate reviews (same email/IP within 24 hours for same item)
        $existingReview = Review::where('reviewable_type', get_class($reviewableModel))
            ->where('reviewable_id', $reviewableModel->id)
            ->where(function ($query) use ($request, $validated) {
                $query->where('ip_address', $request->ip());
                if (!empty($validated['reviewer_email'])) {
                    $query->orWhere('reviewer_email', $validated['reviewer_email']);
                }
            })
            ->where('created_at', '>=', now()->subHours(24))
            ->first();

        if ($existingReview) {
            return back()->with('error', 'Anda sudah memberikan ulasan untuk item ini dalam 24 jam terakhir.');
        }

        // Create the review
        $review = new Review([
            'reviewer_name' => $validated['reviewer_name'],
            'reviewer_email' => $validated['reviewer_email'] ?? null,
            'reviewer_phone' => $validated['reviewer_phone'] ?? null,
            'rating' => $validated['rating'],
            'comment' => $validated['comment'] ?? null,
            'status' => Review::STATUS_PENDING,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        $reviewableModel->reviews()->save($review);

        RateLimiter::hit($key, 3600); // 1 hour

        return back()->with('success', 'Terima kasih! Ulasan Anda sedang ditinjau dan akan segera ditampilkan.');
    }

    /**
     * Mark a review as helpful (AJAX).
     */
    public function helpful(Request $request, Review $review)
    {
        $key = 'helpful:' . $review->id . ':' . $request->ip();
        
        if (RateLimiter::tooManyAttempts($key, 1)) {
            return response()->json(['error' => 'Anda sudah memberikan vote.'], 429);
        }

        $review->increment('helpful_count');
        RateLimiter::hit($key, 86400 * 30); // 30 days

        return response()->json(['success' => true, 'count' => $review->helpful_count]);
    }
}
