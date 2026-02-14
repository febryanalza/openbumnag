<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class ReviewController extends Controller
{
    /**
     * Display a listing of reviews.
     */
    public function index(Request $request): View
    {
        $query = Review::with('reviewable')
            ->latest();

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by type
        if ($request->filled('type')) {
            $type = $request->type === 'catalog' ? 'App\\Models\\Catalog' : 'App\\Models\\Promotion';
            $query->where('reviewable_type', $type);
        }

        // Filter by rating
        if ($request->filled('rating')) {
            $query->where('rating', $request->rating);
        }

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('reviewer_name', 'like', "%{$search}%")
                  ->orWhere('reviewer_email', 'like', "%{$search}%")
                  ->orWhere('comment', 'like', "%{$search}%");
            });
        }

        $reviews = $query->paginate(15)
            ->withQueryString();

        // Stats
        $stats = [
            'total' => Review::count(),
            'pending' => Review::pending()->count(),
            'approved' => Review::approved()->count(),
            'rejected' => Review::rejected()->count(),
        ];

        return view('admin.reviews.index', compact('reviews', 'stats'));
    }

    /**
     * Show review details.
     */
    public function show(Review $review): View
    {
        $review->load('reviewable');
        return view('admin.reviews.show', compact('review'));
    }

    /**
     * Approve a review.
     */
    public function approve(Review $review): RedirectResponse
    {
        $review->update([
            'status' => Review::STATUS_APPROVED,
        ]);

        return back()->with('success', 'Ulasan berhasil disetujui.');
    }

    /**
     * Reject a review.
     */
    public function reject(Request $request, Review $review): RedirectResponse
    {
        $validated = $request->validate([
            'admin_notes' => 'nullable|string|max:500',
        ]);

        $review->update([
            'status' => Review::STATUS_REJECTED,
            'admin_notes' => $validated['admin_notes'] ?? null,
        ]);

        return back()->with('success', 'Ulasan berhasil ditolak.');
    }

    /**
     * Delete a review.
     */
    public function destroy(Review $review): RedirectResponse
    {
        $review->delete();

        return redirect()->route('admin.reviews.index')
            ->with('success', 'Ulasan berhasil dihapus.');
    }

    /**
     * Bulk approve reviews.
     */
    public function bulkApprove(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'review_ids' => 'required|array',
            'review_ids.*' => 'exists:reviews,id',
        ]);

        Review::whereIn('id', $validated['review_ids'])
            ->update(['status' => Review::STATUS_APPROVED]);

        return back()->with('success', count($validated['review_ids']) . ' ulasan berhasil disetujui.');
    }

    /**
     * Bulk reject reviews.
     */
    public function bulkReject(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'review_ids' => 'required|array',
            'review_ids.*' => 'exists:reviews,id',
        ]);

        Review::whereIn('id', $validated['review_ids'])
            ->update(['status' => Review::STATUS_REJECTED]);

        return back()->with('success', count($validated['review_ids']) . ' ulasan berhasil ditolak.');
    }
}
