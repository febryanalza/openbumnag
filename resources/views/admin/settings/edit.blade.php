@extends('admin.layouts.app')

@section('title', 'Edit Setting')
@section('header', 'Edit Setting')

@section('content')
<div class="max-w-3xl">
    {{-- Breadcrumb --}}
    <nav class="flex mb-6" aria-label="Breadcrumb">
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
                    <span class="ml-1 text-sm font-medium text-gray-900 md:ml-2">Edit</span>
                </div>
            </li>
        </ol>
    </nav>

    {{-- Current Setting Info --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-6">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-amber-400 to-amber-600 flex items-center justify-center text-white flex-shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                </svg>
            </div>
            <div class="flex-1 min-w-0">
                <code class="text-lg font-mono font-bold text-amber-700 bg-amber-50 px-2 py-1 rounded">{{ $setting->key }}</code>
                @if($setting->description)
                    <p class="text-sm text-gray-500 mt-1">{{ $setting->description }}</p>
                @endif
                <div class="flex flex-wrap gap-2 mt-2">
                    @php
                        $groupColors = [
                            'general' => 'bg-gray-100 text-gray-700',
                            'seo' => 'bg-blue-100 text-blue-700',
                            'social' => 'bg-pink-100 text-pink-700',
                            'contact' => 'bg-green-100 text-green-700',
                            'appearance' => 'bg-purple-100 text-purple-700',
                        ];
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
                    <span class="inline-flex px-2 py-1 rounded-full text-xs font-medium {{ $groupColors[$setting->group] ?? 'bg-gray-100 text-gray-700' }}">
                        {{ $groups[$setting->group] ?? $setting->group }}
                    </span>
                    <span class="inline-flex px-2 py-1 rounded-full text-xs font-medium {{ $typeColors[$setting->type] ?? 'bg-gray-100 text-gray-700' }}">
                        {{ $types[$setting->type] ?? $setting->type }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    <form method="POST" action="{{ route('admin.settings.update', $setting) }}" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')

        {{-- Setting Key Card --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                <h3 class="text-lg font-semibold text-gray-900 flex items-center gap-2">
                    <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path>
                    </svg>
                    Identitas Setting
                </h3>
            </div>
            
            <div class="p-6 space-y-6">
                {{-- Key --}}
                <div>
                    <label for="key" class="block text-sm font-medium text-gray-700 mb-2">
                        Key <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="key" id="key" value="{{ old('key', $setting->key) }}" required
                        pattern="[a-z_]+"
                        class="block w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm font-mono focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition-colors @error('key') border-red-500 @enderror">
                    <p class="mt-1 text-xs text-gray-500">Hanya huruf kecil dan underscore (a-z, _)</p>
                    @error('key')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Description --}}
                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                        Deskripsi
                    </label>
                    <input type="text" name="description" id="description" value="{{ old('description', $setting->description) }}"
                        class="block w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition-colors">
                </div>

                {{-- Group & Type --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="group" class="block text-sm font-medium text-gray-700 mb-2">
                            Group <span class="text-red-500">*</span>
                        </label>
                        <select name="group" id="group" required
                            class="block w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition-colors">
                            @foreach($groups as $key => $label)
                                <option value="{{ $key }}" {{ old('group', $setting->group) === $key ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="type" class="block text-sm font-medium text-gray-700 mb-2">
                            Type <span class="text-red-500">*</span>
                        </label>
                        <select name="type" id="type" required onchange="updateValueField()"
                            class="block w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition-colors">
                            @foreach($types as $key => $label)
                                <option value="{{ $key }}" {{ old('type', $setting->type) === $key ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                {{-- Order --}}
                <div>
                    <label for="order" class="block text-sm font-medium text-gray-700 mb-2">
                        Order
                    </label>
                    <input type="number" name="order" id="order" value="{{ old('order', $setting->order) }}" min="0"
                        class="block w-32 px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition-colors">
                </div>
            </div>
        </div>

        {{-- Value Card --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                <h3 class="text-lg font-semibold text-gray-900 flex items-center gap-2">
                    <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4"></path>
                    </svg>
                    Nilai Setting
                </h3>
            </div>
            
            <div class="p-6">
                {{-- Text Input --}}
                <div id="value-text" class="value-field {{ $setting->type !== 'text' ? 'hidden' : '' }}">
                    <label for="value_text" class="block text-sm font-medium text-gray-700 mb-2">Value</label>
                    <input type="text" name="value" id="value_text" value="{{ old('value', $setting->type === 'text' ? $setting->value : '') }}"
                        {{ $setting->type !== 'text' ? 'disabled' : '' }}
                        class="block w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition-colors">
                </div>

                {{-- Textarea Input --}}
                <div id="value-textarea" class="value-field {{ $setting->type !== 'textarea' ? 'hidden' : '' }}">
                    <label for="value_textarea" class="block text-sm font-medium text-gray-700 mb-2">Value</label>
                    <textarea name="value" id="value_textarea" rows="5"
                        {{ $setting->type !== 'textarea' ? 'disabled' : '' }}
                        class="block w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition-colors">{{ old('value', $setting->type === 'textarea' ? $setting->value : '') }}</textarea>
                </div>

                {{-- Boolean Input --}}
                <div id="value-boolean" class="value-field {{ $setting->type !== 'boolean' ? 'hidden' : '' }}">
                    <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                        <div>
                            <label for="value_boolean" class="text-sm font-medium text-gray-700">Value</label>
                            <p class="text-xs text-gray-500 mt-1">Aktifkan atau nonaktifkan</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" name="value" id="value_boolean" value="1" class="sr-only peer"
                                {{ $setting->type !== 'boolean' ? 'disabled' : '' }}
                                {{ old('value', $setting->type === 'boolean' && $setting->value) ? 'checked' : '' }}>
                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-amber-300 rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-amber-500"></div>
                        </label>
                    </div>
                </div>

                {{-- Number Input --}}
                <div id="value-number" class="value-field {{ $setting->type !== 'number' ? 'hidden' : '' }}">
                    <label for="value_number" class="block text-sm font-medium text-gray-700 mb-2">Value</label>
                    <input type="number" name="value" id="value_number" value="{{ old('value', $setting->type === 'number' ? $setting->value : '') }}" step="any"
                        {{ $setting->type !== 'number' ? 'disabled' : '' }}
                        class="block w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition-colors">
                </div>

                {{-- JSON Input --}}
                <div id="value-json" class="value-field {{ $setting->type !== 'json' ? 'hidden' : '' }}">
                    <label for="value_json" class="block text-sm font-medium text-gray-700 mb-2">Value (JSON)</label>
                    <textarea name="value" id="value_json" rows="8"
                        {{ $setting->type !== 'json' ? 'disabled' : '' }}
                        class="block w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm font-mono focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition-colors">{{ old('value', $setting->type === 'json' ? $setting->value : '') }}</textarea>
                </div>

                {{-- Image Input --}}
                <div id="value-image" class="value-field {{ $setting->type !== 'image' ? 'hidden' : '' }}">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Image</label>
                    
                    @if($setting->type === 'image' && $setting->value)
                        <div class="mb-4 p-4 bg-gray-50 rounded-lg">
                            <p class="text-sm text-gray-500 mb-2">Gambar saat ini:</p>
                            <img src="{{ Storage::url($setting->value) }}" alt="" class="max-w-xs rounded-lg shadow">
                            <label class="mt-3 flex items-center gap-2 cursor-pointer">
                                <input type="checkbox" name="remove_file" value="1" class="rounded border-gray-300 text-red-500 focus:ring-red-500">
                                <span class="text-sm text-red-600">Hapus gambar ini</span>
                            </label>
                        </div>
                    @endif

                    <div class="flex items-center justify-center w-full">
                        <label class="flex flex-col items-center justify-center w-full h-40 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100 transition-colors">
                            <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                <svg class="w-8 h-8 mb-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                <p class="mb-2 text-sm text-gray-500"><span class="font-semibold">Klik untuk upload baru</span></p>
                                <p class="text-xs text-gray-500">PNG, JPG, GIF, WEBP (MAX. 2MB)</p>
                            </div>
                            <input type="file" name="value" class="hidden" accept="image/*" {{ $setting->type !== 'image' ? 'disabled' : '' }}>
                        </label>
                    </div>
                </div>

                {{-- File Input --}}
                <div id="value-file" class="value-field {{ $setting->type !== 'file' ? 'hidden' : '' }}">
                    <label class="block text-sm font-medium text-gray-700 mb-2">File</label>
                    
                    @if($setting->type === 'file' && $setting->value)
                        <div class="mb-4 p-4 bg-gray-50 rounded-lg">
                            <p class="text-sm text-gray-500 mb-2">File saat ini:</p>
                            <a href="{{ Storage::url($setting->value) }}" target="_blank" class="inline-flex items-center gap-2 text-blue-600 hover:text-blue-800">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                                </svg>
                                {{ basename($setting->value) }}
                            </a>
                            <label class="mt-3 flex items-center gap-2 cursor-pointer">
                                <input type="checkbox" name="remove_file" value="1" class="rounded border-gray-300 text-red-500 focus:ring-red-500">
                                <span class="text-sm text-red-600">Hapus file ini</span>
                            </label>
                        </div>
                    @endif

                    <div class="flex items-center justify-center w-full">
                        <label class="flex flex-col items-center justify-center w-full h-40 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100 transition-colors">
                            <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                <svg class="w-8 h-8 mb-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                                </svg>
                                <p class="mb-2 text-sm text-gray-500"><span class="font-semibold">Klik untuk upload baru</span></p>
                            </div>
                            <input type="file" name="value" class="hidden" {{ $setting->type !== 'file' ? 'disabled' : '' }}>
                        </label>
                    </div>
                </div>

                @error('value')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>

        {{-- Metadata Card --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                <h3 class="text-lg font-semibold text-gray-900 flex items-center gap-2">
                    <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Informasi Lainnya
                </h3>
            </div>
            <div class="p-6">
                <dl class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
                    <div class="bg-gray-50 rounded-lg p-4">
                        <dt class="text-gray-500 mb-1">ID</dt>
                        <dd class="font-medium text-gray-900">#{{ $setting->id }}</dd>
                    </div>
                    <div class="bg-gray-50 rounded-lg p-4">
                        <dt class="text-gray-500 mb-1">Dibuat</dt>
                        <dd class="font-medium text-gray-900">{{ $setting->created_at->format('d M Y H:i') }}</dd>
                    </div>
                    <div class="bg-gray-50 rounded-lg p-4">
                        <dt class="text-gray-500 mb-1">Diperbarui</dt>
                        <dd class="font-medium text-gray-900">{{ $setting->updated_at->format('d M Y H:i') }}</dd>
                    </div>
                </dl>
            </div>
        </div>

        {{-- Action Buttons --}}
        <div class="flex items-center justify-between">
            <button type="button" onclick="document.getElementById('deleteModal').classList.remove('hidden')" class="inline-flex items-center justify-center gap-2 px-4 py-2.5 text-red-600 font-medium text-sm hover:text-red-700 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                </svg>
                Hapus Setting
            </button>
            <div class="flex items-center gap-3">
                <a href="{{ route('admin.settings.index') }}" class="inline-flex items-center justify-center gap-2 px-6 py-2.5 bg-white border border-gray-300 text-gray-700 font-medium text-sm rounded-lg hover:bg-gray-50 transition-colors">
                    Batal
                </a>
                <button type="submit" class="inline-flex items-center justify-center gap-2 px-6 py-2.5 bg-amber-500 hover:bg-amber-600 text-white font-medium text-sm rounded-lg transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    Simpan Perubahan
                </button>
            </div>
        </div>
    </form>
</div>

{{-- Delete Modal --}}
<div id="deleteModal" class="hidden fixed inset-0 z-50 overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75" onclick="document.getElementById('deleteModal').classList.add('hidden')"></div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>
        <div class="inline-block overflow-hidden text-left align-bottom transition-all transform bg-white rounded-xl shadow-xl sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <div class="px-6 pt-6 pb-4">
                <div class="flex items-center gap-4">
                    <div class="flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100">
                        <svg class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900">Hapus Setting</h3>
                        <p class="text-sm text-gray-500 mt-1">
                            Apakah Anda yakin ingin menghapus setting <code class="bg-gray-100 px-1 rounded">{{ $setting->key }}</code>? Tindakan ini tidak dapat dibatalkan.
                        </p>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 px-6 py-4 flex justify-end gap-3">
                <button type="button" onclick="document.getElementById('deleteModal').classList.add('hidden')" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50">
                    Batal
                </button>
                <form action="{{ route('admin.settings.destroy', $setting) }}" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-lg text-sm font-medium text-white hover:bg-red-700">
                        Ya, Hapus
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function updateValueField() {
        const type = document.getElementById('type').value;
        
        document.querySelectorAll('.value-field').forEach(el => {
            el.classList.add('hidden');
            el.querySelectorAll('input, textarea').forEach(input => {
                input.disabled = true;
                if (input.type !== 'checkbox' || input.name !== 'remove_file') {
                    input.name = '';
                }
            });
        });
        
        const field = document.getElementById('value-' + type);
        if (field) {
            field.classList.remove('hidden');
            field.querySelectorAll('input, textarea').forEach(input => {
                input.disabled = false;
                if (input.type !== 'checkbox' || input.name !== 'remove_file') {
                    input.name = 'value';
                }
            });
        }
    }
</script>
@endpush
@endsection
