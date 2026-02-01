<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TeamMember;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TeamMemberController extends Controller
{
    /**
     * Divisions available
     */
    protected $divisions = [
        'management' => 'Manajemen',
        'operations' => 'Operasional',
        'finance' => 'Keuangan',
        'marketing' => 'Pemasaran',
        'hr' => 'SDM',
        'it' => 'IT',
        'production' => 'Produksi',
        'other' => 'Lainnya',
    ];

    /**
     * Display a listing of team members.
     */
    public function index(Request $request)
    {
        $query = TeamMember::query();

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('position', 'like', "%{$search}%")
                  ->orWhere('division', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Filter by division
        if ($request->filled('division')) {
            $query->where('division', $request->division);
        }

        // Filter by position
        if ($request->filled('position')) {
            $query->where('position', 'like', "%{$request->position}%");
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
            'total' => TeamMember::count(),
            'active' => TeamMember::where('is_active', true)->count(),
            'inactive' => TeamMember::where('is_active', false)->count(),
            'trashed' => TeamMember::onlyTrashed()->count(),
        ];

        // Get unique positions for filter
        $positions = TeamMember::distinct()->pluck('position')->filter()->sort()->values();
        $divisions = $this->divisions;

        $teamMembers = $query->paginate(12)->withQueryString();

        return view('admin.team-members.index', compact('teamMembers', 'stats', 'positions', 'divisions'));
    }

    /**
     * Show the form for creating a new team member.
     */
    public function create()
    {
        $divisions = $this->divisions;
        $positions = TeamMember::distinct()->pluck('position')->filter()->sort()->values();
        return view('admin.team-members.create', compact('divisions', 'positions'));
    }

    /**
     * Store a newly created team member.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'division' => 'nullable|string|max:255',
            'bio' => 'nullable|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:50',
            'facebook' => 'nullable|url|max:255',
            'instagram' => 'nullable|url|max:255',
            'twitter' => 'nullable|url|max:255',
            'linkedin' => 'nullable|url|max:255',
            'order' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
        ]);

        // Handle photo upload
        if ($request->hasFile('photo')) {
            $validated['photo'] = $request->file('photo')->store('team-members', 'public');
        }

        // Set defaults
        $validated['is_active'] = $request->boolean('is_active', true);
        $validated['order'] = $validated['order'] ?? 0;

        TeamMember::create($validated);

        return redirect()->route('admin.team-members.index')
            ->with('success', 'Anggota tim berhasil ditambahkan.');
    }

    /**
     * Display the specified team member.
     */
    public function show(TeamMember $teamMember)
    {
        return view('admin.team-members.show', compact('teamMember'));
    }

    /**
     * Show the form for editing the specified team member.
     */
    public function edit(TeamMember $teamMember)
    {
        $divisions = $this->divisions;
        $positions = TeamMember::distinct()->pluck('position')->filter()->sort()->values();
        return view('admin.team-members.edit', compact('teamMember', 'divisions', 'positions'));
    }

    /**
     * Update the specified team member.
     */
    public function update(Request $request, TeamMember $teamMember)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'division' => 'nullable|string|max:255',
            'bio' => 'nullable|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:50',
            'facebook' => 'nullable|url|max:255',
            'instagram' => 'nullable|url|max:255',
            'twitter' => 'nullable|url|max:255',
            'linkedin' => 'nullable|url|max:255',
            'order' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
        ]);

        // Handle photo upload
        if ($request->hasFile('photo')) {
            // Delete old photo
            if ($teamMember->photo) {
                Storage::disk('public')->delete($teamMember->photo);
            }
            $validated['photo'] = $request->file('photo')->store('team-members', 'public');
        }

        // Handle photo removal
        if ($request->boolean('remove_photo') && $teamMember->photo) {
            Storage::disk('public')->delete($teamMember->photo);
            $validated['photo'] = null;
        }

        // Set defaults
        $validated['is_active'] = $request->boolean('is_active', true);

        $teamMember->update($validated);

        return redirect()->route('admin.team-members.index')
            ->with('success', 'Anggota tim berhasil diperbarui.');
    }

    /**
     * Soft delete the specified team member.
     */
    public function destroy(TeamMember $teamMember)
    {
        $teamMember->delete();
        return redirect()->route('admin.team-members.index')
            ->with('success', 'Anggota tim berhasil dihapus.');
    }

    /**
     * Restore a soft-deleted team member.
     */
    public function restore($id)
    {
        $teamMember = TeamMember::onlyTrashed()->findOrFail($id);
        $teamMember->restore();

        return redirect()->route('admin.team-members.index')
            ->with('success', 'Anggota tim berhasil dipulihkan.');
    }

    /**
     * Permanently delete the specified team member.
     */
    public function forceDelete($id)
    {
        $teamMember = TeamMember::onlyTrashed()->findOrFail($id);
        
        // Delete photo
        if ($teamMember->photo) {
            Storage::disk('public')->delete($teamMember->photo);
        }

        $teamMember->forceDelete();

        return redirect()->route('admin.team-members.index')
            ->with('success', 'Anggota tim berhasil dihapus permanen.');
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
                $count = TeamMember::whereIn('id', $ids)->delete();
                $message = "{$count} anggota tim berhasil dihapus.";
                break;

            case 'restore':
                $count = TeamMember::onlyTrashed()->whereIn('id', $ids)->restore();
                $message = "{$count} anggota tim berhasil dipulihkan.";
                break;

            case 'force_delete':
                $members = TeamMember::onlyTrashed()->whereIn('id', $ids)->get();
                foreach ($members as $member) {
                    if ($member->photo) {
                        Storage::disk('public')->delete($member->photo);
                    }
                    $member->forceDelete();
                    $count++;
                }
                $message = "{$count} anggota tim berhasil dihapus permanen.";
                break;

            case 'activate':
                $count = TeamMember::whereIn('id', $ids)->update(['is_active' => true]);
                $message = "{$count} anggota tim berhasil diaktifkan.";
                break;

            case 'deactivate':
                $count = TeamMember::whereIn('id', $ids)->update(['is_active' => false]);
                $message = "{$count} anggota tim berhasil dinonaktifkan.";
                break;

            default:
                return back()->with('error', 'Aksi tidak valid.');
        }

        return back()->with('success', $message);
    }

    /**
     * Update the order of team members.
     */
    public function updateOrder(Request $request)
    {
        $request->validate([
            'orders' => 'required|array',
            'orders.*.id' => 'required|integer|exists:team_members,id',
            'orders.*.order' => 'required|integer|min:0',
        ]);

        foreach ($request->orders as $item) {
            TeamMember::where('id', $item['id'])->update(['order' => $item['order']]);
        }

        return response()->json(['success' => true, 'message' => 'Urutan berhasil diperbarui.']);
    }
}
