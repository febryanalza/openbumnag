@extends('admin.layouts.app')

@section('title', 'Tambah Setting')
@section('header', 'Tambah Setting Baru')

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
                    <span class="ml-1 text-sm font-medium text-gray-900 md:ml-2">Tambah</span>
                </div>
            </li>
        </ol>
    </nav>

    <form method="POST" action="{{ route('admin.settings.store') }}" enctype="multipart/form-data" class="space-y-6">
        @csrf

        {{-- Setting Key Card --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                <h3 class="text-lg font-semibold text-gray-900 flex items-center gap-2">
                    <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path>
                    </svg>
                    Identitas Setting
                </h3>
                <p class="text-sm text-gray-500 mt-1">Key unik untuk mengidentifikasi setting</p>
            </div>
            
            <div class="p-6 space-y-6">
                {{-- Key --}}
                <div>
                    <label for="key" class="block text-sm font-medium text-gray-700 mb-2">
                        Key <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="key" id="key" value="{{ old('key') }}" required autofocus
                        pattern="[a-z_]+"
                        class="block w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm font-mono focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition-colors @error('key') border-red-500 @enderror"
                        placeholder="contoh: site_name, meta_description">
                    <p class="mt-1 text-xs text-gray-500">Hanya huruf kecil dan underscore (a-z, _)</p>
                    @error('key')
                        <p class="mt-2 text-sm text-red-600 flex items-center gap-1">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                            </svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- Description --}}
                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                        Deskripsi
                    </label>
                    <input type="text" name="description" id="description" value="{{ old('description') }}"
                        class="block w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition-colors @error('description') border-red-500 @enderror"
                        placeholder="Deskripsi singkat tentang setting ini">
                    @error('description')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
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
                                <option value="{{ $key }}" {{ old('group', 'general') === $key ? 'selected' : '' }}>{{ $label }}</option>
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
                                <option value="{{ $key }}" {{ old('type', 'text') === $key ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                {{-- Order --}}
                <div>
                    <label for="order" class="block text-sm font-medium text-gray-700 mb-2">
                        Order
                    </label>
                    <input type="number" name="order" id="order" value="{{ old('order', 0) }}" min="0"
                        class="block w-32 px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition-colors">
                    <p class="mt-1 text-xs text-gray-500">Urutan tampilan (angka kecil = lebih atas)</p>
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
                <p class="text-sm text-gray-500 mt-1">Masukkan nilai sesuai dengan tipe yang dipilih</p>
            </div>
            
            <div class="p-6">
                {{-- Text Input --}}
                <div id="value-text" class="value-field">
                    <label for="value_text" class="block text-sm font-medium text-gray-700 mb-2">Value</label>
                    <input type="text" name="value" id="value_text" value="{{ old('value') }}"
                        class="block w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition-colors">
                </div>

                {{-- Textarea Input --}}
                <div id="value-textarea" class="value-field hidden">
                    <label for="value_textarea" class="block text-sm font-medium text-gray-700 mb-2">Value</label>
                    <textarea name="value" id="value_textarea" rows="5"
                        class="block w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition-colors">{{ old('value') }}</textarea>
                </div>

                {{-- Boolean Input --}}
                <div id="value-boolean" class="value-field hidden">
                    <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                        <div>
                            <label for="value_boolean" class="text-sm font-medium text-gray-700">Value</label>
                            <p class="text-xs text-gray-500 mt-1">Aktifkan atau nonaktifkan</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" name="value" id="value_boolean" value="1" class="sr-only peer" {{ old('value') ? 'checked' : '' }}>
                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-amber-300 rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-amber-500"></div>
                        </label>
                    </div>
                </div>

                {{-- Number Input --}}
                <div id="value-number" class="value-field hidden">
                    <label for="value_number" class="block text-sm font-medium text-gray-700 mb-2">Value</label>
                    <input type="number" name="value" id="value_number" value="{{ old('value') }}" step="any"
                        class="block w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition-colors">
                </div>

                {{-- JSON Input --}}
                <div id="value-json" class="value-field hidden">
                    <label for="value_json" class="block text-sm font-medium text-gray-700 mb-2">Value (JSON)</label>
                    <textarea name="value" id="value_json" rows="8"
                        class="block w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm font-mono focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition-colors"
                        placeholder='{"key": "value"}'>{{ old('value') }}</textarea>
                    <p class="mt-1 text-xs text-gray-500">Masukkan JSON yang valid</p>
                </div>

                {{-- Image Input --}}
                <div id="value-image" class="value-field hidden">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Image</label>
                    <div class="flex items-center justify-center w-full">
                        <label class="flex flex-col items-center justify-center w-full h-40 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100 transition-colors">
                            <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                <svg class="w-8 h-8 mb-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                <p class="mb-2 text-sm text-gray-500"><span class="font-semibold">Klik untuk upload</span> atau drag & drop</p>
                                <p class="text-xs text-gray-500">PNG, JPG, GIF, WEBP (MAX. 2MB)</p>
                            </div>
                            <input type="file" name="value" class="hidden" accept="image/*">
                        </label>
                    </div>
                </div>

                {{-- File Input --}}
                <div id="value-file" class="value-field hidden">
                    <label class="block text-sm font-medium text-gray-700 mb-2">File</label>
                    <div class="flex items-center justify-center w-full">
                        <label class="flex flex-col items-center justify-center w-full h-40 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100 transition-colors">
                            <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                <svg class="w-8 h-8 mb-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                                </svg>
                                <p class="mb-2 text-sm text-gray-500"><span class="font-semibold">Klik untuk upload</span> atau drag & drop</p>
                                <p class="text-xs text-gray-500">PDF, DOC, DOCX, XLS, XLSX (MAX. 10MB)</p>
                            </div>
                            <input type="file" name="value" class="hidden">
                        </label>
                    </div>
                </div>

                @error('value')
                    <p class="mt-2 text-sm text-red-600 flex items-center gap-1">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                        </svg>
                        {{ $message }}
                    </p>
                @enderror
            </div>
        </div>

        {{-- Action Buttons --}}
        <div class="flex items-center justify-end gap-3">
            <a href="{{ route('admin.settings.index') }}" class="inline-flex items-center justify-center gap-2 px-6 py-2.5 bg-white border border-gray-300 text-gray-700 font-medium text-sm rounded-lg hover:bg-gray-50 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
                Batal
            </a>
            <button type="submit" class="inline-flex items-center justify-center gap-2 px-6 py-2.5 bg-amber-500 hover:bg-amber-600 text-white font-medium text-sm rounded-lg transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                Simpan Setting
            </button>
        </div>
    </form>
</div>

@push('scripts')
<script>
    function updateValueField() {
        const type = document.getElementById('type').value;
        
        // Hide all value fields
        document.querySelectorAll('.value-field').forEach(el => {
            el.classList.add('hidden');
            // Disable inputs in hidden fields
            el.querySelectorAll('input, textarea').forEach(input => {
                input.disabled = true;
                input.name = '';
            });
        });
        
        // Show the selected field
        const field = document.getElementById('value-' + type);
        if (field) {
            field.classList.remove('hidden');
            // Enable and set name
            field.querySelectorAll('input, textarea').forEach(input => {
                input.disabled = false;
                input.name = 'value';
            });
        }
    }
    
    // Initialize on page load
    document.addEventListener('DOMContentLoaded', updateValueField);
</script>
@endpush
@endsection
