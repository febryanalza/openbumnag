@extends('layouts.app')

@section('title', $settings['site_name'] ?? 'Beranda')
@section('description', $settings['site_description'] ?? 'BUMNag Lubas Mandiri')

@section('content')
<!-- Hero Slider Section -->
<section class="relative h-screen overflow-hidden" x-data="heroSlider()">
    <!-- Slider Container -->
    <div class="absolute inset-0">
        @if($heroImages && count($heroImages) > 0)
        <div class="relative h-full w-full flex" 
             :style="`transform: translateX(-${currentSlide * 100}%); transition: transform 0.8s cubic-bezier(0.4, 0, 0.2, 1);`">
            @foreach($heroImages as $index => $image)
            <div class="relative min-w-full h-full">
                <img src="{{ Storage::url($image->file_path) }}" 
                     alt="{{ $image->title }}" 
                     class="w-full h-full object-cover">
                <div class="absolute inset-0 bg-gradient-to-r from-black/70 via-black/50 to-transparent"></div>
            </div>
            @endforeach
        </div>
        @else
        <!-- Fallback jika tidak ada gambar -->
        <div class="relative h-full w-full">
            <div class="w-full h-full bg-gradient-to-br from-primary via-sage to-mint"></div>
            <div class="absolute inset-0 bg-gradient-to-r from-black/70 via-black/50 to-transparent"></div>
        </div>
        @endif
    </div>
    
    <!-- Hero Content -->
    <div class="relative h-full flex items-center">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full">
            <div class="max-w-3xl">
                <h1 class="text-5xl md:text-6xl lg:text-7xl font-bold text-white mb-6 leading-tight"
                    data-aos="fade-up">
                    {{ $settings['hero_title'] ?? 'Selamat Datang di' }}<br>
                    <span class="text-secondary">{{ $settings['hero_subtitle'] ?? 'Lubas Mandiri' }}</span>
                </h1>
                <p class="text-xl md:text-2xl text-white/90 mb-8 leading-relaxed"
                   data-aos="fade-up" data-aos-delay="100">
                    {{ $settings['hero_description'] ?? 'Badan Usaha Milik Nagari yang berkomitmen untuk kesejahteraan masyarakat' }}
                </p>
                <div class="flex flex-wrap gap-4" data-aos="fade-up" data-aos-delay="200">
                    <a href="{{ route('about') }}" 
                       class="inline-flex items-center px-8 py-4 bg-primary text-white font-semibold rounded-full hover:bg-primary-600 transition-all duration-200 shadow-xl hover:shadow-2xl hover:-translate-y-1">
                        Tentang Kami
                        <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                        </svg>
                    </a>
                    <a href="#unit-usaha" 
                       class="inline-flex items-center px-8 py-4 bg-white text-primary font-semibold rounded-full hover:bg-gray-50 transition-all duration-200 shadow-xl hover:shadow-2xl hover:-translate-y-1">
                        Unit Usaha
                    </a>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Slider Controls -->
    @if($heroImages && count($heroImages) > 1)
    <div class="absolute bottom-10 left-0 right-0 z-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between">
                <!-- Indicators -->
                <div class="flex space-x-3">
                    @foreach($heroImages as $index => $image)
                    <button @click="goToSlide({{ $index }})" 
                            :class="currentSlide === {{ $index }} ? 'w-12 bg-secondary' : 'w-3 bg-white/50'"
                            class="h-3 rounded-full transition-all duration-300 hover:bg-white">
                    </button>
                    @endforeach
                </div>
                
                <!-- Navigation Arrows -->
                <div class="flex space-x-3">
                    <button @click="previousSlide" 
                            class="w-12 h-12 rounded-full bg-white/20 backdrop-blur-sm text-white flex items-center justify-center hover:bg-white/30 transition-all duration-200">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                        </svg>
                    </button>
                    <button @click="nextSlide" 
                            class="w-12 h-12 rounded-full bg-white/20 backdrop-blur-sm text-white flex items-center justify-center hover:bg-white/30 transition-all duration-200">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endif
</section>

<!-- Unit Usaha Section -->
<section id="unit-usaha" class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4">
                {{ $settings['about_title'] ?? 'Unit Usaha Kami' }}
            </h2>
            <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                {{ $settings['about_description'] ?? 'Berbagai unit usaha yang kami kelola' }}
            </p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($bumnagProfiles as $profile)
            <div class="group bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden hover:-translate-y-2">
                @if($profile->banner)
                <div class="h-56 overflow-hidden">
                    <img src="{{ Storage::url($profile->banner) }}" 
                         alt="{{ $profile->name }}" 
                         class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                </div>
                @elseif($profile->logo)
                <div class="h-56 bg-gradient-to-br from-primary to-sage flex items-center justify-center p-8">
                    <img src="{{ Storage::url($profile->logo) }}" 
                         alt="{{ $profile->name }}" 
                         class="max-h-full max-w-full object-contain">
                </div>
                @else
                <div class="h-56 bg-gradient-to-br from-primary to-sage flex items-center justify-center">
                    <svg class="w-20 h-20 text-white/50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                </div>
                @endif
                
                <div class="p-6">
                    @if($profile->tagline)
                    <div class="inline-block px-3 py-1 bg-secondary/10 text-secondary rounded-full text-sm font-medium mb-3">
                        {{ $profile->tagline }}
                    </div>
                    @endif
                    <h3 class="text-2xl font-bold text-gray-900 mb-3 group-hover:text-primary transition-colors duration-200">
                        {{ $profile->name }}
                    </h3>
                    @if($profile->about)
                    <p class="text-gray-600 mb-4 line-clamp-3">
                        {{ Str::limit(strip_tags($profile->about), 150) }}
                    </p>
                    @endif
                    <a href="{{ route('bumnag.show', $profile->slug) }}" 
                       class="inline-flex items-center text-primary font-semibold hover:text-primary-600 transition-colors duration-200">
                        Selengkapnya
                        <svg class="w-5 h-5 ml-2 group-hover:translate-x-1 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                        </svg>
                    </a>
                </div>
            </div>
            @endforeach
        </div>
        
        <div class="text-center mt-12">
            <a href="{{ route('about') }}" 
               class="inline-flex items-center px-8 py-4 bg-primary text-white font-semibold rounded-full hover:bg-primary-600 transition-all duration-200 shadow-lg hover:shadow-xl">
                Lihat Semua Unit Usaha
                <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                </svg>
            </a>
        </div>
    </div>
</section>

<!-- Berita Section -->
<section class="py-20 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-end mb-12">
            <div>
                <h2 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4">
                    {{ $settings['news_title'] ?? 'Berita Terbaru' }}
                </h2>
                <p class="text-xl text-gray-600">
                    {{ $settings['news_description'] ?? 'Informasi dan update terkini' }}
                </p>
            </div>
            <a href="{{ route('news.index') }}" 
               class="hidden md:inline-flex items-center text-primary font-semibold hover:text-primary-600 transition-colors duration-200">
                Lihat Semua
                <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                </svg>
            </a>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($latestNews as $news)
            <article class="bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden group hover:-translate-y-2">
                @if($news->featured_image)
                <div class="h-56 overflow-hidden">
                    <img src="{{ Storage::url($news->featured_image) }}" 
                         alt="{{ $news->title }}" 
                         class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                </div>
                @else
                <div class="h-56 bg-gradient-to-br from-sage to-mint flex items-center justify-center">
                    <svg class="w-20 h-20 text-white/50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                    </svg>
                </div>
                @endif
                
                <div class="p-6">
                    <div class="flex items-center justify-between mb-3">
                        @if($news->category)
                        <span class="inline-block px-3 py-1 bg-primary/10 text-primary rounded-full text-xs font-medium">
                            {{ $news->category->name }}
                        </span>
                        @endif
                        <span class="text-sm text-gray-500">
                            {{ $news->published_at->format('d M Y') }}
                        </span>
                    </div>
                    
                    <h3 class="text-xl font-bold text-gray-900 mb-3 line-clamp-2 group-hover:text-primary transition-colors duration-200">
                        {{ $news->title }}
                    </h3>
                    
                    <!-- Excerpt -->
                    @if($news->excerpt)
                    <p class="text-gray-600 mb-4 line-clamp-3">
                        {{ $news->excerpt }}
                    </p>
                    @endif
                    
                    <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                        <a href="{{ route('news.show', $news->slug) }}" 
                           class="inline-flex items-center text-primary font-semibold hover:text-primary-600 transition-colors duration-200">
                            Baca Selengkapnya
                            <svg class="w-4 h-4 ml-2 group-hover:translate-x-1 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </a>
                        
                        <div class="flex items-center text-sm text-gray-500">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                            {{ number_format($news->views ?? 0) }}
                        </div>
                    </div>
                </div>
            </article>
            @endforeach
        </div>
        
        <div class="text-center mt-12 md:hidden">
            <a href="{{ route('news.index') }}" 
               class="inline-flex items-center px-8 py-4 bg-primary text-white font-semibold rounded-full hover:bg-primary-600 transition-all duration-200 shadow-lg hover:shadow-xl">
                Lihat Semua Berita
                <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                </svg>
            </a>
        </div>
    </div>
</section>

<!-- Laporan Section -->
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-end mb-12">
            <div>
                <h2 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4">
                    {{ $settings['reports_title'] ?? 'Laporan & Transparansi' }}
                </h2>
                <p class="text-xl text-gray-600">
                    {{ $settings['reports_description'] ?? 'Laporan keuangan dan kegiatan' }}
                </p>
            </div>
            <a href="{{ route('reports.index') }}" 
               class="hidden md:inline-flex items-center text-primary font-semibold hover:text-primary-600 transition-colors duration-200">
                Lihat Semua
                <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                </svg>
            </a>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($latestReports as $report)
            <div class="bg-gradient-to-br from-sage-50 to-mint-50 rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden group hover:-translate-y-2 border border-sage-100">
                <div class="p-8">
                    <div class="w-16 h-16 bg-primary rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    
                    <div class="flex items-center gap-2 mb-3">
                        <span class="inline-block px-3 py-1 bg-secondary/10 text-secondary rounded-full text-xs font-medium">
                            {{ $report->type }}
                        </span>
                        <span class="text-sm text-gray-500">
                            {{ $report->year }}
                        </span>
                    </div>
                    
                    <h3 class="text-xl font-bold text-gray-900 mb-3 group-hover:text-primary transition-colors duration-200">
                        {{ $report->title }}
                    </h3>
                    
                    <p class="text-gray-600 mb-6 line-clamp-2">
                        {{ $report->description }}
                    </p>
                    
                    <div class="flex items-center gap-3">
                        <a href="{{ route('reports.show', $report->slug) }}" 
                           class="flex-1 inline-flex items-center justify-center px-4 py-2.5 bg-primary text-white font-medium rounded-lg hover:bg-primary-600 transition-all duration-200">
                            Lihat Detail
                            <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                        </a>
                        @if($report->file_path)
                        <a href="{{ Storage::url($report->file_path) }}" 
                           target="_blank"
                           class="inline-flex items-center justify-center w-12 h-11 bg-sage text-white rounded-lg hover:bg-sage-600 transition-all duration-200">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </a>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        
        <div class="text-center mt-12">
            <a href="{{ route('reports.index') }}" 
               class="inline-flex items-center px-8 py-4 bg-sage text-white font-semibold rounded-full hover:bg-sage-600 transition-all duration-200 shadow-lg hover:shadow-xl">
                Lihat Semua Laporan
                <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                </svg>
            </a>
        </div>
    </div>
</section>

<!-- Kodai (Katalog Produk) Section -->
@if($featuredCatalogs->count() > 0)
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-end mb-12">
            <div>
                <h2 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4">
                    {{ $settings['catalog_title'] ?? 'Kodai Kami' }}
                </h2>
                <p class="text-xl text-gray-600">
                    {{ $settings['catalog_description'] ?? 'Produk-produk berkualitas dari unit usaha kami' }}
                </p>
            </div>
            <a href="{{ route('catalogs.index') }}" 
               class="hidden md:inline-flex items-center text-primary font-semibold hover:text-primary-600 transition-colors duration-200">
                Lihat Semua
                <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </a>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($featuredCatalogs as $catalog)
            <article class="bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden group hover:-translate-y-2">
                <a href="{{ route('catalogs.show', $catalog->slug) }}" class="block relative">
                    @if($catalog->featured_image)
                    <div class="h-56 overflow-hidden">
                        <img src="{{ Storage::url($catalog->featured_image) }}" 
                             alt="{{ $catalog->name }}" 
                             class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                    </div>
                    @else
                    <div class="h-56 bg-gradient-to-br from-mint-100 to-sage-100 flex items-center justify-center">
                        <svg class="w-20 h-20 text-sage-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                        </svg>
                    </div>
                    @endif
                    
                    <!-- Featured Badge -->
                    @if($catalog->is_featured)
                    <div class="absolute top-4 right-4 bg-secondary text-white px-3 py-1 rounded-full text-xs font-semibold flex items-center gap-1">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                        </svg>
                        Unggulan
                    </div>
                    @endif
                    
                    <!-- Stock Badge -->
                    @if($catalog->stock === 0)
                    <div class="absolute top-4 left-4 bg-red-500 text-white px-3 py-1 rounded-full text-xs font-semibold">
                        Stok Habis
                    </div>
                    @elseif($catalog->stock < 10)
                    <div class="absolute top-4 left-4 bg-orange-500 text-white px-3 py-1 rounded-full text-xs font-semibold">
                        Stok Terbatas
                    </div>
                    @endif
                </a>
                
                <div class="p-6">
                    <div class="flex items-center justify-between mb-3">
                        <span class="inline-block px-3 py-1 bg-primary/10 text-primary text-xs font-semibold rounded-full">
                            {{ $catalog->bumnagProfile->name }}
                        </span>
                        @if($catalog->category)
                        <span class="text-xs text-gray-500">
                            {{ $catalog->category }}
                        </span>
                        @endif
                    </div>
                    
                    <h3 class="text-xl font-bold text-gray-900 mb-3 line-clamp-2 group-hover:text-primary transition-colors duration-200">
                        <a href="{{ route('catalogs.show', $catalog->slug) }}">
                            {{ $catalog->name }}
                        </a>
                    </h3>
                    
                    @if($catalog->description)
                    <p class="text-gray-600 mb-4 line-clamp-3">
                        {{ Str::limit(strip_tags($catalog->description), 150) }}
                    </p>
                    @endif
                    
                    <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                        <div>
                            <div class="text-2xl font-bold text-primary">
                                {{ $catalog->formatted_price }}
                            </div>
                            @if($catalog->unit && $catalog->price)
                            <div class="text-xs text-gray-500">
                                per {{ $catalog->unit }}
                            </div>
                            @endif
                        </div>
                        <a href="{{ route('catalogs.show', $catalog->slug) }}" 
                           class="inline-flex items-center px-4 py-2 bg-primary text-white text-sm font-semibold rounded-lg hover:bg-primary-600 transition-colors duration-200">
                            Lihat Detail
                            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </a>
                    </div>
                </div>
            </article>
            @endforeach
        </div>
        
        <div class="text-center mt-12 md:hidden">
            <a href="{{ route('catalogs.index') }}" 
               class="inline-flex items-center px-8 py-4 bg-primary text-white font-semibold rounded-full hover:bg-primary-600 transition-all duration-200 shadow-lg hover:shadow-xl">
                Lihat Semua Produk
                <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </a>
        </div>
    </div>
</section>
@endif

<!-- CTA Section -->
<section class="py-20 bg-gradient-to-r from-primary to-sage-600 text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-4xl md:text-5xl font-bold mb-6">
            {{ $settings['cta_title'] ?? 'Mari Berkembang Bersama' }}
        </h2>
        <p class="text-xl text-white/90 max-w-2xl mx-auto mb-10">
            {{ $settings['cta_description'] ?? 'Bergabunglah dengan kami dalam membangun ekonomi nagari' }}
        </p>
        <div class="flex flex-wrap justify-center gap-4">
            <a href="{{ route('home') }}#kontak" 
               class="inline-flex items-center px-8 py-4 bg-white text-primary font-semibold rounded-full hover:bg-gray-50 transition-all duration-200 shadow-xl hover:shadow-2xl hover:-translate-y-1">
                Hubungi Kami
                <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                </svg>
            </a>
            <a href="{{ route('about') }}" 
               class="inline-flex items-center px-8 py-4 bg-secondary text-white font-semibold rounded-full hover:bg-secondary-600 transition-all duration-200 shadow-xl hover:shadow-2xl hover:-translate-y-1">
                Pelajari Lebih Lanjut
            </a>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
    function heroSlider() {
        return {
            currentSlide: 0,
            totalSlides: {{ count($heroImages) }},
            autoplayInterval: null,
            
            init() {
                this.startAutoplay();
            },
            
            nextSlide() {
                this.currentSlide = (this.currentSlide + 1) % this.totalSlides;
                this.resetAutoplay();
            },
            
            previousSlide() {
                this.currentSlide = (this.currentSlide - 1 + this.totalSlides) % this.totalSlides;
                this.resetAutoplay();
            },
            
            goToSlide(index) {
                this.currentSlide = index;
                this.resetAutoplay();
            },
            
            startAutoplay() {
                this.autoplayInterval = setInterval(() => {
                    this.nextSlide();
                }, {{ $settings['hero_autoplay_duration'] ?? 5000 }});
            },
            
            resetAutoplay() {
                clearInterval(this.autoplayInterval);
                this.startAutoplay();
            }
        }
    }
</script>
@endpush
