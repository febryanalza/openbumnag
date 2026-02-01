<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class NewsController extends Controller
{
    protected $statuses = [
        'draft' => 'Draft',
        'published' => 'Published',
        'archived' => 'Archived',
    ];

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = News::with(['category', 'user']);

        // Filter by trashed
        if ($request->filled('trashed') && $request->trashed === 'only') {
            $query->onlyTrashed();
        }

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('excerpt', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%");
            });
        }

        // Filter by status
        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        // Filter by category
        if ($request->filled('category') && $request->category !== 'all') {
            $query->where('category_id', $request->category);
        }

        // Filter by featured
        if ($request->filled('featured')) {
            $query->where('is_featured', $request->featured === 'yes');
        }

        // Sorting
        $sortField = $request->get('sort', 'created_at');
        $sortDirection = $request->get('direction', 'desc');
        $allowedSorts = ['title', 'status', 'views', 'published_at', 'created_at'];
        
        if (in_array($sortField, $allowedSorts)) {
            $query->orderBy($sortField, $sortDirection);
        } else {
            $query->latest();
        }

        $news = $query->paginate(15)->withQueryString();

        // Stats
        $stats = [
            'total' => News::count(),
            'published' => News::where('status', 'published')->count(),
            'draft' => News::where('status', 'draft')->count(),
            'trashed' => News::onlyTrashed()->count(),
        ];

        $categories = Category::where('type', 'news')->orWhereNull('type')->orderBy('name')->get();

        return view('admin.news.index', compact('news', 'stats', 'categories'))
            ->with('statuses', $this->statuses);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::where('type', 'news')->orWhereNull('type')->orderBy('name')->get();
        return view('admin.news.create', compact('categories'))
            ->with('statuses', $this->statuses);
    }

    /**
     * Upload image from TinyMCE editor.
     */
    public function uploadImage(Request $request)
    {
        $request->validate([
            'file' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:5120', // 5MB max
        ]);

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            
            // Generate unique filename
            $filename = 'content_' . time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
            
            // Store in news/content folder
            $path = $file->storeAs('news/content', $filename, 'public');
            
            // Return URL for TinyMCE
            return response()->json([
                'location' => Storage::url($path)
            ]);
        }

        return response()->json([
            'error' => 'No file uploaded'
        ], 400);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:news,slug',
            'category_id' => 'nullable|exists:categories,id',
            'excerpt' => 'nullable|string|max:500',
            'content' => 'required|string',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'status' => 'required|in:draft,published,archived',
            'is_featured' => 'boolean',
            'published_at' => 'nullable|date',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'meta_keywords' => 'nullable|string|max:500',
        ]);

        // Handle featured image upload
        if ($request->hasFile('featured_image')) {
            $validated['featured_image'] = $request->file('featured_image')->store('news', 'public');
        }

        // Set defaults
        $validated['is_featured'] = $request->boolean('is_featured');
        $validated['user_id'] = Auth::id();

        // Auto-set published_at if publishing
        if ($validated['status'] === 'published' && empty($validated['published_at'])) {
            $validated['published_at'] = now();
        }

        // Generate slug if empty
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['title']);
        }

        News::create($validated);

        return redirect()->route('admin.news.index')
            ->with('success', 'Berita berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(News $news)
    {
        $news->load(['category', 'user']);
        return view('admin.news.show', compact('news'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(News $news)
    {
        $categories = Category::where('type', 'news')->orWhereNull('type')->orderBy('name')->get();
        return view('admin.news.edit', compact('news', 'categories'))
            ->with('statuses', $this->statuses);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, News $news)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:news,slug,' . $news->id,
            'category_id' => 'nullable|exists:categories,id',
            'excerpt' => 'nullable|string|max:500',
            'content' => 'required|string',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'status' => 'required|in:draft,published,archived',
            'is_featured' => 'boolean',
            'published_at' => 'nullable|date',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'meta_keywords' => 'nullable|string|max:500',
        ]);

        // Handle featured image
        if ($request->hasFile('featured_image')) {
            // Delete old image
            if ($news->featured_image) {
                Storage::disk('public')->delete($news->featured_image);
            }
            $validated['featured_image'] = $request->file('featured_image')->store('news', 'public');
        } elseif ($request->boolean('remove_featured_image')) {
            if ($news->featured_image) {
                Storage::disk('public')->delete($news->featured_image);
            }
            $validated['featured_image'] = null;
        }

        $validated['is_featured'] = $request->boolean('is_featured');

        // Auto-set published_at if publishing for first time
        if ($validated['status'] === 'published' && $news->status !== 'published' && empty($validated['published_at'])) {
            $validated['published_at'] = now();
        }

        $news->update($validated);

        return redirect()->route('admin.news.index')
            ->with('success', 'Berita berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage (soft delete).
     */
    public function destroy(News $news)
    {
        $news->delete();

        return redirect()->route('admin.news.index')
            ->with('success', 'Berita berhasil dipindahkan ke sampah.');
    }

    /**
     * Restore a soft-deleted resource.
     */
    public function restore($id)
    {
        $news = News::onlyTrashed()->findOrFail($id);
        $news->restore();

        return redirect()->route('admin.news.index')
            ->with('success', 'Berita berhasil dipulihkan.');
    }

    /**
     * Force delete a resource.
     */
    public function forceDelete($id)
    {
        $news = News::onlyTrashed()->findOrFail($id);

        // Delete images
        if ($news->featured_image) {
            Storage::disk('public')->delete($news->featured_image);
        }

        $news->forceDelete();

        return redirect()->route('admin.news.index')
            ->with('success', 'Berita berhasil dihapus permanen.');
    }

    /**
     * Bulk action handler.
     */
    public function bulkAction(Request $request)
    {
        $request->validate([
            'action' => 'required|in:delete,restore,force_delete,publish,archive,feature,unfeature',
            'ids' => 'required|array',
            'ids.*' => 'integer',
        ]);

        $action = $request->action;
        $ids = $request->ids;
        $count = 0;

        switch ($action) {
            case 'delete':
                $count = News::whereIn('id', $ids)->count();
                News::whereIn('id', $ids)->delete();
                $message = "{$count} berita dipindahkan ke sampah.";
                break;

            case 'restore':
                $count = News::onlyTrashed()->whereIn('id', $ids)->count();
                News::onlyTrashed()->whereIn('id', $ids)->restore();
                $message = "{$count} berita berhasil dipulihkan.";
                break;

            case 'force_delete':
                $newsItems = News::onlyTrashed()->whereIn('id', $ids)->get();
                foreach ($newsItems as $item) {
                    if ($item->featured_image) {
                        Storage::disk('public')->delete($item->featured_image);
                    }
                    $item->forceDelete();
                    $count++;
                }
                $message = "{$count} berita dihapus permanen.";
                break;

            case 'publish':
                $count = News::whereIn('id', $ids)->update([
                    'status' => 'published',
                    'published_at' => now(),
                ]);
                $message = "{$count} berita berhasil dipublikasikan.";
                break;

            case 'archive':
                $count = News::whereIn('id', $ids)->update(['status' => 'archived']);
                $message = "{$count} berita berhasil diarsipkan.";
                break;

            case 'feature':
                $count = News::whereIn('id', $ids)->update(['is_featured' => true]);
                $message = "{$count} berita ditandai sebagai unggulan.";
                break;

            case 'unfeature':
                $count = News::whereIn('id', $ids)->update(['is_featured' => false]);
                $message = "{$count} berita dihapus dari unggulan.";
                break;

            default:
                return back()->with('error', 'Aksi tidak valid.');
        }

        return back()->with('success', $message);
    }
}
