<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BumnagProfile;
use App\Models\Catalog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class CatalogController extends Controller
{
    protected $categories = [
        'pertanian' => 'Pertanian',
        'peternakan' => 'Peternakan',
        'perikanan' => 'Perikanan',
        'kerajinan' => 'Kerajinan',
        'kuliner' => 'Kuliner',
        'jasa' => 'Jasa',
        'pariwisata' => 'Pariwisata',
        'lainnya' => 'Lainnya',
    ];

    protected $units = [
        'pcs' => 'Pcs',
        'kg' => 'Kg',
        'gram' => 'Gram',
        'liter' => 'Liter',
        'ml' => 'mL',
        'pack' => 'Pack',
        'box' => 'Box',
        'lusin' => 'Lusin',
        'unit' => 'Unit',
        'paket' => 'Paket',
    ];

    /**
     * Display a listing of catalogs.
     */
    public function index(Request $request)
    {
        $query = Catalog::with('bumnagProfile');

        // Search
        if ($search = $request->get('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('sku', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Filter by BUMNag
        if ($bumnagId = $request->get('bumnag_profile_id')) {
            $query->where('bumnag_profile_id', $bumnagId);
        }

        // Filter by category
        if ($category = $request->get('category')) {
            $query->where('category', $category);
        }

        // Filter by availability
        if ($request->has('availability')) {
            $availability = $request->get('availability');
            if ($availability === 'available') {
                $query->where('is_available', true);
            } elseif ($availability === 'unavailable') {
                $query->where('is_available', false);
            }
        }

        // Filter by featured
        if ($request->has('featured') && $request->get('featured') === '1') {
            $query->where('is_featured', true);
        }

        // Sorting
        $sortField = $request->get('sort', 'created_at');
        $sortDirection = $request->get('direction', 'desc');
        $allowedSortFields = ['name', 'price', 'stock', 'created_at', 'view_count'];
        
        if (in_array($sortField, $allowedSortFields)) {
            $query->orderBy($sortField, $sortDirection);
        }

        $catalogs = $query->paginate(12)->withQueryString();
        $bumnagProfiles = BumnagProfile::active()->orderBy('name')->pluck('name', 'id');
        
        // Stats
        $stats = [
            'total' => Catalog::count(),
            'available' => Catalog::where('is_available', true)->count(),
            'featured' => Catalog::where('is_featured', true)->count(),
            'out_of_stock' => Catalog::where('stock', 0)->count(),
        ];

        return view('admin.catalogs.index', compact('catalogs', 'bumnagProfiles', 'stats') + [
            'categories' => $this->categories,
        ]);
    }

    /**
     * Show the form for creating a new catalog.
     */
    public function create()
    {
        $bumnagProfiles = BumnagProfile::active()->orderBy('name')->pluck('name', 'id');
        
        return view('admin.catalogs.create', [
            'bumnagProfiles' => $bumnagProfiles,
            'categories' => $this->categories,
            'units' => $this->units,
        ]);
    }

    /**
     * Store a newly created catalog.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'bumnag_profile_id' => ['required', 'exists:bumnag_profiles,id'],
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'price' => ['nullable', 'numeric', 'min:0'],
            'unit' => ['nullable', 'string', 'max:50'],
            'stock' => ['required', 'integer', 'min:0'],
            'sku' => ['nullable', 'string', 'max:100', 'unique:catalogs,sku'],
            'category' => ['nullable', 'string', 'max:100'],
            'featured_image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
            'images' => ['nullable', 'array', 'max:10'],
            'images.*' => ['image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
            'is_available' => ['boolean'],
            'is_featured' => ['boolean'],
            'specifications' => ['nullable', 'string'],
        ], [
            'bumnag_profile_id.required' => 'Pilih BUMNag.',
            'name.required' => 'Nama produk wajib diisi.',
            'stock.required' => 'Stok wajib diisi.',
            'featured_image.image' => 'File harus berupa gambar.',
            'featured_image.max' => 'Ukuran gambar maksimal 2MB.',
            'images.max' => 'Maksimal 10 gambar galeri.',
            'images.*.image' => 'Semua file harus berupa gambar.',
            'images.*.max' => 'Ukuran setiap gambar maksimal 2MB.',
        ]);

        // Handle featured image upload
        if ($request->hasFile('featured_image')) {
            $validated['featured_image'] = $request->file('featured_image')->store('catalogs', 'public');
        }

        // Handle multiple gallery images
        if ($request->hasFile('images')) {
            $uploadedImages = [];
            foreach ($request->file('images') as $image) {
                $uploadedImages[] = $image->store('catalogs/gallery', 'public');
            }
            $validated['images'] = $uploadedImages;
        }

        $validated['is_available'] = $request->boolean('is_available');
        $validated['is_featured'] = $request->boolean('is_featured');

        // Parse specifications if JSON
        if (!empty($validated['specifications'])) {
            $specs = json_decode($validated['specifications'], true);
            $validated['specifications'] = is_array($specs) ? $specs : null;
        }

        $catalog = Catalog::create($validated);

        return redirect()
            ->route('admin.catalogs.index')
            ->with('success', "Produk {$catalog->name} berhasil ditambahkan.");
    }

    /**
     * Display the specified catalog.
     */
    public function show(Catalog $catalog)
    {
        $catalog->load('bumnagProfile');
        return view('admin.catalogs.show', compact('catalog') + [
            'categories' => $this->categories,
            'units' => $this->units,
        ]);
    }

    /**
     * Show the form for editing the specified catalog.
     */
    public function edit(Catalog $catalog)
    {
        $bumnagProfiles = BumnagProfile::active()->orderBy('name')->pluck('name', 'id');
        
        return view('admin.catalogs.edit', compact('catalog') + [
            'bumnagProfiles' => $bumnagProfiles,
            'categories' => $this->categories,
            'units' => $this->units,
        ]);
    }

    /**
     * Update the specified catalog.
     */
    public function update(Request $request, Catalog $catalog)
    {
        $validated = $request->validate([
            'bumnag_profile_id' => ['required', 'exists:bumnag_profiles,id'],
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', Rule::unique('catalogs')->ignore($catalog->id)],
            'description' => ['nullable', 'string'],
            'price' => ['nullable', 'numeric', 'min:0'],
            'unit' => ['nullable', 'string', 'max:50'],
            'stock' => ['required', 'integer', 'min:0'],
            'sku' => ['nullable', 'string', 'max:100', Rule::unique('catalogs')->ignore($catalog->id)],
            'category' => ['nullable', 'string', 'max:100'],
            'featured_image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
            'images' => ['nullable', 'array', 'max:10'],
            'images.*' => ['image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
            'remove_gallery_images' => ['nullable', 'array'],
            'remove_gallery_images.*' => ['string'],
            'is_available' => ['boolean'],
            'is_featured' => ['boolean'],
            'specifications' => ['nullable', 'string'],
            'remove_image' => ['boolean'],
        ]);

        // Handle featured image
        if ($request->boolean('remove_image') && $catalog->featured_image) {
            Storage::disk('public')->delete($catalog->featured_image);
            $validated['featured_image'] = null;
        } elseif ($request->hasFile('featured_image')) {
            if ($catalog->featured_image) {
                Storage::disk('public')->delete($catalog->featured_image);
            }
            $validated['featured_image'] = $request->file('featured_image')->store('catalogs', 'public');
        } else {
            unset($validated['featured_image']);
        }

        // Handle gallery images removal
        $currentImages = $catalog->images ?? [];
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
                $currentImages[] = $image->store('catalogs/gallery', 'public');
            }
        }

        $validated['images'] = array_values($currentImages); // Re-index array

        $validated['is_available'] = $request->boolean('is_available');
        $validated['is_featured'] = $request->boolean('is_featured');
        unset($validated['remove_image']);
        unset($validated['remove_gallery_images']);

        // Parse specifications if JSON
        if (!empty($validated['specifications'])) {
            $specs = json_decode($validated['specifications'], true);
            $validated['specifications'] = is_array($specs) ? $specs : null;
        }

        $catalog->update($validated);

        return redirect()
            ->route('admin.catalogs.index')
            ->with('success', "Produk {$catalog->name} berhasil diperbarui.");
    }

    /**
     * Remove the specified catalog.
     */
    public function destroy(Catalog $catalog)
    {
        $name = $catalog->name;

        // Delete associated image
        if ($catalog->featured_image) {
            Storage::disk('public')->delete($catalog->featured_image);
        }
        if ($catalog->images) {
            foreach ($catalog->images as $image) {
                Storage::disk('public')->delete($image);
            }
        }

        $catalog->delete();

        return redirect()
            ->route('admin.catalogs.index')
            ->with('success', "Produk {$name} berhasil dihapus.");
    }

    /**
     * Handle bulk actions.
     */
    public function bulkAction(Request $request)
    {
        $request->validate([
            'action' => ['required', 'in:delete,make_available,make_unavailable,make_featured,remove_featured'],
            'ids' => ['required', 'array'],
            'ids.*' => ['integer'],
        ]);

        $ids = $request->input('ids');
        $action = $request->input('action');
        $count = 0;

        switch ($action) {
            case 'delete':
                $catalogs = Catalog::whereIn('id', $ids)->get();
                foreach ($catalogs as $catalog) {
                    if ($catalog->featured_image) {
                        Storage::disk('public')->delete($catalog->featured_image);
                    }
                    $catalog->delete();
                    $count++;
                }
                $message = "{$count} produk berhasil dihapus.";
                break;
            case 'make_available':
                $count = Catalog::whereIn('id', $ids)->update(['is_available' => true]);
                $message = "{$count} produk berhasil diaktifkan.";
                break;
            case 'make_unavailable':
                $count = Catalog::whereIn('id', $ids)->update(['is_available' => false]);
                $message = "{$count} produk berhasil dinonaktifkan.";
                break;
            case 'make_featured':
                $count = Catalog::whereIn('id', $ids)->update(['is_featured' => true]);
                $message = "{$count} produk dijadikan unggulan.";
                break;
            case 'remove_featured':
                $count = Catalog::whereIn('id', $ids)->update(['is_featured' => false]);
                $message = "{$count} produk dihapus dari unggulan.";
                break;
        }

        return back()->with('success', $message);
    }

    /**
     * Update stock quickly.
     */
    public function updateStock(Request $request, Catalog $catalog)
    {
        $validated = $request->validate([
            'stock' => ['required', 'integer', 'min:0'],
        ]);

        $catalog->update(['stock' => $validated['stock']]);

        return back()->with('success', "Stok {$catalog->name} berhasil diperbarui.");
    }
}
