@extends('admin.layouts.app')

@section('title', 'Detail Berita')
@section('page-title', 'Detail Berita')

@section('content')
<div class="max-w-5xl mx-auto">
    <!-- Breadcrumb -->
    <nav class="mb-6">
        <ol class="flex items-center space-x-2 text-sm text-gray-500">
            <li><a href="{{ route('admin.dashboard') }}" class="hover:text-amber-600">Dashboard</a></li>
            <li><span class="mx-2">/</span></li>
            <li><a href="{{ route('admin.news.index') }}" class="hover:text-amber-600">Berita</a></li>
            <li><span class="mx-2">/</span></li>
            <li class="text-gray-900 font-medium">Detail</li>
        </ol>
    </nav>

    <!-- News Header -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden mb-6">
        @if($news->featured_image)
            <div class="relative h-64 md:h-80">
                <img src="{{ Storage::url($news->featured_image) }}" alt="{{ $news->title }}" class="w-full h-full object-cover">
                <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                <div class="absolute bottom-0 left-0 right-0 p-6 text-white">
                    <div class="flex items-center gap-2 mb-2">
                        @php
                            $statusColors = [
                                'draft' => 'bg-gray-500',
                                'published' => 'bg-green-500',
                                'archived' => 'bg-red-500',
                            ];
                        @endphp
                        <span class="px-2 py-1 rounded-full text-xs font-medium {{ $statusColors[$news->status] ?? 'bg-gray-500' }}">
                            {{ $statuses[$news->status] ?? $news->status }}
                        </span>
                        @if($news->is_featured)
                            <span class="px-2 py-1 rounded-full text-xs font-medium bg-yellow-500 text-yellow-900">
                                <svg class="w-3 h-3 inline mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                </svg>
                                Unggulan
                            </span>
                        @endif
                        @if($news->category)
                            <span class="px-2 py-1 rounded-full text-xs font-medium bg-blue-500">
                                {{ $news->category->name }}
                            </span>
                        @endif
                    </div>
                    <h1 class="text-2xl md:text-3xl font-bold">{{ $news->title }}</h1>
                </div>
            </div>
        @else
            <div class="p-6 bg-gradient-to-r from-blue-600 to-indigo-700 text-white">
                <div class="flex items-center gap-2 mb-2">
                    @php
                        $statusColors = [
                            'draft' => 'bg-gray-500',
                            'published' => 'bg-green-500',
                            'archived' => 'bg-red-500',
                        ];
                    @endphp
                    <span class="px-2 py-1 rounded-full text-xs font-medium {{ $statusColors[$news->status] ?? 'bg-gray-500' }}">
                        {{ $statuses[$news->status] ?? $news->status }}
                    </span>
                    @if($news->is_featured)
                        <span class="px-2 py-1 rounded-full text-xs font-medium bg-yellow-500 text-yellow-900">Unggulan</span>
                    @endif
                    @if($news->category)
                        <span class="px-2 py-1 rounded-full text-xs font-medium bg-white/30">{{ $news->category->name }}</span>
                    @endif
                </div>
                <h1 class="text-2xl md:text-3xl font-bold">{{ $news->title }}</h1>
            </div>
        @endif

        <!-- Meta Info -->
        <div class="p-6 border-b border-gray-200">
            <div class="flex flex-wrap items-center gap-6 text-sm text-gray-600">
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                    <span>{{ $news->user->name ?? 'Unknown' }}</span>
                </div>
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    @if($news->published_at)
                        <span>{{ $news->published_at->format('d M Y, H:i') }}</span>
                    @else
                        <span class="text-gray-400">Belum dipublikasi</span>
                    @endif
                </div>
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                    </svg>
                    <span>{{ number_format($news->views) }} views</span>
                </div>
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span>{{ $news->reading_time }} menit baca</span>
                </div>
            </div>
        </div>

        <!-- Actions -->
        <div class="p-4 bg-gray-50 flex items-center justify-between">
            <a href="{{ route('admin.news.index') }}" class="inline-flex items-center gap-2 text-gray-600 hover:text-gray-800">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Kembali
            </a>
            <div class="flex items-center gap-2">
                <a href="{{ route('admin.news.edit', $news) }}" class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                    Edit
                </a>
                <form method="POST" action="{{ route('admin.news.destroy', $news) }}" class="inline" onsubmit="return confirm('Pindahkan berita ini ke sampah?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="inline-flex items-center gap-2 px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                        Hapus
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Excerpt -->
            @if($news->excerpt)
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-3">Ringkasan</h2>
                    <p class="text-gray-600 italic leading-relaxed">{{ $news->excerpt }}</p>
                </div>
            @endif

            <!-- Content -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Konten</h2>
                <div class="prose max-w-none text-gray-700">
                    {!! nl2br(e($news->content)) !!}
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- SEO Info -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">SEO & Meta</h2>
                <div class="space-y-4">
                    <div>
                        <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Meta Title</label>
                        <p class="text-sm text-gray-900">{{ $news->meta_title ?: $news->title }}</p>
                    </div>
                    @if($news->meta_description)
                        <div>
                            <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Meta Description</label>
                            <p class="text-sm text-gray-700">{{ $news->meta_description }}</p>
                        </div>
                    @endif
                    @if($news->meta_keywords)
                        <div>
                            <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Meta Keywords</label>
                            <div class="flex flex-wrap gap-1">
                                @foreach(explode(',', $news->meta_keywords) as $keyword)
                                    <span class="px-2 py-0.5 bg-gray-100 text-gray-600 text-xs rounded">{{ trim($keyword) }}</span>
                                @endforeach
                            </div>
                        </div>
                    @endif
                    <div>
                        <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Slug/URL</label>
                        <p class="text-sm text-amber-600 break-all">{{ $news->slug }}</p>
                    </div>
                </div>
            </div>

            <!-- Timestamps -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Informasi</h2>
                <div class="space-y-3 text-sm">
                    <div class="flex justify-between">
                        <span class="text-gray-500">ID</span>
                        <span class="text-gray-900 font-medium">#{{ $news->id }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-500">Dibuat</span>
                        <span class="text-gray-900">{{ $news->created_at->format('d M Y, H:i') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-500">Diperbarui</span>
                        <span class="text-gray-900">{{ $news->updated_at->format('d M Y, H:i') }}</span>
                    </div>
                    @if($news->published_at)
                        <div class="flex justify-between">
                            <span class="text-gray-500">Dipublikasi</span>
                            <span class="text-gray-900">{{ $news->published_at->format('d M Y, H:i') }}</span>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Aksi Cepat</h2>
                <div class="space-y-2">
                    @if($news->status !== 'published')
                        <form method="POST" action="{{ route('admin.news.bulk-action') }}">
                            @csrf
                            <input type="hidden" name="action" value="publish">
                            <input type="hidden" name="ids[]" value="{{ $news->id }}">
                            <button type="submit" class="w-full px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors text-sm">
                                Publikasikan Sekarang
                            </button>
                        </form>
                    @endif
                    @if(!$news->is_featured)
                        <form method="POST" action="{{ route('admin.news.bulk-action') }}">
                            @csrf
                            <input type="hidden" name="action" value="feature">
                            <input type="hidden" name="ids[]" value="{{ $news->id }}">
                            <button type="submit" class="w-full px-4 py-2 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600 transition-colors text-sm">
                                Jadikan Unggulan
                            </button>
                        </form>
                    @else
                        <form method="POST" action="{{ route('admin.news.bulk-action') }}">
                            @csrf
                            <input type="hidden" name="action" value="unfeature">
                            <input type="hidden" name="ids[]" value="{{ $news->id }}">
                            <button type="submit" class="w-full px-4 py-2 border border-yellow-500 text-yellow-600 rounded-lg hover:bg-yellow-50 transition-colors text-sm">
                                Hapus dari Unggulan
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

