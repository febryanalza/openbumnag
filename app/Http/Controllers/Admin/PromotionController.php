<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Promotion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PromotionController extends Controller
{
    protected $statuses = [
        'draft' => 'Draft',
        'active' => 'Aktif',
        'expired' => 'Kadaluarsa',
        'archived' => 'Diarsipkan',
    ];

    protected $promotionTypes = [
        'product' => 'Produk',
        'service' => 'Jasa',
        'event' => 'Event',
        'package' => 'Paket',
    ];

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Promotion::with(['category', 'user']);

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
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('location', 'like', "%{$search}%");
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

        // Filter by promotion type
        if ($request->filled('type') && $request->type !== 'all') {
            $query->where('promotion_type', $request->type);
        }

        // Filter by featured
        if ($request->filled('featured')) {
            $query->where('is_featured', $request->featured === 'yes');
        }

        // Sorting
        $sortField = $request->get('sort', 'created_at');
        $sortDirection = $request->get('direction', 'desc');
        $allowedSorts = ['title', 'status', 'views', 'start_date', 'end_date', 'created_at', 'discount_percentage'];
        
        if (in_array($sortField, $allowedSorts)) {
            $query->orderBy($sortField, $sortDirection);
        } else {
            $query->latest();
        }

        $promotions = $query->paginate(15)->withQueryString();

        // Stats
        $stats = [
            'total' => Promotion::count(),
            'active' => Promotion::where('status', 'active')->count(),
            'expired' => Promotion::where('status', 'expired')
                ->orWhere(function($q) {
                    $q->whereNotNull('end_date')->where('end_date', '<', now());
                })->count(),
            'trashed' => Promotion::onlyTrashed()->count(),
        ];

        $categories = Category::where('type', 'promotion')->orWhereNull('type')->orderBy('name')->get();

        return view('admin.promotions.index', compact('promotions', 'stats', 'categories'))
            ->with('statuses', $this->statuses)
            ->with('promotionTypes', $this->promotionTypes);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::where('type', 'promotion')->orWhereNull('type')->orderBy('name')->get();
        return view('admin.promotions.create', compact('categories'))
            ->with('statuses', $this->statuses)
            ->with('promotionTypes', $this->promotionTypes);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:promotions,slug',
            'category_id' => 'nullable|exists:categories,id',
            'excerpt' => 'nullable|string|max:500',
            'description' => 'required|string',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'images' => 'nullable|array|max:10',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'original_price' => 'nullable|numeric|min:0',
            'discount_price' => 'nullable|numeric|min:0',
            'discount_percentage' => 'nullable|integer|min:0|max:100',
            'promotion_type' => 'required|in:product,service,event,package',
            'contact_person' => 'nullable|string|max:255',
            'contact_phone' => 'nullable|string|max:50',
            'contact_email' => 'nullable|email|max:255',
            'location' => 'nullable|string|max:500',
            'terms_conditions' => 'nullable|string',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'status' => 'required|in:draft,active,expired,archived',
            'is_featured' => 'boolean',
        ]);

        // Handle featured image upload
        if ($request->hasFile('featured_image')) {
            $validated['featured_image'] = $request->file('featured_image')->store('promotions', 'public');
        }

        // Handle multiple gallery images
        if ($request->hasFile('images')) {
            $uploadedImages = [];
            foreach ($request->file('images') as $image) {
                $uploadedImages[] = $image->store('promotions/gallery', 'public');
            }
            $validated['images'] = $uploadedImages;
        }

        // Set defaults
        $validated['is_featured'] = $request->boolean('is_featured');
        $validated['user_id'] = Auth::id();

        // Generate slug if empty
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['title']);
        }

        // Auto-calculate discount percentage if both prices provided
        if (!empty($validated['original_price']) && !empty($validated['discount_price']) && $validated['original_price'] > 0) {
            $validated['discount_percentage'] = round((($validated['original_price'] - $validated['discount_price']) / $validated['original_price']) * 100);
        } else {
            $validated['discount_percentage'] = null;
        }

        Promotion::create($validated);

        return redirect()->route('admin.promotions.index')
            ->with('success', 'Promosi berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Promotion $promotion)
    {
        $promotion->load(['category', 'user']);
        return view('admin.promotions.show', compact('promotion'))
            ->with('statuses', $this->statuses)
            ->with('promotionTypes', $this->promotionTypes);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Promotion $promotion)
    {
        $categories = Category::where('type', 'promotion')->orWhereNull('type')->orderBy('name')->get();
        return view('admin.promotions.edit', compact('promotion', 'categories'))
            ->with('statuses', $this->statuses)
            ->with('promotionTypes', $this->promotionTypes);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Promotion $promotion)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:promotions,slug,' . $promotion->id,
            'category_id' => 'nullable|exists:categories,id',
            'excerpt' => 'nullable|string|max:500',
            'description' => 'required|string',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'images' => 'nullable|array|max:10',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'remove_gallery_images' => 'nullable|array',
            'remove_gallery_images.*' => 'string',
            'original_price' => 'nullable|numeric|min:0',
            'discount_price' => 'nullable|numeric|min:0',
            'discount_percentage' => 'nullable|integer|min:0|max:100',
            'promotion_type' => 'required|in:product,service,event,package',
            'contact_person' => 'nullable|string|max:255',
            'contact_phone' => 'nullable|string|max:50',
            'contact_email' => 'nullable|email|max:255',
            'location' => 'nullable|string|max:500',
            'terms_conditions' => 'nullable|string',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'status' => 'required|in:draft,active,expired,archived',
            'is_featured' => 'boolean',
        ]);

        // Handle featured image
        if ($request->hasFile('featured_image')) {
            // Delete old image
            if ($promotion->featured_image) {
                Storage::disk('public')->delete($promotion->featured_image);
            }
            $validated['featured_image'] = $request->file('featured_image')->store('promotions', 'public');
        } elseif ($request->boolean('remove_featured_image')) {
            if ($promotion->featured_image) {
                Storage::disk('public')->delete($promotion->featured_image);
            }
            $validated['featured_image'] = null;
        }

        // Handle gallery images removal
        $currentImages = $promotion->images ?? [];
        $imagesToRemove = $request->input('remove_gallery_images', []);
        
        if (!empty($imagesToRemove)) {
            foreach ($imagesToRemove as $imagePath) {
                Storage::disk('public')->delete($imagePath);
                $currentImages = array_filter($currentImages, fn($img) => $img !== $imagePath);
            }
        }

        // Handle new gallery images upload
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $currentImages[] = $image->store('promotions/gallery', 'public');
            }
        }

        $validated['images'] = array_values($currentImages); // Re-index array
        unset($validated['remove_gallery_images']);

        $validated['is_featured'] = $request->boolean('is_featured');

        // Auto-calculate discount percentage if both prices provided
        if (!empty($validated['original_price']) && !empty($validated['discount_price']) && $validated['original_price'] > 0) {
            $validated['discount_percentage'] = round((($validated['original_price'] - $validated['discount_price']) / $validated['original_price']) * 100);
        } else {
            $validated['discount_percentage'] = null;
        }

        $promotion->update($validated);

        return redirect()->route('admin.promotions.index')
            ->with('success', 'Promosi berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage (soft delete).
     */
    public function destroy(Promotion $promotion)
    {
        $promotion->delete();

        return redirect()->route('admin.promotions.index')
            ->with('success', 'Promosi berhasil dipindahkan ke sampah.');
    }

    /**
     * Restore a soft-deleted resource.
     */
    public function restore($id)
    {
        $promotion = Promotion::onlyTrashed()->findOrFail($id);
        $promotion->restore();

        return redirect()->route('admin.promotions.index')
            ->with('success', 'Promosi berhasil dipulihkan.');
    }

    /**
     * Force delete a resource.
     */
    public function forceDelete($id)
    {
        $promotion = Promotion::onlyTrashed()->findOrFail($id);

        // Delete images
        if ($promotion->featured_image) {
            Storage::disk('public')->delete($promotion->featured_image);
        }

        $promotion->forceDelete();

        return redirect()->route('admin.promotions.index')
            ->with('success', 'Promosi berhasil dihapus permanen.');
    }

    /**
     * Bulk action handler.
     */
    public function bulkAction(Request $request)
    {
        $request->validate([
            'action' => 'required|in:delete,restore,force_delete,activate,archive,expire,feature,unfeature',
            'ids' => 'required|array',
            'ids.*' => 'integer',
        ]);

        $action = $request->action;
        $ids = $request->ids;
        $count = 0;

        switch ($action) {
            case 'delete':
                $count = Promotion::whereIn('id', $ids)->count();
                Promotion::whereIn('id', $ids)->delete();
                $message = "{$count} promosi dipindahkan ke sampah.";
                break;

            case 'restore':
                $count = Promotion::onlyTrashed()->whereIn('id', $ids)->count();
                Promotion::onlyTrashed()->whereIn('id', $ids)->restore();
                $message = "{$count} promosi berhasil dipulihkan.";
                break;

            case 'force_delete':
                $promotions = Promotion::onlyTrashed()->whereIn('id', $ids)->get();
                foreach ($promotions as $promo) {
                    if ($promo->featured_image) {
                        Storage::disk('public')->delete($promo->featured_image);
                    }
                    $promo->forceDelete();
                    $count++;
                }
                $message = "{$count} promosi dihapus permanen.";
                break;

            case 'activate':
                $count = Promotion::whereIn('id', $ids)->update(['status' => 'active']);
                $message = "{$count} promosi berhasil diaktifkan.";
                break;

            case 'archive':
                $count = Promotion::whereIn('id', $ids)->update(['status' => 'archived']);
                $message = "{$count} promosi berhasil diarsipkan.";
                break;

            case 'expire':
                $count = Promotion::whereIn('id', $ids)->update(['status' => 'expired']);
                $message = "{$count} promosi ditandai kadaluarsa.";
                break;

            case 'feature':
                $count = Promotion::whereIn('id', $ids)->update(['is_featured' => true]);
                $message = "{$count} promosi ditandai sebagai unggulan.";
                break;

            case 'unfeature':
                $count = Promotion::whereIn('id', $ids)->update(['is_featured' => false]);
                $message = "{$count} promosi dihapus dari unggulan.";
                break;

            default:
                return back()->with('error', 'Aksi tidak valid.');
        }

        return back()->with('success', $message);
    }
}
