@extends('admin.layouts.app')

@section('title', 'Settings')
@section('header', 'Settings')

@section('content')
<div class="space-y-6">
    {{-- Stats Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5">
            <div class="flex items-center gap-4">
                <div class="flex-shrink-0 w-12 h-12 bg-amber-100 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Total Settings</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['total'] }}</p>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5">
            <div class="flex items-center gap-4">
                <div class="flex-shrink-0 w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Groups</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['groups'] }}</p>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5">
            <div class="flex items-center gap-4">
                <div class="flex-shrink-0 w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Types</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['types'] }}</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Actions & Filters --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="p-4 border-b border-gray-200">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                {{-- Search & Filters --}}
                <form method="GET" action="{{ route('admin.settings.index') }}" class="flex flex-col md:flex-row gap-3 flex-1">
                    <div class="relative flex-1 max-w-md">
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari key, value, deskripsi..."
                            class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-amber-500 focus:border-amber-500">
                        <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                    
                    <select name="group" onchange="this.form.submit()" class="border border-gray-300 rounded-lg text-sm px-3 py-2 focus:ring-2 focus:ring-amber-500 focus:border-amber-500">
                        <option value="">Semua Group</option>
                        @foreach($groups as $key => $label)
                            <option value="{{ $key }}" {{ request('group') === $key ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>

                    <select name="type" onchange="this.form.submit()" class="border border-gray-300 rounded-lg text-sm px-3 py-2 focus:ring-2 focus:ring-amber-500 focus:border-amber-500">
                        <option value="">Semua Type</option>
                        @foreach($types as $key => $label)
                            <option value="{{ $key }}" {{ request('type') === $key ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                    
                    <button type="submit" class="inline-flex items-center justify-center gap-2 px-4 py-2 bg-gray-100 text-gray-700 font-medium text-sm rounded-lg hover:bg-gray-200 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                        </svg>
                        Filter
                    </button>
                    
                    @if(request()->hasAny(['search', 'group', 'type']))
                        <a href="{{ route('admin.settings.index') }}" class="inline-flex items-center justify-center gap-2 px-4 py-2 text-gray-500 font-medium text-sm hover:text-gray-700 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                            Reset
                        </a>
                    @endif
                </form>
                
                {{-- Add Button --}}
                <div class="flex items-center gap-2">
                    <a href="{{ route('admin.settings.grouped') }}" class="inline-flex items-center justify-center gap-2 px-4 py-2 bg-gray-100 text-gray-700 font-medium text-sm rounded-lg hover:bg-gray-200 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
                        </svg>
                        Quick Edit
                    </a>
                    <a href="{{ route('admin.settings.create') }}" class="inline-flex items-center justify-center gap-2 px-4 py-2 bg-amber-500 hover:bg-amber-600 text-white font-medium text-sm rounded-lg transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Tambah Setting
                    </a>
                </div>
            </div>
        </div>

        {{-- Table --}}
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="w-12 px-4 py-3 text-left">
                            <input type="checkbox" id="selectAll" class="rounded border-gray-300 text-amber-500 focus:ring-amber-500">
                        </th>
                        <th class="px-4 py-3 text-left">
                            <a href="{{ request()->fullUrlWithQuery(['sort' => 'key', 'direction' => request('sort') === 'key' && request('direction') === 'asc' ? 'desc' : 'asc']) }}" class="flex items-center gap-1 text-xs font-semibold text-gray-600 uppercase tracking-wider hover:text-gray-900">
                                Key
                                @if(request('sort') === 'key')
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ request('direction') === 'desc' ? 'M19 9l-7 7-7-7' : 'M5 15l7-7 7 7' }}"></path>
                                    </svg>
                                @endif
                            </a>
                        </th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Value</th>
                        <th class="px-4 py-3 text-left">
                            <a href="{{ request()->fullUrlWithQuery(['sort' => 'type', 'direction' => request('sort') === 'type' && request('direction') === 'asc' ? 'desc' : 'asc']) }}" class="flex items-center gap-1 text-xs font-semibold text-gray-600 uppercase tracking-wider hover:text-gray-900">
                                Type
                                @if(request('sort') === 'type')
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ request('direction') === 'desc' ? 'M19 9l-7 7-7-7' : 'M5 15l7-7 7 7' }}"></path>
                                    </svg>
                                @endif
                            </a>
                        </th>
                        <th class="px-4 py-3 text-left">
                            <a href="{{ request()->fullUrlWithQuery(['sort' => 'group', 'direction' => request('sort') === 'group' && request('direction') === 'asc' ? 'desc' : 'asc']) }}" class="flex items-center gap-1 text-xs font-semibold text-gray-600 uppercase tracking-wider hover:text-gray-900">
                                Group
                                @if(request('sort') === 'group')
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ request('direction') === 'desc' ? 'M19 9l-7 7-7-7' : 'M5 15l7-7 7 7' }}"></path>
                                    </svg>
                                @endif
                            </a>
                        </th>
                        <th class="px-4 py-3 text-left">
                            <a href="{{ request()->fullUrlWithQuery(['sort' => 'order', 'direction' => request('sort') === 'order' && request('direction') === 'asc' ? 'desc' : 'asc']) }}" class="flex items-center gap-1 text-xs font-semibold text-gray-600 uppercase tracking-wider hover:text-gray-900">
                                Order
                                @if(request('sort', 'order') === 'order')
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ request('direction') === 'desc' ? 'M19 9l-7 7-7-7' : 'M5 15l7-7 7 7' }}"></path>
                                    </svg>
                                @endif
                            </a>
                        </th>
                        <th class="px-4 py-3 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($settings as $setting)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-4 py-3">
                                <input type="checkbox" name="ids[]" value="{{ $setting->id }}" class="setting-checkbox rounded border-gray-300 text-amber-500 focus:ring-amber-500">
                            </td>
                            <td class="px-4 py-3">
                                <div>
                                    <code class="text-sm font-mono bg-gray-100 px-2 py-1 rounded text-amber-700">{{ $setting->key }}</code>
                                    @if($setting->description)
                                        <p class="text-xs text-gray-500 mt-1 truncate max-w-xs">{{ $setting->description }}</p>
                                    @endif
                                </div>
                            </td>
                            <td class="px-4 py-3">
                                @if($setting->type === 'boolean')
                                    @if($setting->value)
                                        <span class="inline-flex items-center gap-1 px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                            </svg>
                                            Yes
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1 px-2 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-600">
                                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                            </svg>
                                            No
                                        </span>
                                    @endif
                                @elseif($setting->type === 'image' && $setting->value)
                                    <img src="{{ Storage::url($setting->value) }}" alt="" class="w-10 h-10 rounded object-cover">
                                @elseif($setting->type === 'file' && $setting->value)
                                    <a href="{{ Storage::url($setting->value) }}" target="_blank" class="inline-flex items-center gap-1 text-blue-600 hover:text-blue-800 text-sm">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                                        </svg>
                                        View File
                                    </a>
                                @elseif($setting->type === 'json')
                                    <code class="text-xs bg-gray-100 px-2 py-1 rounded text-gray-600 truncate block max-w-xs">{{ Str::limit($setting->value, 50) }}</code>
                                @else
                                    <span class="text-sm text-gray-900 truncate block max-w-xs">{{ Str::limit($setting->value, 50) ?: '-' }}</span>
                                @endif
                            </td>
                            <td class="px-4 py-3">
                                @php
                                    $typeColors = [
                                        'text' => 'bg-gray-100 text-gray-700',
                                        'textarea' => 'bg-blue-100 text-blue-700',
                                        'boolean' => 'bg-green-100 text-green-700',
                                        'number' => 'bg-purple-100 text-purple-700',
                                        'json' => 'bg-amber-100 text-amber-700',
                                        'image' => 'bg-pink-100 text-pink-700',
                                        'file' => 'bg-cyan-100 text-cyan-700',
                                    ];
                                @endphp
                                <span class="inline-flex px-2 py-1 rounded-full text-xs font-medium {{ $typeColors[$setting->type] ?? 'bg-gray-100 text-gray-700' }}">
                                    {{ $types[$setting->type] ?? $setting->type }}
                                </span>
                            </td>
                            <td class="px-4 py-3">
                                @php
                                    $groupColors = [
                                        'general' => 'bg-gray-100 text-gray-700',
                                        'seo' => 'bg-blue-100 text-blue-700',
                                        'social' => 'bg-pink-100 text-pink-700',
                                        'contact' => 'bg-green-100 text-green-700',
                                        'appearance' => 'bg-purple-100 text-purple-700',
                                    ];
                                @endphp
                                <span class="inline-flex px-2 py-1 rounded-full text-xs font-medium {{ $groupColors[$setting->group] ?? 'bg-gray-100 text-gray-700' }}">
                                    {{ $groups[$setting->group] ?? $setting->group }}
                                </span>
                            </td>
                            <td class="px-4 py-3">
                                <span class="inline-flex items-center justify-center w-6 h-6 rounded bg-gray-100 text-xs font-medium text-gray-600">{{ $setting->order }}</span>
                            </td>
                            <td class="px-4 py-3">
                                <div class="flex items-center justify-end gap-1">
                                    <a href="{{ route('admin.settings.show', $setting) }}" class="p-2 text-gray-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-colors" title="Lihat">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                    </a>
                                    <a href="{{ route('admin.settings.edit', $setting) }}" class="p-2 text-gray-400 hover:text-amber-600 hover:bg-amber-50 rounded-lg transition-colors" title="Edit">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                    </a>
                                    <form action="{{ route('admin.settings.destroy', $setting) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus setting ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors" title="Hapus">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-4 py-12 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <svg class="w-12 h-12 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                    <h3 class="text-lg font-medium text-gray-900 mb-1">Tidak ada setting</h3>
                                    <p class="text-gray-500 text-sm">Mulai dengan menambahkan setting pertama Anda.</p>
                                    <a href="{{ route('admin.settings.create') }}" class="mt-4 inline-flex items-center gap-2 px-4 py-2 bg-amber-500 hover:bg-amber-600 text-white font-medium text-sm rounded-lg transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                        </svg>
                                        Tambah Setting
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if($settings->hasPages())
            <div class="px-4 py-3 border-t border-gray-200 bg-gray-50">
                {{ $settings->links() }}
            </div>
        @endif
    </div>
</div>

@push('scripts')
<script>
    document.getElementById('selectAll')?.addEventListener('change', function() {
        document.querySelectorAll('.setting-checkbox').forEach(cb => cb.checked = this.checked);
    });
</script>
@endpush
@endsection
