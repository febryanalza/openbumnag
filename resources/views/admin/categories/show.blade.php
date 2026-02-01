@extends('admin.layouts.app')

@section('title', 'Detail Kategori')
@section('page-title', 'Detail Kategori')

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Header -->
    <div class="bg-gradient-to-r from-amber-500 to-orange-600 rounded-xl shadow-lg p-6 mb-6 text-white">
        <div class="flex items-center justify-between">
            <div class="flex items-center">
                @if($category->icon)
                    <div class="flex-shrink-0 w-20 h-20 bg-white/20 rounded-xl flex items-center justify-center text-4xl">
                        <i class="{{ $category->icon }}"></i>
                    </div>
                @else
                    <div class="flex-shrink-0 w-20 h-20 bg-white/20 rounded-xl flex items-center justify-center">
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                        </svg>
                    </div>
                @endif
                <div class="ml-6">
                    <h1 class="text-2xl font-bold">{{ $category->name }}</h1>
                    <p class="text-amber-100 text-lg">{{ $category->slug }}</p>
                    <div class="flex items-center gap-3 mt-2">
                        @php
                            $typeLabels = [
                                'general' => 'Umum',
                                'news' => 'Berita',
                                'report' => 'Laporan',
                                'promotion' => 'Promosi',
                            ];
                        @endphp
                        <span class="px-3 py-1 bg-white/20 rounded-full text-sm">
                            {{ $typeLabels[$category->type] ?? $category->type }}
                        </span>
                        @if($category->is_active)
                            <span class="px-3 py-1 bg-green-500 rounded-full text-sm">Aktif</span>
                        @else
                            <span class="px-3 py-1 bg-red-500 rounded-full text-sm">Nonaktif</span>
                        @endif
                    </div>
                </div>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('admin.categories.edit', $category) }}" class="px-4 py-2 bg-white/20 hover:bg-white/30 rounded-lg transition-colors flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                    Edit
                </a>
                <a href="{{ route('admin.categories.index') }}" class="px-4 py-2 bg-white/20 hover:bg-white/30 rounded-lg transition-colors flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Kembali
                </a>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Description -->
            @if($category->description)
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Deskripsi</h3>
                    <p class="text-gray-600 leading-relaxed">{{ $category->description }}</p>
                </div>
            @endif

            <!-- Usage Stats -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Penggunaan</h3>
                <div class="grid grid-cols-3 gap-4">
                    <div class="text-center p-4 bg-blue-50 rounded-xl">
                        <div class="text-3xl font-bold text-blue-600">{{ $category->news_count ?? $category->news()->count() }}</div>
                        <div class="text-sm text-blue-600">Berita</div>
                    </div>
                    <div class="text-center p-4 bg-purple-50 rounded-xl">
                        <div class="text-3xl font-bold text-purple-600">{{ $category->reports_count ?? $category->reports()->count() }}</div>
                        <div class="text-sm text-purple-600">Laporan</div>
                    </div>
                    <div class="text-center p-4 bg-orange-50 rounded-xl">
                        <div class="text-3xl font-bold text-orange-600">{{ $category->promotions_count ?? $category->promotions()->count() }}</div>
                        <div class="text-sm text-orange-600">Promosi</div>
                    </div>
                </div>
            </div>

            <!-- Related Items -->
            @if($category->news()->count() > 0)
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Berita Terkait</h3>
                    <div class="space-y-3">
                        @foreach($category->news()->latest()->take(5)->get() as $news)
                            <a href="{{ route('admin.news.show', $news) }}" class="block p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                                <div class="font-medium text-gray-900">{{ $news->title }}</div>
                                <div class="text-sm text-gray-500">{{ $news->created_at->format('d M Y') }}</div>
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Category Info -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Informasi</h3>
                <dl class="space-y-4">
                    <div>
                        <dt class="text-sm text-gray-500">Urutan</dt>
                        <dd class="mt-1 text-lg font-medium text-gray-900">{{ $category->order }}</dd>
                    </div>
                    @if($category->color)
                        <div>
                            <dt class="text-sm text-gray-500">Warna</dt>
                            <dd class="mt-1 flex items-center gap-2">
                                <div class="w-6 h-6 rounded-full border border-gray-300" style="background-color: {{ $category->color }}"></div>
                                <span class="text-sm font-mono text-gray-700">{{ $category->color }}</span>
                            </dd>
                        </div>
                    @endif
                    @if($category->icon)
                        <div>
                            <dt class="text-sm text-gray-500">Icon</dt>
                            <dd class="mt-1 flex items-center gap-2">
                                <i class="{{ $category->icon }} text-xl text-gray-600"></i>
                                <span class="text-sm font-mono text-gray-700">{{ $category->icon }}</span>
                            </dd>
                        </div>
                    @endif
                </dl>
            </div>

            <!-- Timestamps -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Waktu</h3>
                <dl class="space-y-4">
                    <div>
                        <dt class="text-sm text-gray-500">Dibuat</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $category->created_at->format('d M Y, H:i') }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm text-gray-500">Diperbarui</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $category->updated_at->format('d M Y, H:i') }}</dd>
                    </div>
                    @if($category->deleted_at)
                        <div>
                            <dt class="text-sm text-gray-500">Dihapus</dt>
                            <dd class="mt-1 text-sm text-red-600">{{ $category->deleted_at->format('d M Y, H:i') }}</dd>
                        </div>
                    @endif
                </dl>
            </div>

            <!-- Quick Actions -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Aksi Cepat</h3>
                <div class="space-y-3">
                    @if($category->is_active)
                        <form method="POST" action="{{ route('admin.categories.bulk-action') }}">
                            @csrf
                            <input type="hidden" name="action" value="deactivate">
                            <input type="hidden" name="ids[]" value="{{ $category->id }}">
                            <button type="submit" class="w-full px-4 py-2 bg-yellow-100 text-yellow-700 rounded-lg hover:bg-yellow-200 transition-colors flex items-center justify-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/>
                                </svg>
                                Nonaktifkan
                            </button>
                        </form>
                    @else
                        <form method="POST" action="{{ route('admin.categories.bulk-action') }}">
                            @csrf
                            <input type="hidden" name="action" value="activate">
                            <input type="hidden" name="ids[]" value="{{ $category->id }}">
                            <button type="submit" class="w-full px-4 py-2 bg-green-100 text-green-700 rounded-lg hover:bg-green-200 transition-colors flex items-center justify-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                Aktifkan
                            </button>
                        </form>
                    @endif
                    <a href="{{ route('admin.categories.edit', $category) }}" class="w-full px-4 py-2 bg-amber-100 text-amber-700 rounded-lg hover:bg-amber-200 transition-colors flex items-center justify-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                        Edit Kategori
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
