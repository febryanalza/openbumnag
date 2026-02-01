<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class SettingController extends Controller
{
    /**
     * Available setting types
     */
    protected array $types = [
        'text' => 'Text',
        'textarea' => 'Textarea',
        'boolean' => 'Boolean (Yes/No)',
        'number' => 'Number',
        'json' => 'JSON',
        'image' => 'Image',
        'file' => 'File',
    ];

    /**
     * Available setting groups
     */
    protected array $groups = [
        'general' => 'General',
        'seo' => 'SEO',
        'social' => 'Social Media',
        'contact' => 'Contact',
        'appearance' => 'Appearance',
    ];

    /**
     * Display a listing of settings.
     */
    public function index(Request $request)
    {
        $query = Setting::query();

        // Search
        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('key', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('value', 'like', "%{$search}%");
            });
        }

        // Filter by group
        if ($group = $request->input('group')) {
            $query->where('group', $group);
        }

        // Filter by type
        if ($type = $request->input('type')) {
            $query->where('type', $type);
        }

        // Sorting
        $sortField = $request->input('sort', 'order');
        $sortDirection = $request->input('direction', 'asc');
        $allowedSorts = ['key', 'group', 'type', 'order', 'created_at'];
        
        if (in_array($sortField, $allowedSorts)) {
            $query->orderBy($sortField, $sortDirection === 'desc' ? 'desc' : 'asc');
        }

        // Secondary sort by key for consistency
        if ($sortField !== 'key') {
            $query->orderBy('key', 'asc');
        }

        $settings = $query->paginate(15)->withQueryString();

        // Stats
        $stats = [
            'total' => Setting::count(),
            'groups' => Setting::distinct('group')->count('group'),
            'types' => Setting::distinct('type')->count('type'),
        ];

        return view('admin.settings.index', [
            'settings' => $settings,
            'groups' => $this->groups,
            'types' => $this->types,
            'stats' => $stats,
        ]);
    }

    /**
     * Show the form for creating a new setting.
     */
    public function create()
    {
        return view('admin.settings.create', [
            'types' => $this->types,
            'groups' => $this->groups,
        ]);
    }

    /**
     * Store a newly created setting.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'key' => ['required', 'string', 'max:255', 'unique:settings,key', 'regex:/^[a-z_]+$/'],
            'value' => ['nullable'],
            'type' => ['required', Rule::in(array_keys($this->types))],
            'group' => ['required', Rule::in(array_keys($this->groups))],
            'description' => ['nullable', 'string', 'max:500'],
            'order' => ['nullable', 'integer', 'min:0'],
        ], [
            'key.regex' => 'Key hanya boleh berisi huruf kecil dan underscore.',
            'key.unique' => 'Key sudah digunakan.',
        ]);

        // Handle file/image upload
        if (in_array($validated['type'], ['image', 'file']) && $request->hasFile('value')) {
            $file = $request->file('value');
            $path = $file->store('settings', 'public');
            $validated['value'] = $path;
        } elseif ($validated['type'] === 'boolean') {
            $validated['value'] = $request->boolean('value') ? '1' : '0';
        } elseif ($validated['type'] === 'json') {
            // Validate JSON
            json_decode($validated['value']);
            if (json_last_error() !== JSON_ERROR_NONE) {
                return back()->withErrors(['value' => 'Value harus berupa JSON yang valid.'])->withInput();
            }
        }

        $validated['order'] = $validated['order'] ?? 0;

        Setting::create($validated);

        return redirect()->route('admin.settings.index')
            ->with('success', 'Setting berhasil ditambahkan.');
    }

    /**
     * Display the specified setting.
     */
    public function show(Setting $setting)
    {
        return view('admin.settings.show', [
            'setting' => $setting,
            'types' => $this->types,
            'groups' => $this->groups,
        ]);
    }

    /**
     * Show the form for editing the specified setting.
     */
    public function edit(Setting $setting)
    {
        return view('admin.settings.edit', [
            'setting' => $setting,
            'types' => $this->types,
            'groups' => $this->groups,
        ]);
    }

    /**
     * Update the specified setting.
     */
    public function update(Request $request, Setting $setting)
    {
        $validated = $request->validate([
            'key' => ['required', 'string', 'max:255', Rule::unique('settings', 'key')->ignore($setting->id), 'regex:/^[a-z_]+$/'],
            'value' => ['nullable'],
            'type' => ['required', Rule::in(array_keys($this->types))],
            'group' => ['required', Rule::in(array_keys($this->groups))],
            'description' => ['nullable', 'string', 'max:500'],
            'order' => ['nullable', 'integer', 'min:0'],
        ], [
            'key.regex' => 'Key hanya boleh berisi huruf kecil dan underscore.',
        ]);

        // Handle file/image upload
        if (in_array($validated['type'], ['image', 'file'])) {
            if ($request->hasFile('value')) {
                // Delete old file
                if ($setting->value && Storage::disk('public')->exists($setting->value)) {
                    Storage::disk('public')->delete($setting->value);
                }
                
                $file = $request->file('value');
                $path = $file->store('settings', 'public');
                $validated['value'] = $path;
            } elseif ($request->input('remove_file')) {
                // Remove file if requested
                if ($setting->value && Storage::disk('public')->exists($setting->value)) {
                    Storage::disk('public')->delete($setting->value);
                }
                $validated['value'] = null;
            } else {
                // Keep existing value
                unset($validated['value']);
            }
        } elseif ($validated['type'] === 'boolean') {
            $validated['value'] = $request->boolean('value') ? '1' : '0';
        } elseif ($validated['type'] === 'json' && $validated['value']) {
            // Validate JSON
            json_decode($validated['value']);
            if (json_last_error() !== JSON_ERROR_NONE) {
                return back()->withErrors(['value' => 'Value harus berupa JSON yang valid.'])->withInput();
            }
        }

        $validated['order'] = $validated['order'] ?? 0;

        $setting->update($validated);

        return redirect()->route('admin.settings.index')
            ->with('success', 'Setting berhasil diperbarui.');
    }

    /**
     * Remove the specified setting.
     */
    public function destroy(Setting $setting)
    {
        // Delete associated file if exists
        if (in_array($setting->type, ['image', 'file']) && $setting->value) {
            if (Storage::disk('public')->exists($setting->value)) {
                Storage::disk('public')->delete($setting->value);
            }
        }

        $setting->delete();

        return redirect()->route('admin.settings.index')
            ->with('success', 'Setting berhasil dihapus.');
    }

    /**
     * Bulk actions on settings
     */
    public function bulkAction(Request $request)
    {
        $request->validate([
            'action' => ['required', Rule::in(['delete'])],
            'ids' => ['required', 'array'],
            'ids.*' => ['exists:settings,id'],
        ]);

        $settings = Setting::whereIn('id', $request->ids)->get();

        switch ($request->action) {
            case 'delete':
                foreach ($settings as $setting) {
                    // Delete associated files
                    if (in_array($setting->type, ['image', 'file']) && $setting->value) {
                        if (Storage::disk('public')->exists($setting->value)) {
                            Storage::disk('public')->delete($setting->value);
                        }
                    }
                    $setting->delete();
                }
                $message = count($settings) . ' setting berhasil dihapus.';
                break;
        }

        return redirect()->route('admin.settings.index')
            ->with('success', $message ?? 'Aksi berhasil dilakukan.');
    }

    /**
     * Display grouped settings for quick edit
     */
    public function grouped(Request $request)
    {
        $currentGroup = $request->input('group', 'general');
        
        $settings = Setting::where('group', $currentGroup)
            ->orderBy('order')
            ->orderBy('key')
            ->get();

        return view('admin.settings.grouped', [
            'settings' => $settings,
            'groups' => $this->groups,
            'types' => $this->types,
            'currentGroup' => $currentGroup,
        ]);
    }

    /**
     * Update grouped settings
     */
    public function updateGrouped(Request $request)
    {
        $settings = $request->input('settings', []);

        foreach ($settings as $id => $data) {
            $setting = Setting::find($id);
            if (!$setting) continue;

            $value = $data['value'] ?? null;

            // Handle file uploads
            if (in_array($setting->type, ['image', 'file'])) {
                if ($request->hasFile("settings.{$id}.value")) {
                    // Delete old file
                    if ($setting->value && Storage::disk('public')->exists($setting->value)) {
                        Storage::disk('public')->delete($setting->value);
                    }
                    
                    $file = $request->file("settings.{$id}.value");
                    $value = $file->store('settings', 'public');
                } elseif (!empty($data['remove_file'])) {
                    if ($setting->value && Storage::disk('public')->exists($setting->value)) {
                        Storage::disk('public')->delete($setting->value);
                    }
                    $value = null;
                } else {
                    continue; // Keep existing value
                }
            } elseif ($setting->type === 'boolean') {
                $value = isset($data['value']) ? '1' : '0';
            }

            $setting->update(['value' => $value]);
        }

        return back()->with('success', 'Settings berhasil diperbarui.');
    }
}
