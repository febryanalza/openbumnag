<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ReportController extends Controller
{
    protected $statuses = [
        'draft' => 'Draft',
        'published' => 'Published',
        'archived' => 'Archived',
    ];

    protected $reportTypes = [
        'financial' => 'Laporan Keuangan',
        'activity' => 'Laporan Kegiatan',
        'annual' => 'Laporan Tahunan',
        'monthly' => 'Laporan Bulanan',
    ];

    protected $months = [
        1 => 'Januari',
        2 => 'Februari',
        3 => 'Maret',
        4 => 'April',
        5 => 'Mei',
        6 => 'Juni',
        7 => 'Juli',
        8 => 'Agustus',
        9 => 'September',
        10 => 'Oktober',
        11 => 'November',
        12 => 'Desember',
    ];

    protected $quarters = [
        1 => 'Kuartal 1 (Jan-Mar)',
        2 => 'Kuartal 2 (Apr-Jun)',
        3 => 'Kuartal 3 (Jul-Sep)',
        4 => 'Kuartal 4 (Okt-Des)',
    ];

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Report::with(['category', 'user']);

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
                  ->orWhere('period', 'like', "%{$search}%");
            });
        }

        // Filter by status
        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        // Filter by type
        if ($request->filled('type') && $request->type !== 'all') {
            $query->where('type', $request->type);
        }

        // Filter by year
        if ($request->filled('year') && $request->year !== 'all') {
            $query->where('year', $request->year);
        }

        // Filter by category
        if ($request->filled('category') && $request->category !== 'all') {
            $query->where('category_id', $request->category);
        }

        // Sorting
        $sortField = $request->get('sort', 'created_at');
        $sortDirection = $request->get('direction', 'desc');
        $allowedSorts = ['title', 'type', 'year', 'status', 'downloads', 'published_at', 'created_at'];
        
        if (in_array($sortField, $allowedSorts)) {
            $query->orderBy($sortField, $sortDirection);
        } else {
            $query->latest();
        }

        $reports = $query->paginate(15)->withQueryString();

        // Stats
        $stats = [
            'total' => Report::count(),
            'published' => Report::where('status', 'published')->count(),
            'draft' => Report::where('status', 'draft')->count(),
            'trashed' => Report::onlyTrashed()->count(),
        ];

        // Get years for filter
        $years = Report::distinct()->orderBy('year', 'desc')->pluck('year');

        $categories = Category::where('type', 'report')->orWhereNull('type')->orderBy('name')->get();

        return view('admin.reports.index', compact('reports', 'stats', 'years', 'categories'))
            ->with('statuses', $this->statuses)
            ->with('reportTypes', $this->reportTypes);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::where('type', 'report')->orWhereNull('type')->orderBy('name')->get();
        $currentYear = date('Y');
        $years = range($currentYear, $currentYear - 10);
        
        return view('admin.reports.create', compact('categories', 'years'))
            ->with('statuses', $this->statuses)
            ->with('reportTypes', $this->reportTypes)
            ->with('months', $this->months)
            ->with('quarters', $this->quarters);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:reports,slug',
            'category_id' => 'nullable|exists:categories,id',
            'description' => 'nullable|string|max:2000',
            'type' => 'required|in:financial,activity,annual,monthly',
            'year' => 'required|integer|min:2000|max:2100',
            'month' => 'nullable|integer|min:1|max:12',
            'quarter' => 'nullable|integer|min:1|max:4',
            'file' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx|max:20480', // 20MB max
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'content' => 'nullable|string',
            'status' => 'required|in:draft,published,archived',
            'published_at' => 'nullable|date',
        ]);

        // Generate period string
        $validated['period'] = $this->generatePeriod($validated);

        // Handle file upload
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $validated['file_path'] = $file->store('reports', 'public');
            $validated['file_type'] = $file->getClientOriginalExtension();
            $validated['file_size'] = $file->getSize();
        }
        unset($validated['file']);

        // Handle cover image upload
        if ($request->hasFile('cover_image')) {
            $validated['cover_image'] = $request->file('cover_image')->store('reports/covers', 'public');
        }

        // Set defaults
        $validated['user_id'] = auth()->id();

        // Auto-set published_at if publishing
        if ($validated['status'] === 'published' && empty($validated['published_at'])) {
            $validated['published_at'] = now();
        }

        // Generate slug if empty
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['title'] . '-' . $validated['period']);
        }

        Report::create($validated);

        return redirect()->route('admin.reports.index')
            ->with('success', 'Laporan berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Report $report)
    {
        $report->load(['category', 'user']);
        return view('admin.reports.show', compact('report'))
            ->with('statuses', $this->statuses)
            ->with('reportTypes', $this->reportTypes)
            ->with('months', $this->months)
            ->with('quarters', $this->quarters);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Report $report)
    {
        $categories = Category::where('type', 'report')->orWhereNull('type')->orderBy('name')->get();
        $currentYear = date('Y');
        $years = range($currentYear, $currentYear - 10);
        
        return view('admin.reports.edit', compact('report', 'categories', 'years'))
            ->with('statuses', $this->statuses)
            ->with('reportTypes', $this->reportTypes)
            ->with('months', $this->months)
            ->with('quarters', $this->quarters);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Report $report)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:reports,slug,' . $report->id,
            'category_id' => 'nullable|exists:categories,id',
            'description' => 'nullable|string|max:2000',
            'type' => 'required|in:financial,activity,annual,monthly',
            'year' => 'required|integer|min:2000|max:2100',
            'month' => 'nullable|integer|min:1|max:12',
            'quarter' => 'nullable|integer|min:1|max:4',
            'file' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx|max:20480',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'content' => 'nullable|string',
            'status' => 'required|in:draft,published,archived',
            'published_at' => 'nullable|date',
        ]);

        // Generate period string
        $validated['period'] = $this->generatePeriod($validated);

        // Handle file upload
        if ($request->hasFile('file')) {
            // Delete old file
            if ($report->file_path) {
                Storage::disk('public')->delete($report->file_path);
            }
            $file = $request->file('file');
            $validated['file_path'] = $file->store('reports', 'public');
            $validated['file_type'] = $file->getClientOriginalExtension();
            $validated['file_size'] = $file->getSize();
        } elseif ($request->boolean('remove_file')) {
            if ($report->file_path) {
                Storage::disk('public')->delete($report->file_path);
            }
            $validated['file_path'] = null;
            $validated['file_type'] = null;
            $validated['file_size'] = null;
        }
        unset($validated['file']);

        // Handle cover image
        if ($request->hasFile('cover_image')) {
            if ($report->cover_image) {
                Storage::disk('public')->delete($report->cover_image);
            }
            $validated['cover_image'] = $request->file('cover_image')->store('reports/covers', 'public');
        } elseif ($request->boolean('remove_cover_image')) {
            if ($report->cover_image) {
                Storage::disk('public')->delete($report->cover_image);
            }
            $validated['cover_image'] = null;
        }

        // Auto-set published_at if publishing for first time
        if ($validated['status'] === 'published' && $report->status !== 'published' && empty($validated['published_at'])) {
            $validated['published_at'] = now();
        }

        $report->update($validated);

        return redirect()->route('admin.reports.index')
            ->with('success', 'Laporan berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage (soft delete).
     */
    public function destroy(Report $report)
    {
        $report->delete();

        return redirect()->route('admin.reports.index')
            ->with('success', 'Laporan berhasil dipindahkan ke sampah.');
    }

    /**
     * Restore a soft-deleted resource.
     */
    public function restore($id)
    {
        $report = Report::onlyTrashed()->findOrFail($id);
        $report->restore();

        return redirect()->route('admin.reports.index')
            ->with('success', 'Laporan berhasil dipulihkan.');
    }

    /**
     * Force delete a resource.
     */
    public function forceDelete($id)
    {
        $report = Report::onlyTrashed()->findOrFail($id);

        // Delete files
        if ($report->file_path) {
            Storage::disk('public')->delete($report->file_path);
        }
        if ($report->cover_image) {
            Storage::disk('public')->delete($report->cover_image);
        }

        $report->forceDelete();

        return redirect()->route('admin.reports.index')
            ->with('success', 'Laporan berhasil dihapus permanen.');
    }

    /**
     * Download report file.
     */
    public function download(Report $report)
    {
        if (!$report->file_path || !Storage::disk('public')->exists($report->file_path)) {
            return back()->with('error', 'File tidak ditemukan.');
        }

        // Increment download count
        $report->increment('downloads');

        $fileName = Str::slug($report->title) . '.' . $report->file_type;
        return Storage::disk('public')->download($report->file_path, $fileName);
    }

    /**
     * Bulk action handler.
     */
    public function bulkAction(Request $request)
    {
        $request->validate([
            'action' => 'required|in:delete,restore,force_delete,publish,archive',
            'ids' => 'required|array',
            'ids.*' => 'integer',
        ]);

        $action = $request->action;
        $ids = $request->ids;
        $count = 0;

        switch ($action) {
            case 'delete':
                $count = Report::whereIn('id', $ids)->count();
                Report::whereIn('id', $ids)->delete();
                $message = "{$count} laporan dipindahkan ke sampah.";
                break;

            case 'restore':
                $count = Report::onlyTrashed()->whereIn('id', $ids)->count();
                Report::onlyTrashed()->whereIn('id', $ids)->restore();
                $message = "{$count} laporan berhasil dipulihkan.";
                break;

            case 'force_delete':
                $items = Report::onlyTrashed()->whereIn('id', $ids)->get();
                foreach ($items as $item) {
                    if ($item->file_path) {
                        Storage::disk('public')->delete($item->file_path);
                    }
                    if ($item->cover_image) {
                        Storage::disk('public')->delete($item->cover_image);
                    }
                    $item->forceDelete();
                    $count++;
                }
                $message = "{$count} laporan dihapus permanen.";
                break;

            case 'publish':
                $count = Report::whereIn('id', $ids)->update([
                    'status' => 'published',
                    'published_at' => now(),
                ]);
                $message = "{$count} laporan berhasil dipublikasikan.";
                break;

            case 'archive':
                $count = Report::whereIn('id', $ids)->update(['status' => 'archived']);
                $message = "{$count} laporan berhasil diarsipkan.";
                break;

            default:
                return back()->with('error', 'Aksi tidak valid.');
        }

        return back()->with('success', $message);
    }

    /**
     * Generate period string based on type and date fields.
     */
    protected function generatePeriod(array $data): string
    {
        $year = $data['year'];
        
        switch ($data['type']) {
            case 'monthly':
                if (!empty($data['month'])) {
                    return $this->months[$data['month']] . ' ' . $year;
                }
                return $year;
            
            case 'annual':
                return 'Tahun ' . $year;
            
            case 'financial':
                if (!empty($data['quarter'])) {
                    return 'Q' . $data['quarter'] . ' ' . $year;
                } elseif (!empty($data['month'])) {
                    return $this->months[$data['month']] . ' ' . $year;
                }
                return $year;
            
            default:
                return $year;
        }
    }
}
