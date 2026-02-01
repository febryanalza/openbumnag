@extends('admin.layouts.app')

@section('title', 'Quick Edit Settings')
@section('header', 'Quick Edit Settings')

@section('content')
<div class="space-y-6">
    {{-- Breadcrumb --}}
    <nav class="flex" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
            <li class="inline-flex items-center">
                <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center text-sm font-medium text-gray-500 hover:text-amber-600">
                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path>
                    </svg>
                    Dashboard
                </a>
            </li>
            <li>
                <div class="flex items-center">
                    <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                    </svg>
                    <a href="{{ route('admin.settings.index') }}" class="ml-1 text-sm font-medium text-gray-500 hover:text-amber-600 md:ml-2">Settings</a>
                </div>
            </li>
            <li aria-current="page">
                <div class="flex items-center">
                    <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                    </svg>
                    <span class="ml-1 text-sm font-medium text-gray-900 md:ml-2">Quick Edit</span>
                </div>
            </li>
        </ol>
    </nav>

    {{-- Group Tabs --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="border-b border-gray-200">
            <nav class="flex -mb-px overflow-x-auto" aria-label="Tabs">
                @foreach($groups as $key => $label)
                    @php
                        $isActive = $currentGroup === $key;
                        $groupIcons = [
                            'general' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>',
                            'seo' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>',
                            'social' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z"></path>',
                            'contact' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>',
                            'appearance' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"></path>',
                        ];
                    @endphp
                    <a href="{{ route('admin.settings.grouped', ['group' => $key]) }}" 
                       class="flex items-center gap-2 px-6 py-4 text-sm font-medium border-b-2 whitespace-nowrap {{ $isActive ? 'border-amber-500 text-amber-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            {!! $groupIcons[$key] ?? $groupIcons['general'] !!}
                        </svg>
                        {{ $label }}
                    </a>
                @endforeach
            </nav>
        </div>

        <form method="POST" action="{{ route('admin.settings.update-grouped') }}" enctype="multipart/form-data" class="p-6">
            @csrf

            @if($settings->isEmpty())
                <div class="text-center py-12">
                    <svg class="w-12 h-12 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                    </svg>
                    <h3 class="text-lg font-medium text-gray-900 mb-1">Tidak ada setting di group ini</h3>
                    <p class="text-gray-500 text-sm mb-4">Tambahkan setting baru dengan group "{{ $groups[$currentGroup] }}"</p>
                    <a href="{{ route('admin.settings.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-amber-500 hover:bg-amber-600 text-white font-medium text-sm rounded-lg transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Tambah Setting
                    </a>
                </div>
            @else
                <div class="space-y-6">
                    @foreach($settings as $setting)
                        <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                            <div class="flex flex-col md:flex-row md:items-start gap-4">
                                <div class="md:w-1/3">
                                    <label class="block text-sm font-medium text-gray-900">
                                        <code class="bg-amber-100 text-amber-700 px-2 py-0.5 rounded text-xs">{{ $setting->key }}</code>
                                    </label>
                                    @if($setting->description)
                                        <p class="text-sm text-gray-500 mt-1">{{ $setting->description }}</p>
                                    @endif
                                    <span class="inline-flex mt-2 px-2 py-0.5 rounded text-xs font-medium bg-gray-200 text-gray-600">
                                        {{ $types[$setting->type] ?? $setting->type }}
                                    </span>
                                </div>
                                <div class="md:w-2/3">
                                    @if($setting->type === 'text')
                                        <input type="text" name="settings[{{ $setting->id }}][value]" value="{{ $setting->value }}"
                                            class="block w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-amber-500 focus:border-amber-500">
                                    
                                    @elseif($setting->type === 'textarea')
                                        <textarea name="settings[{{ $setting->id }}][value]" rows="3"
                                            class="block w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-amber-500 focus:border-amber-500">{{ $setting->value }}</textarea>
                                    
                                    @elseif($setting->type === 'boolean')
                                        <label class="relative inline-flex items-center cursor-pointer">
                                            <input type="checkbox" name="settings[{{ $setting->id }}][value]" value="1" class="sr-only peer" {{ $setting->value ? 'checked' : '' }}>
                                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-amber-300 rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-amber-500"></div>
                                            <span class="ml-3 text-sm text-gray-600">{{ $setting->value ? 'Aktif' : 'Nonaktif' }}</span>
                                        </label>
                                    
                                    @elseif($setting->type === 'number')
                                        <input type="number" name="settings[{{ $setting->id }}][value]" value="{{ $setting->value }}" step="any"
                                            class="block w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-amber-500 focus:border-amber-500">
                                    
                                    @elseif($setting->type === 'json')
                                        <textarea name="settings[{{ $setting->id }}][value]" rows="4"
                                            class="block w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm font-mono focus:ring-2 focus:ring-amber-500 focus:border-amber-500">{{ $setting->value }}</textarea>
                                    
                                    @elseif($setting->type === 'image')
                                        @if($setting->value)
                                            <div class="mb-3">
                                                <img src="{{ Storage::url($setting->value) }}" alt="" class="max-w-xs rounded-lg shadow">
                                                <label class="mt-2 flex items-center gap-2 cursor-pointer">
                                                    <input type="checkbox" name="settings[{{ $setting->id }}][remove_file]" value="1" class="rounded border-gray-300 text-red-500 focus:ring-red-500">
                                                    <span class="text-sm text-red-600">Hapus gambar</span>
                                                </label>
                                            </div>
                                        @endif
                                        <input type="file" name="settings[{{ $setting->id }}][value]" accept="image/*"
                                            class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-amber-50 file:text-amber-700 hover:file:bg-amber-100">
                                    
                                    @elseif($setting->type === 'file')
                                        @if($setting->value)
                                            <div class="mb-3">
                                                <a href="{{ Storage::url($setting->value) }}" target="_blank" class="inline-flex items-center gap-2 text-blue-600 hover:text-blue-800">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                                                    </svg>
                                                    {{ basename($setting->value) }}
                                                </a>
                                                <label class="mt-2 flex items-center gap-2 cursor-pointer">
                                                    <input type="checkbox" name="settings[{{ $setting->id }}][remove_file]" value="1" class="rounded border-gray-300 text-red-500 focus:ring-red-500">
                                                    <span class="text-sm text-red-600">Hapus file</span>
                                                </label>
                                            </div>
                                        @endif
                                        <input type="file" name="settings[{{ $setting->id }}][value]"
                                            class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-amber-50 file:text-amber-700 hover:file:bg-amber-100">
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-6 flex items-center justify-end gap-3 pt-6 border-t border-gray-200">
                    <a href="{{ route('admin.settings.index') }}" class="inline-flex items-center justify-center gap-2 px-6 py-2.5 bg-white border border-gray-300 text-gray-700 font-medium text-sm rounded-lg hover:bg-gray-50 transition-colors">
                        Batal
                    </a>
                    <button type="submit" class="inline-flex items-center justify-center gap-2 px-6 py-2.5 bg-amber-500 hover:bg-amber-600 text-white font-medium text-sm rounded-lg transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Simpan Semua
                    </button>
                </div>
            @endif
        </form>
    </div>
</div>
@endsection
