<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BumnagProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class BumnagProfileController extends Controller
{
    /**
     * Display a listing of BUMNag profiles.
     */
    public function index(Request $request)
    {
        $query = BumnagProfile::query();

        // Search
        if ($search = $request->get('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('nagari_name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Filter by status
        if ($request->has('status')) {
            if ($request->get('status') === 'active') {
                $query->where('is_active', true);
            } elseif ($request->get('status') === 'inactive') {
                $query->where('is_active', false);
            }
        }

        // Filter trashed
        if ($request->get('trashed') === 'only') {
            $query->onlyTrashed();
        }

        // Sorting
        $sortField = $request->get('sort', 'created_at');
        $sortDirection = $request->get('direction', 'desc');
        $allowedSortFields = ['name', 'nagari_name', 'created_at', 'is_active'];
        
        if (in_array($sortField, $allowedSortFields)) {
            $query->orderBy($sortField, $sortDirection);
        }

        $profiles = $query->withCount('catalogs')->paginate(10)->withQueryString();
        
        // Stats
        $stats = [
            'total' => BumnagProfile::count(),
            'active' => BumnagProfile::where('is_active', true)->count(),
            'inactive' => BumnagProfile::where('is_active', false)->count(),
            'trashed' => BumnagProfile::onlyTrashed()->count(),
        ];

        return view('admin.bumnag-profiles.index', compact('profiles', 'stats'));
    }

    /**
     * Show the form for creating a new profile.
     */
    public function create()
    {
        return view('admin.bumnag-profiles.create');
    }

    /**
     * Store a newly created profile.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'nagari_name' => ['required', 'string', 'max:255'],
            'tagline' => ['nullable', 'string', 'max:500'],
            'about' => ['nullable', 'string'],
            'vision' => ['nullable', 'string'],
            'mission' => ['nullable', 'string'],
            'values' => ['nullable', 'string'],
            'history' => ['nullable', 'string'],
            'logo' => ['nullable', 'image', 'mimes:jpeg,png,jpg,svg,webp', 'max:2048'],
            'banner' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:4096'],
            'legal_entity_number' => ['nullable', 'string', 'max:100'],
            'established_date' => ['nullable', 'date'],
            'notary_name' => ['nullable', 'string', 'max:255'],
            'deed_number' => ['nullable', 'string', 'max:100'],
            'address' => ['nullable', 'string'],
            'postal_code' => ['nullable', 'string', 'max:10'],
            'phone' => ['nullable', 'string', 'max:20'],
            'fax' => ['nullable', 'string', 'max:20'],
            'email' => ['nullable', 'email', 'max:255'],
            'website' => ['nullable', 'url', 'max:255'],
            'facebook' => ['nullable', 'string', 'max:255'],
            'instagram' => ['nullable', 'string', 'max:255'],
            'twitter' => ['nullable', 'string', 'max:255'],
            'youtube' => ['nullable', 'string', 'max:255'],
            'tiktok' => ['nullable', 'string', 'max:255'],
            'whatsapp' => ['nullable', 'string', 'max:20'],
            'latitude' => ['nullable', 'numeric', 'between:-90,90'],
            'longitude' => ['nullable', 'numeric', 'between:-180,180'],
            'is_active' => ['boolean'],
        ], [
            'name.required' => 'Nama BUMNag wajib diisi.',
            'nagari_name.required' => 'Nama Nagari wajib diisi.',
            'logo.image' => 'Logo harus berupa gambar.',
            'logo.max' => 'Ukuran logo maksimal 2MB.',
            'banner.image' => 'Banner harus berupa gambar.',
            'banner.max' => 'Ukuran banner maksimal 4MB.',
        ]);

        // Handle logo upload
        if ($request->hasFile('logo')) {
            $validated['logo'] = $request->file('logo')->store('bumnag/logos', 'public');
        }

        // Handle banner upload
        if ($request->hasFile('banner')) {
            $validated['banner'] = $request->file('banner')->store('bumnag/banners', 'public');
        }

        $validated['is_active'] = $request->boolean('is_active');

        $profile = BumnagProfile::create($validated);

        return redirect()
            ->route('admin.bumnag-profiles.index')
            ->with('success', "Profil BUMNag {$profile->name} berhasil ditambahkan.");
    }

    /**
     * Display the specified profile.
     */
    public function show(BumnagProfile $bumnagProfile)
    {
        $bumnagProfile->load('catalogs');
        return view('admin.bumnag-profiles.show', compact('bumnagProfile'));
    }

    /**
     * Show the form for editing the specified profile.
     */
    public function edit(BumnagProfile $bumnagProfile)
    {
        return view('admin.bumnag-profiles.edit', compact('bumnagProfile'));
    }

    /**
     * Update the specified profile.
     */
    public function update(Request $request, BumnagProfile $bumnagProfile)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'nagari_name' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', Rule::unique('bumnag_profiles')->ignore($bumnagProfile->id)],
            'tagline' => ['nullable', 'string', 'max:500'],
            'about' => ['nullable', 'string'],
            'vision' => ['nullable', 'string'],
            'mission' => ['nullable', 'string'],
            'values' => ['nullable', 'string'],
            'history' => ['nullable', 'string'],
            'logo' => ['nullable', 'image', 'mimes:jpeg,png,jpg,svg,webp', 'max:2048'],
            'banner' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:4096'],
            'legal_entity_number' => ['nullable', 'string', 'max:100'],
            'established_date' => ['nullable', 'date'],
            'notary_name' => ['nullable', 'string', 'max:255'],
            'deed_number' => ['nullable', 'string', 'max:100'],
            'address' => ['nullable', 'string'],
            'postal_code' => ['nullable', 'string', 'max:10'],
            'phone' => ['nullable', 'string', 'max:20'],
            'fax' => ['nullable', 'string', 'max:20'],
            'email' => ['nullable', 'email', 'max:255'],
            'website' => ['nullable', 'url', 'max:255'],
            'facebook' => ['nullable', 'string', 'max:255'],
            'instagram' => ['nullable', 'string', 'max:255'],
            'twitter' => ['nullable', 'string', 'max:255'],
            'youtube' => ['nullable', 'string', 'max:255'],
            'tiktok' => ['nullable', 'string', 'max:255'],
            'whatsapp' => ['nullable', 'string', 'max:20'],
            'latitude' => ['nullable', 'numeric', 'between:-90,90'],
            'longitude' => ['nullable', 'numeric', 'between:-180,180'],
            'is_active' => ['boolean'],
            'remove_logo' => ['boolean'],
            'remove_banner' => ['boolean'],
        ]);

        // Handle logo
        if ($request->boolean('remove_logo') && $bumnagProfile->logo) {
            Storage::disk('public')->delete($bumnagProfile->logo);
            $validated['logo'] = null;
        } elseif ($request->hasFile('logo')) {
            if ($bumnagProfile->logo) {
                Storage::disk('public')->delete($bumnagProfile->logo);
            }
            $validated['logo'] = $request->file('logo')->store('bumnag/logos', 'public');
        } else {
            unset($validated['logo']);
        }

        // Handle banner
        if ($request->boolean('remove_banner') && $bumnagProfile->banner) {
            Storage::disk('public')->delete($bumnagProfile->banner);
            $validated['banner'] = null;
        } elseif ($request->hasFile('banner')) {
            if ($bumnagProfile->banner) {
                Storage::disk('public')->delete($bumnagProfile->banner);
            }
            $validated['banner'] = $request->file('banner')->store('bumnag/banners', 'public');
        } else {
            unset($validated['banner']);
        }

        $validated['is_active'] = $request->boolean('is_active');
        unset($validated['remove_logo'], $validated['remove_banner']);

        $bumnagProfile->update($validated);

        return redirect()
            ->route('admin.bumnag-profiles.index')
            ->with('success', "Profil BUMNag {$bumnagProfile->name} berhasil diperbarui.");
    }

    /**
     * Soft delete the specified profile.
     */
    public function destroy(BumnagProfile $bumnagProfile)
    {
        $name = $bumnagProfile->name;
        $bumnagProfile->delete();

        return redirect()
            ->route('admin.bumnag-profiles.index')
            ->with('success', "Profil BUMNag {$name} berhasil dihapus.");
    }

    /**
     * Restore a soft deleted profile.
     */
    public function restore($id)
    {
        $profile = BumnagProfile::onlyTrashed()->findOrFail($id);
        $profile->restore();

        return redirect()
            ->route('admin.bumnag-profiles.index')
            ->with('success', "Profil BUMNag {$profile->name} berhasil dipulihkan.");
    }

    /**
     * Permanently delete a profile.
     */
    public function forceDelete($id)
    {
        $profile = BumnagProfile::onlyTrashed()->findOrFail($id);
        $name = $profile->name;

        // Delete associated files
        if ($profile->logo) {
            Storage::disk('public')->delete($profile->logo);
        }
        if ($profile->banner) {
            Storage::disk('public')->delete($profile->banner);
        }
        if ($profile->images) {
            foreach ($profile->images as $image) {
                Storage::disk('public')->delete($image);
            }
        }

        $profile->forceDelete();

        return redirect()
            ->route('admin.bumnag-profiles.index', ['trashed' => 'only'])
            ->with('success', "Profil BUMNag {$name} berhasil dihapus permanen.");
    }

    /**
     * Handle bulk actions.
     */
    public function bulkAction(Request $request)
    {
        $request->validate([
            'action' => ['required', 'in:delete,restore,force_delete,activate,deactivate'],
            'ids' => ['required', 'array'],
            'ids.*' => ['integer'],
        ]);

        $ids = $request->input('ids');
        $action = $request->input('action');
        $count = 0;

        switch ($action) {
            case 'delete':
                $count = BumnagProfile::whereIn('id', $ids)->delete();
                $message = "{$count} profil berhasil dihapus.";
                break;
            case 'restore':
                $count = BumnagProfile::onlyTrashed()->whereIn('id', $ids)->restore();
                $message = "{$count} profil berhasil dipulihkan.";
                break;
            case 'force_delete':
                $profiles = BumnagProfile::onlyTrashed()->whereIn('id', $ids)->get();
                foreach ($profiles as $profile) {
                    if ($profile->logo) Storage::disk('public')->delete($profile->logo);
                    if ($profile->banner) Storage::disk('public')->delete($profile->banner);
                    $profile->forceDelete();
                    $count++;
                }
                $message = "{$count} profil berhasil dihapus permanen.";
                break;
            case 'activate':
                $count = BumnagProfile::whereIn('id', $ids)->update(['is_active' => true]);
                $message = "{$count} profil berhasil diaktifkan.";
                break;
            case 'deactivate':
                $count = BumnagProfile::whereIn('id', $ids)->update(['is_active' => false]);
                $message = "{$count} profil berhasil dinonaktifkan.";
                break;
        }

        return back()->with('success', $message);
    }
}
