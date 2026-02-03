@extends('layouts.app')

@section('title', 'Berita Terkini')
@section('description', 'Baca berita terkini dan informasi terbaru dari BUMNag Lubas Mandiri')

@section('content')
<!-- Page Header -->
<section class="relative bg-gradient-to-br from-primary via-sage to-sage-700 text-white py-16 sm:py-20 lg:py-24 mt-16 sm:mt-20">
    <div class="absolute inset-0 bg-black/20"></div>
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center">
            <h1 class="text-3xl xs:text-4xl sm:text-5xl lg:text-6xl font-bold mb-3 sm:mb-4">
                Berita & Informasi
            </h1>
            <p class="text-base sm:text-lg md:text-xl text-white/90 max-w-2xl mx-auto px-4">
                Ikuti perkembangan dan kegiatan terbaru dari BUMNag Lubas Mandiri
            </p>
        </div>
    </div>
</section>

<!-- Search & Filter Section -->
<section class="py-6 sm:py-8 bg-white border-b">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <form method="GET" action="{{ route('news.index') }}" class="flex flex-col gap-3 sm:gap-4">
            <div class="flex flex-col sm:flex-row gap-3 sm:gap-4">
                <!-- Search Input -->
                <div class="flex-1">
                    <div class="relative">
                        <input type="text" 
                               name="search" 
                               value="{{ request('search') }}"
                               placeholder="Cari berita..." 
                               class="w-full px-4 py-2.5 sm:py-3 pl-10 sm:pl-12 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary text-sm sm:text-base">
                        <svg class="w-4 h-4 sm:w-5 sm:h-5 text-gray-400 absolute left-3 sm:left-4 top-1/2 transform -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                </div>
                
                <!-- Category Filter -->
                <div class="w-full sm:w-48 md:w-64">
                    <select name="category" 
                            class="w-full px-4 py-2.5 sm:py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary text-sm sm:text-base">
                        <option value="">Semua Kategori</option>
                        @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                        @endforeach
                    </select>
                </div>
            </div>
            
            <div class="flex flex-col xs:flex-row gap-2 sm:gap-3">
                <!-- Submit Button -->
                <button type="submit" 
                        class="flex-1 xs:flex-none px-6 sm:px-8 py-2.5 sm:py-3 bg-primary text-white font-semibold rounded-lg hover:bg-primary-600 transition-colors duration-200 text-sm sm:text-base touch-target">
                    Filter
                </button>
                
                @if(request('search') || request('category'))
                <a href="{{ route('news.index') }}" 
                   class="flex-1 xs:flex-none px-5 sm:px-6 py-2.5 sm:py-3 bg-gray-200 text-gray-700 font-medium rounded-lg hover:bg-gray-300 transition-colors duration-200 text-center text-sm sm:text-base touch-target">
                    Reset
                </a>
                @endif
            </div>
        </form>
    </div>
</section>

<!-- News List Section -->
<section class="py-10 sm:py-12 lg:py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        @if($news->count() > 0)
            <!-- Results Info -->
            <div class="mb-6 sm:mb-8 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-2 sm:gap-4">
                <p class="text-sm sm:text-base text-gray-600">
                    Menampilkan <span class="font-semibold">{{ $news->firstItem() }}</span> 
                    - <span class="font-semibold">{{ $news->lastItem() }}</span> 
                    dari <span class="font-semibold">{{ $news->total() }}</span> berita
                </p>
                
                @if(request('search'))
                <p class="text-xs sm:text-sm text-gray-600">
                    Hasil pencarian untuk: <span class="font-semibold text-primary">{{ request('search') }}</span>
                </p>
                @endif
            </div>

            <!-- News Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6 lg:gap-8 mb-8 sm:mb-12">
                @foreach($news as $item)
                <article class="bg-white rounded-xl sm:rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden group hover:-translate-y-2">
                    <!-- Featured Image -->
                    <a href="{{ route('news.show', $item->slug) }}" class="block">
                        @if($item->featured_image)
                        <div class="h-40 sm:h-48 lg:h-56 overflow-hidden">
                            <img src="{{ Storage::url($item->featured_image) }}" 
                                 alt="{{ $item->title }}" 
                                 class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500"
                                 loading="lazy">
                        </div>
                        @else
                        <div class="h-40 sm:h-48 lg:h-56 bg-gradient-to-br from-sage to-mint flex items-center justify-center">
                            <svg class="w-14 h-14 sm:w-16 sm:h-16 lg:w-20 lg:h-20 text-white/50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                            </svg>
                        </div>
                        @endif
                    </a>
                    
                    <!-- Content -->
                    <div class="p-4 sm:p-6">
                        <!-- Meta Info -->
                        <div class="flex flex-wrap items-center justify-between gap-2 mb-2 sm:mb-3">
                            @if($item->category)
                            <span class="inline-block px-2 sm:px-3 py-1 bg-primary/10 text-primary rounded-full text-xs font-medium">
                                {{ $item->category->name }}
                            </span>
                            @endif
                            <span class="text-xs sm:text-sm text-gray-500">
                                {{ $item->published_at->format('d M Y') }}
                            </span>
                        </div>
                        
                        <!-- Title -->
                        <h3 class="text-base sm:text-lg lg:text-xl font-bold text-gray-900 mb-2 sm:mb-3 line-clamp-2 group-hover:text-primary transition-colors duration-200">
                            <a href="{{ route('news.show', $item->slug) }}">
                                {{ $item->title }}
                            </a>
                        </h3>
                        
                        <!-- Excerpt -->
                        @if($item->excerpt)
                        <p class="text-sm sm:text-base text-gray-600 mb-3 sm:mb-4 line-clamp-2 sm:line-clamp-3">
                            {{ $item->excerpt }}
                        </p>
                        @endif
                        
                        <!-- Footer -->
                        <div class="flex items-center justify-between pt-3 sm:pt-4 border-t border-gray-100">
                            <a href="{{ route('news.show', $item->slug) }}" 
                               class="inline-flex items-center text-primary font-semibold hover:text-primary-600 transition-colors duration-200 text-sm sm:text-base">
                                Baca<span class="hidden xs:inline ml-1">Selengkapnya</span>
                                <svg class="w-4 h-4 ml-2 group-hover:translate-x-1 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </a>
                            
                            <div class="flex items-center text-xs sm:text-sm text-gray-500">
                                <svg class="w-3 h-3 sm:w-4 sm:h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                                {{ number_format($item->views ?? 0) }}
                            </div>
                        </div>
                    </div>
                </article>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="flex justify-center">
                {{ $news->withQueryString()->links() }}
            </div>
        @else
            <!-- Empty State -->
            <div class="text-center py-10 sm:py-16">
                <svg class="w-16 h-16 sm:w-20 sm:h-20 lg:w-24 lg:h-24 mx-auto text-gray-300 mb-4 sm:mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                </svg>
                <h3 class="text-xl sm:text-2xl font-bold text-gray-900 mb-2">Tidak Ada Berita</h3>
                <p class="text-sm sm:text-base text-gray-600 mb-4 sm:mb-6 px-4">
                    @if(request('search') || request('category'))
                        Tidak ada berita yang sesuai dengan filter Anda. Silakan coba kata kunci lain.
                    @else
                        Belum ada berita yang dipublikasikan saat ini.
                    @endif
                </p>
                @if(request('search') || request('category'))
                <a href="{{ route('news.index') }}" 
                   class="inline-flex items-center px-5 sm:px-6 py-2.5 sm:py-3 bg-primary text-white font-semibold rounded-lg hover:bg-primary-600 transition-colors duration-200 text-sm sm:text-base">
                    Lihat Semua Berita
                </a>
                @endif
            </div>
        @endif
    </div>
</section>
@endsection

@push('styles')
<style>
    /* Custom Pagination Styles */
    nav[role="navigation"] {
        @apply flex justify-center;
    }
    
    nav[role="navigation"] .flex {
        @apply gap-2;
    }
    
    nav[role="navigation"] a,
    nav[role="navigation"] span {
        @apply px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium;
    }
    
    nav[role="navigation"] a {
        @apply bg-white text-gray-700 hover:bg-primary hover:text-white hover:border-primary transition-colors duration-200;
    }
    
    nav[role="navigation"] span[aria-current="page"] {
        @apply bg-primary text-white border-primary;
    }
    
    nav[role="navigation"] span:not([aria-current]) {
        @apply bg-gray-100 text-gray-400;
    }
</style>
@endpush
