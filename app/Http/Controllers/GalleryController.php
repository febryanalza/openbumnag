<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use Illuminate\Http\Request;
use Illuminate\View\View;

class GalleryController extends Controller
{
    /**
     * Display gallery list page.
     */
    public function index(Request $request): View
    {
        $query = Gallery::query();

        // Filter by type (image/video)
        if ($request->has('type') && !empty($request->input('type'))) {
            $query->where('file_type', $request->input('type'));
        }

        // Filter by album
        if ($request->has('album') && !empty($request->input('album'))) {
            $query->where('album', $request->input('album'));
        }

        // Search by title or description
        if ($request->has('search') && !empty($request->input('search'))) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('album', 'like', "%{$search}%");
            });
        }

        // Get galleries ordered by taken_date and creation date
        $galleries = $query->orderBy('taken_date', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate(24);

        // Get available albums for filter
        $albums = Gallery::select('album')
            ->whereNotNull('album')
            ->distinct()
            ->pluck('album')
            ->sort();

        return view('gallery.index', compact('galleries', 'albums'));
    }

    /**
     * Display single gallery detail.
     */
    public function show(int $id): View
    {
        $gallery = Gallery::with('user')
            ->findOrFail($id);

        // Increment views
        $gallery->increment('views');

        // Get related galleries from same album
        $relatedGalleries = Gallery::where('album', $gallery->album)
            ->where('id', '!=', $gallery->id)
            ->whereNotNull('album')
            ->orderBy('taken_date', 'desc')
            ->take(6)
            ->get();

        return view('gallery.show', compact('gallery', 'relatedGalleries'));
    }
}
