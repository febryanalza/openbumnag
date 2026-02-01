<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
    /**
     * Category types available
     */
    protected $categoryTypes = [
        'general' => 'Umum',
        'news' => 'Berita',
        'report' => 'Laporan',
        'promotion' => 'Promosi',
    ];

    /**
     * Display a listing of categories.
     */
    public function index(Request $request)
    {
        $query = Category::query();

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('slug', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Filter by type
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        // Filter by status
        if ($request->filled('status')) {
            if ($request->status === 'active') {
                $query->where('is_active', true);
            } elseif ($request->status === 'inactive') {
                $query->where('is_active', false);
            }
        }

        // Filter trashed
        if ($request->filled('trashed')) {
            if ($request->trashed === 'only') {
                $query->onlyTrashed();
            } elseif ($request->trashed === 'with') {
                $query->withTrashed();
            }
        }

        // Sorting
        $sortField = $request->get('sort', 'order');
        $sortDirection = $request->get('direction', 'asc');
        $query->orderBy($sortField, $sortDirection);

        // Get statistics
        $stats = [
            'total' => Category::count(),
            'active' => Category::where('is_active', true)->count(),
            'inactive' => Category::where('is_active', false)->count(),
            'trashed' => Category::onlyTrashed()->count(),
        ];

        // Get unique types for filter
        $types = $this->categoryTypes;

        $categories = $query->paginate(15)->withQueryString();

        return view('admin.categories.index', compact('categories', 'stats', 'types'));
    }

    /**
     * Show the form for creating a new category.
     */
    public function create()
    {
        $types = $this->categoryTypes;
        return view('admin.categories.create', compact('types'));
    }

    /**
     * Store a newly created category.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:categories,slug',
            'description' => 'nullable|string',
            'type' => 'required|string|in:general,news,report,promotion',
            'icon' => 'nullable|string|max:255',
            'color' => 'nullable|string|max:50',
            'is_active' => 'boolean',
            'order' => 'nullable|integer|min:0',
        ]);

        // Generate slug if not provided
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        // Set defaults
        $validated['is_active'] = $request->boolean('is_active', true);
        $validated['order'] = $validated['order'] ?? 0;

        Category::create($validated);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Kategori berhasil ditambahkan.');
    }

    /**
     * Display the specified category.
     */
    public function show(Category $category)
    {
        $category->loadCount(['news', 'reports', 'promotions']);
        return view('admin.categories.show', compact('category'));
    }

    /**
     * Show the form for editing the specified category.
     */
    public function edit(Category $category)
    {
        $types = $this->categoryTypes;
        return view('admin.categories.edit', compact('category', 'types'));
    }

    /**
     * Update the specified category.
     */
    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => ['nullable', 'string', 'max:255', Rule::unique('categories', 'slug')->ignore($category->id)],
            'description' => 'nullable|string',
            'type' => 'required|string|in:general,news,report,promotion',
            'icon' => 'nullable|string|max:255',
            'color' => 'nullable|string|max:50',
            'is_active' => 'boolean',
            'order' => 'nullable|integer|min:0',
        ]);

        // Generate slug if not provided
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        // Set defaults
        $validated['is_active'] = $request->boolean('is_active', true);

        $category->update($validated);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Kategori berhasil diperbarui.');
    }

    /**
     * Soft delete the specified category.
     */
    public function destroy(Category $category)
    {
        // Check if category has related items
        $newsCount = $category->news()->count();
        $reportsCount = $category->reports()->count();
        $promotionsCount = $category->promotions()->count();

        if ($newsCount > 0 || $reportsCount > 0 || $promotionsCount > 0) {
            return back()->with('error', "Kategori tidak dapat dihapus karena masih memiliki {$newsCount} berita, {$reportsCount} laporan, dan {$promotionsCount} promosi terkait.");
        }

        $category->delete();
        return redirect()->route('admin.categories.index')
            ->with('success', 'Kategori berhasil dihapus.');
    }

    /**
     * Restore a soft-deleted category.
     */
    public function restore($id)
    {
        $category = Category::onlyTrashed()->findOrFail($id);
        $category->restore();

        return redirect()->route('admin.categories.index')
            ->with('success', 'Kategori berhasil dipulihkan.');
    }

    /**
     * Permanently delete the specified category.
     */
    public function forceDelete($id)
    {
        $category = Category::onlyTrashed()->findOrFail($id);
        $category->forceDelete();

        return redirect()->route('admin.categories.index')
            ->with('success', 'Kategori berhasil dihapus permanen.');
    }

    /**
     * Handle bulk actions.
     */
    public function bulkAction(Request $request)
    {
        $request->validate([
            'action' => 'required|string|in:delete,restore,force_delete,activate,deactivate',
            'ids' => 'required|array',
            'ids.*' => 'integer',
        ]);

        $action = $request->action;
        $ids = $request->ids;
        $count = 0;

        switch ($action) {
            case 'delete':
                $count = Category::whereIn('id', $ids)->delete();
                $message = "{$count} kategori berhasil dihapus.";
                break;

            case 'restore':
                $count = Category::onlyTrashed()->whereIn('id', $ids)->restore();
                $message = "{$count} kategori berhasil dipulihkan.";
                break;

            case 'force_delete':
                $count = Category::onlyTrashed()->whereIn('id', $ids)->forceDelete();
                $message = "{$count} kategori berhasil dihapus permanen.";
                break;

            case 'activate':
                $count = Category::whereIn('id', $ids)->update(['is_active' => true]);
                $message = "{$count} kategori berhasil diaktifkan.";
                break;

            case 'deactivate':
                $count = Category::whereIn('id', $ids)->update(['is_active' => false]);
                $message = "{$count} kategori berhasil dinonaktifkan.";
                break;

            default:
                return back()->with('error', 'Aksi tidak valid.');
        }

        return back()->with('success', $message);
    }

    /**
     * Update the order of categories.
     */
    public function updateOrder(Request $request)
    {
        $request->validate([
            'orders' => 'required|array',
            'orders.*.id' => 'required|integer|exists:categories,id',
            'orders.*.order' => 'required|integer|min:0',
        ]);

        foreach ($request->orders as $item) {
            Category::where('id', $item['id'])->update(['order' => $item['order']]);
        }

        return response()->json(['success' => true, 'message' => 'Urutan berhasil diperbarui.']);
    }
}
