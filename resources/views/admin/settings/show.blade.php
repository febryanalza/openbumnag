@extends('admin.layouts.app')

@section('title', 'Detail Setting')
@section('header', 'Detail Setting')

@section('content')
<div class="max-w-4xl">
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
                    <span class="ml-1 text-sm font-medium text-gray-900 md:ml-2">{{ $setting->key }}</span>
                </div>
            </li>
        </ol>
    </nav>

    {{-- Setting Header Card --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden mb-6">
        <div class="bg-gradient-to-r from-amber-500 to-amber-600 px-6 py-8">
            <div class="flex flex-col md:flex-row items-start md:items-center gap-6">
                <div class="w-16 h-16 rounded-xl bg-white/20 backdrop-blur-sm flex items-center justify-center text-white flex-shrink-0 border-2 border-white/30">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                </div>
                <div class="flex-1 min-w-0">
                    <code class="text-2xl font-mono font-bold text-white bg-white/20 px-3 py-1 rounded-lg">{{ $setting->key }}</code>
                    @if($setting->description)
                        <p class="text-amber-100 mt-2">{{ $setting->description }}</p>
                    @endif
                    <div class="flex flex-wrap gap-2 mt-3">
                        @php
                            $groupColors = [
                                'general' => 'bg-gray-500/20 text-white border-gray-300/30',
                                'seo' => 'bg-blue-500/20 text-white border-blue-300/30',
                                'social' => 'bg-pink-500/20 text-white border-pink-300/30',
                                'contact' => 'bg-green-500/20 text-white border-green-300/30',
                                'appearance' => 'bg-purple-500/20 text-white border-purple-300/30',
                            ];
                            $typeColors = [
                                'text' => 'bg-gray-500/20 text-white border-gray-300/30',
                                'textarea' => 'bg-blue-500/20 text-white border-blue-300/30',
                                'boolean' => 'bg-green-500/20 text-white border-green-300/30',
                                'number' => 'bg-purple-500/20 text-white border-purple-300/30',
                                'json' => 'bg-amber-500/20 text-white border-amber-300/30',
                                'image' => 'bg-pink-500/20 text-white border-pink-300/30',
                                'file' => 'bg-cyan-500/20 text-white border-cyan-300/30',
                            ];
                        @endphp
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium border {{ $groupColors[$setting->group] ?? 'bg-white/20 text-white border-white/30' }}">
                            {{ $groups[$setting->group] ?? $setting->group }}
                        </span>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium border {{ $typeColors[$setting->type] ?? 'bg-white/20 text-white border-white/30' }}">
                            {{ $types[$setting->type] ?? $setting->type }}
                        </span>
                    </div>
                </div>
                <a href="{{ route('admin.settings.edit', $setting) }}" class="inline-flex items-center gap-2 px-4 py-2 bg-white text-amber-600 font-medium text-sm rounded-lg hover:bg-amber-50 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                    Edit
                </a>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
        {{-- Value Card --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                <h3 class="text-lg font-semibold text-gray-900 flex items-center gap-2">
                    <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4"></path>
                    </svg>
                    Value
                </h3>
            </div>
            <div class="p-6">
                @if($setting->type === 'boolean')
                    <div class="flex items-center gap-3">
                        @if($setting->value)
                            <div class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center">
                                <svg class="w-5 h-5 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="text-lg font-bold text-green-600">Yes / Aktif</p>
                                <p class="text-sm text-gray-500">Setting ini diaktifkan</p>
                            </div>
                        @else
                            <div class="w-10 h-10 rounded-full bg-gray-100 flex items-center justify-center">
                                <svg class="w-5 h-5 text-gray-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="text-lg font-bold text-gray-600">No / Nonaktif</p>
                                <p class="text-sm text-gray-500">Setting ini dinonaktifkan</p>
                            </div>
                        @endif
                    </div>
                @elseif($setting->type === 'image' && $setting->value)
                    <div>
                        <img src="{{ Storage::url($setting->value) }}" alt="" class="max-w-full rounded-lg shadow-lg">
                        <p class="text-sm text-gray-500 mt-2">{{ $setting->value }}</p>
                    </div>
                @elseif($setting->type === 'file' && $setting->value)
                    <a href="{{ Storage::url($setting->value) }}" target="_blank" class="inline-flex items-center gap-3 p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                        <div class="w-12 h-12 rounded-lg bg-blue-100 flex items-center justify-center">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="font-medium text-gray-900">{{ basename($setting->value) }}</p>
                            <p class="text-sm text-blue-600">Klik untuk download</p>
                        </div>
                    </a>
                @elseif($setting->type === 'json')
                    <pre class="bg-gray-900 text-green-400 p-4 rounded-lg overflow-x-auto text-sm font-mono">{{ json_encode(json_decode($setting->value), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
                @elseif($setting->type === 'textarea')
                    <div class="bg-gray-50 rounded-lg p-4">
                        <p class="text-gray-900 whitespace-pre-wrap">{{ $setting->value ?: '-' }}</p>
                    </div>
                @elseif($setting->type === 'number')
                    <p class="text-3xl font-bold text-gray-900">{{ $setting->value ?? '0' }}</p>
                @else
                    <p class="text-lg text-gray-900">{{ $setting->value ?: '-' }}</p>
                @endif
            </div>
        </div>

        {{-- Info Card --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                <h3 class="text-lg font-semibold text-gray-900 flex items-center gap-2">
                    <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Informasi
                </h3>
            </div>
            <div class="p-6 space-y-4">
                <div class="flex justify-between items-center py-3 border-b border-gray-100">
                    <span class="text-gray-500">ID</span>
                    <span class="font-medium text-gray-900">#{{ $setting->id }}</span>
                </div>
                <div class="flex justify-between items-center py-3 border-b border-gray-100">
                    <span class="text-gray-500">Key</span>
                    <code class="font-mono bg-gray-100 px-2 py-1 rounded text-amber-700">{{ $setting->key }}</code>
                </div>
                <div class="flex justify-between items-center py-3 border-b border-gray-100">
                    <span class="text-gray-500">Type</span>
                    <span class="font-medium text-gray-900">{{ $types[$setting->type] ?? $setting->type }}</span>
                </div>
                <div class="flex justify-between items-center py-3 border-b border-gray-100">
                    <span class="text-gray-500">Group</span>
                    <span class="font-medium text-gray-900">{{ $groups[$setting->group] ?? $setting->group }}</span>
                </div>
                <div class="flex justify-between items-center py-3 border-b border-gray-100">
                    <span class="text-gray-500">Order</span>
                    <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-gray-100 font-medium text-gray-900">{{ $setting->order }}</span>
                </div>
                <div class="flex justify-between items-center py-3 border-b border-gray-100">
                    <span class="text-gray-500">Dibuat</span>
                    <span class="font-medium text-gray-900">{{ $setting->created_at->format('d M Y H:i') }}</span>
                </div>
                <div class="flex justify-between items-center py-3">
                    <span class="text-gray-500">Diperbarui</span>
                    <span class="font-medium text-gray-900">{{ $setting->updated_at->format('d M Y H:i') }}</span>
                </div>
            </div>
        </div>
    </div>

    {{-- Usage Card --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden mb-6">
        <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
            <h3 class="text-lg font-semibold text-gray-900 flex items-center gap-2">
                <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path>
                </svg>
                Penggunaan dalam Kode
            </h3>
        </div>
        <div class="p-6">
            <p class="text-sm text-gray-500 mb-4">Gunakan kode berikut untuk mengakses setting ini:</p>
            <div class="bg-gray-900 rounded-lg overflow-hidden">
                <div class="flex items-center justify-between px-4 py-2 bg-gray-800 border-b border-gray-700">
                    <span class="text-sm text-gray-400">PHP / Blade</span>
                    <button onclick="copyCode(this)" class="text-xs text-gray-400 hover:text-white transition-colors">Copy</button>
                </div>
                <pre class="p-4 text-sm font-mono text-green-400 overflow-x-auto"><code>// Menggunakan helper method
$value = \App\Models\Setting::get('{{ $setting->key }}');

// Dengan default value
$value = \App\Models\Setting::get('{{ $setting->key }}', 'default');

// Di Blade template
{{ '{{' }} \App\Models\Setting::get('{{ $setting->key }}') {{ '}}' }}</code></pre>
            </div>
        </div>
    </div>

    {{-- Action Buttons --}}
    <div class="flex items-center justify-between">
        <a href="{{ route('admin.settings.index') }}" class="inline-flex items-center gap-2 text-gray-500 hover:text-gray-700 text-sm font-medium">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Kembali ke Daftar
        </a>
        
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.settings.edit', $setting) }}" class="inline-flex items-center gap-2 px-4 py-2 bg-amber-500 hover:bg-amber-600 text-white font-medium text-sm rounded-lg transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                </svg>
                Edit Setting
            </a>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function copyCode(btn) {
        const code = btn.closest('.bg-gray-900').querySelector('code').textContent;
        navigator.clipboard.writeText(code).then(() => {
            const original = btn.textContent;
            btn.textContent = 'Copied!';
            setTimeout(() => btn.textContent = original, 2000);
        });
    }
</script>
@endpush
@endsection
