<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class GalleryController extends Controller
{
    protected $fileTypes = [
        'image' => 'Gambar',
        'video' => 'Video',
    ];

    protected $galleryTypes = [
        'gallery' => 'Galeri Umum',
        'event' => 'Kegiatan',
        'activity' => 'Aktivitas',
        'product' => 'Produk',
    ];

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Gallery::with('user');

        // Filter by trashed
        if ($request->filled('trashed') && $request->trashed === 'only') {
            $query->onlyTrashed();
        }

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('album', 'like', "%{$search}%")
                  ->orWhere('photographer', 'like', "%{$search}%")
                  ->orWhere('location', 'like', "%{$search}%");
            });
        }

        // Filter by file type
        if ($request->filled('file_type') && $request->file_type !== 'all') {
            $query->where('file_type', $request->file_type);
        }

        // Filter by type/category
        if ($request->filled('type') && $request->type !== 'all') {
            $query->where('type', $request->type);
        }

        // Filter by album
        if ($request->filled('album') && $request->album !== 'all') {
            $query->where('album', $request->album);
        }

        // Filter by featured
        if ($request->filled('featured')) {
            $query->where('is_featured', $request->featured === 'yes');
        }

        // Sorting
        $sortField = $request->get('sort', 'created_at');
        $sortDirection = $request->get('direction', 'desc');
        $allowedSorts = ['title', 'file_type', 'type', 'album', 'views', 'order', 'created_at', 'taken_date'];
        
        if (in_array($sortField, $allowedSorts)) {
            $query->orderBy($sortField, $sortDirection);
        } else {
            $query->latest();
        }

        $galleries = $query->paginate(20)->withQueryString();

        // Stats
        $stats = [
            'total' => Gallery::count(),
            'images' => Gallery::where('file_type', 'image')->count(),
            'videos' => Gallery::where('file_type', 'video')->count(),
            'trashed' => Gallery::onlyTrashed()->count(),
        ];

        // Get unique albums for filter
        $albums = Gallery::whereNotNull('album')->distinct()->pluck('album');

        return view('admin.galleries.index', compact('galleries', 'stats', 'albums'))
            ->with('fileTypes', $this->fileTypes)
            ->with('galleryTypes', $this->galleryTypes);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $albums = Gallery::whereNotNull('album')->distinct()->pluck('album');
        return view('admin.galleries.create', compact('albums'))
            ->with('fileTypes', $this->fileTypes)
            ->with('galleryTypes', $this->galleryTypes);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:2000',
            'file' => 'required|file|mimes:jpeg,png,jpg,gif,webp,mp4,webm,mov|max:51200', // 50MB max
            'file_type' => 'required|in:image,video',
            'type' => 'required|in:gallery,event,activity,product',
            'album' => 'nullable|string|max:255',
            'new_album' => 'nullable|string|max:255',
            'taken_date' => 'nullable|date',
            'photographer' => 'nullable|string|max:255',
            'location' => 'nullable|string|max:255',
            'is_featured' => 'boolean',
            'order' => 'nullable|integer|min:0',
        ]);

        // Handle file upload
        $file = $request->file('file');
        $validated['file_path'] = $file->store('galleries', 'public');
        $validated['mime_type'] = $file->getMimeType();
        $validated['file_size'] = $file->getSize();

        // Handle new album
        if (!empty($request->new_album)) {
            $validated['album'] = $request->new_album;
        }
        unset($validated['new_album'], $validated['file']);

        // Set defaults
        $validated['is_featured'] = $request->boolean('is_featured');
        $validated['user_id'] = Auth::id();
        $validated['order'] = $validated['order'] ?? 0;

        Gallery::create($validated);

        return redirect()->route('admin.galleries.index')
            ->with('success', 'Media berhasil ditambahkan ke galeri.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Gallery $gallery)
    {
        $gallery->load('user');
        
        // Increment views
        $gallery->increment('views');
        
        return view('admin.galleries.show', compact('gallery'))
            ->with('fileTypes', $this->fileTypes)
            ->with('galleryTypes', $this->galleryTypes);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Gallery $gallery)
    {
        $albums = Gallery::whereNotNull('album')->distinct()->pluck('album');
        return view('admin.galleries.edit', compact('gallery', 'albums'))
            ->with('fileTypes', $this->fileTypes)
            ->with('galleryTypes', $this->galleryTypes);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Gallery $gallery)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:2000',
            'file' => 'nullable|file|mimes:jpeg,png,jpg,gif,webp,mp4,webm,mov|max:51200',
            'file_type' => 'required|in:image,video',
            'type' => 'required|in:gallery,event,activity,product',
            'album' => 'nullable|string|max:255',
            'new_album' => 'nullable|string|max:255',
            'taken_date' => 'nullable|date',
            'photographer' => 'nullable|string|max:255',
            'location' => 'nullable|string|max:255',
            'is_featured' => 'boolean',
            'order' => 'nullable|integer|min:0',
        ]);

        // Handle file upload
        if ($request->hasFile('file')) {
            // Delete old file
            if ($gallery->file_path) {
                Storage::disk('public')->delete($gallery->file_path);
            }
            $file = $request->file('file');
            $validated['file_path'] = $file->store('galleries', 'public');
            $validated['mime_type'] = $file->getMimeType();
            $validated['file_size'] = $file->getSize();
        }
        unset($validated['file']);

        // Handle new album
        if (!empty($request->new_album)) {
            $validated['album'] = $request->new_album;
        }
        unset($validated['new_album']);

        $validated['is_featured'] = $request->boolean('is_featured');
        $validated['order'] = $validated['order'] ?? 0;

        $gallery->update($validated);

        return redirect()->route('admin.galleries.index')
            ->with('success', 'Media galeri berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage (soft delete).
     */
    public function destroy(Gallery $gallery)
    {
        $gallery->delete();

        return redirect()->route('admin.galleries.index')
            ->with('success', 'Media berhasil dipindahkan ke sampah.');
    }

    /**
     * Restore a soft-deleted resource.
     */
    public function restore($id)
    {
        $gallery = Gallery::onlyTrashed()->findOrFail($id);
        $gallery->restore();

        return redirect()->route('admin.galleries.index')
            ->with('success', 'Media berhasil dipulihkan.');
    }

    /**
     * Force delete a resource.
     */
    public function forceDelete($id)
    {
        $gallery = Gallery::onlyTrashed()->findOrFail($id);

        // Delete file
        if ($gallery->file_path) {
            Storage::disk('public')->delete($gallery->file_path);
        }

        $gallery->forceDelete();

        return redirect()->route('admin.galleries.index')
            ->with('success', 'Media berhasil dihapus permanen.');
    }

    /**
     * Bulk action handler.
     */
    public function bulkAction(Request $request)
    {
        $request->validate([
            'action' => 'required|in:delete,restore,force_delete,feature,unfeature',
            'ids' => 'required|array',
            'ids.*' => 'integer',
        ]);

        $action = $request->action;
        $ids = $request->ids;
        $count = 0;

        switch ($action) {
            case 'delete':
                $count = Gallery::whereIn('id', $ids)->count();
                Gallery::whereIn('id', $ids)->delete();
                $message = "{$count} media dipindahkan ke sampah.";
                break;

            case 'restore':
                $count = Gallery::onlyTrashed()->whereIn('id', $ids)->count();
                Gallery::onlyTrashed()->whereIn('id', $ids)->restore();
                $message = "{$count} media berhasil dipulihkan.";
                break;

            case 'force_delete':
                $items = Gallery::onlyTrashed()->whereIn('id', $ids)->get();
                foreach ($items as $item) {
                    if ($item->file_path) {
                        Storage::disk('public')->delete($item->file_path);
                    }
                    $item->forceDelete();
                    $count++;
                }
                $message = "{$count} media dihapus permanen.";
                break;

            case 'feature':
                $count = Gallery::whereIn('id', $ids)->update(['is_featured' => true]);
                $message = "{$count} media ditandai sebagai unggulan.";
                break;

            case 'unfeature':
                $count = Gallery::whereIn('id', $ids)->update(['is_featured' => false]);
                $message = "{$count} media dihapus dari unggulan.";
                break;

            default:
                return back()->with('error', 'Aksi tidak valid.');
        }

        return back()->with('success', $message);
    }

    /**
     * Update order for reordering.
     */
    public function updateOrder(Request $request)
    {
        $request->validate([
            'items' => 'required|array',
            'items.*.id' => 'required|integer|exists:galleries,id',
            'items.*.order' => 'required|integer|min:0',
        ]);

        foreach ($request->items as $item) {
            Gallery::where('id', $item['id'])->update(['order' => $item['order']]);
        }

        return response()->json(['success' => true, 'message' => 'Urutan berhasil diperbarui.']);
    }
}
