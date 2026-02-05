@extends('layouts.app')

@section('title', $settings['site_name'] ?? 'Beranda')
@section('description', $settings['site_description'] ?? 'BUMNag Lubas Mandiri')

@section('content')
<!-- Hero Slider Section -->
<section class="relative h-[100svh] min-h-[500px] max-h-[900px] overflow-hidden" x-data="heroSlider()">
    <!-- Slider Container -->
    <div class="absolute inset-0">
        @if($heroImages && count($heroImages) > 0)
        <div class="relative h-full w-full flex" 
             :style="`transform: translateX(-${currentSlide * 100}%); transition: transform 0.8s cubic-bezier(0.4, 0, 0.2, 1);`">
            @foreach($heroImages as $index => $image)
            @php
                // Support both object (from CacheService) and array format
                if (is_object($image)) {
                    $imagePath = $image->file_path ?? '';
                    $imageTitle = $image->title ?? 'Hero Slide ' . ($index + 1);
                } else {
                    $imagePath = $image['path'] ?? (is_string($image) ? $image : '');
                    $imageTitle = $image['title'] ?? 'Hero Slide ' . ($index + 1);
                }
            @endphp
            <div class="relative min-w-full h-full">
                <img src="{{ Storage::url($imagePath) }}" 
                     alt="{{ $imageTitle }}" 
                     class="w-full h-full object-cover"
                     loading="{{ $index === 0 ? 'eager' : 'lazy' }}">
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
                <h1 class="text-3xl xs:text-4xl sm:text-5xl md:text-6xl lg:text-7xl font-bold text-white mb-4 sm:mb-6 leading-tight"
                    data-aos="fade-up">
                    {{ $settings['hero_title'] ?? 'Selamat Datang di' }}<br>
                    <span class="text-secondary">{{ $settings['hero_subtitle'] ?? 'Lubas Mandiri' }}</span>
                </h1>
                <p class="text-base xs:text-lg sm:text-xl md:text-2xl text-white/90 mb-6 sm:mb-8 leading-relaxed max-w-2xl"
                   data-aos="fade-up" data-aos-delay="100">
                    {{ $settings['hero_description'] ?? 'Badan Usaha Milik Nagari yang berkomitmen untuk kesejahteraan masyarakat' }}
                </p>
                <div class="flex flex-col xs:flex-row flex-wrap gap-3 sm:gap-4" data-aos="fade-up" data-aos-delay="200">
                    <a href="{{ $settings['hero_cta_primary_link'] ?? route('catalogs.index') }}" 
                       class="inline-flex items-center justify-center px-6 sm:px-8 py-3 sm:py-4 bg-primary text-white font-semibold rounded-full hover:bg-primary-600 transition-all duration-200 shadow-xl hover:shadow-2xl hover:-translate-y-1 text-sm sm:text-base">
                        {{ $settings['hero_cta_primary_text'] ?? 'Jelajahi Produk' }}
                        <svg class="w-4 h-4 sm:w-5 sm:h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                        </svg>
                    </a>
                    <a href="{{ $settings['hero_cta_secondary_link'] ?? route('about') }}" 
                       class="inline-flex items-center justify-center px-6 sm:px-8 py-3 sm:py-4 bg-white text-primary font-semibold rounded-full hover:bg-gray-50 transition-all duration-200 shadow-xl hover:shadow-2xl hover:-translate-y-1 text-sm sm:text-base">
                        {{ $settings['hero_cta_secondary_text'] ?? 'Tentang Kami' }}
                    </a>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Slider Controls -->
    @if($heroImages && count($heroImages) > 1)
    <div class="absolute bottom-6 sm:bottom-10 left-0 right-0 z-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between">
                <!-- Indicators -->
                <div class="flex space-x-2 sm:space-x-3">
                    @foreach($heroImages as $index => $image)
                    <button @click="goToSlide({{ $index }})" 
                            :class="currentSlide === {{ $index }} ? 'w-8 sm:w-12 bg-secondary' : 'w-2 sm:w-3 bg-white/50'"
                            class="h-2 sm:h-3 rounded-full transition-all duration-300 hover:bg-white touch-target">
                    </button>
                    @endforeach
                </div>
                
                <!-- Navigation Arrows -->
                <div class="flex space-x-2 sm:space-x-3">
                    <button @click="previousSlide" 
                            class="w-10 h-10 sm:w-12 sm:h-12 rounded-full bg-white/20 backdrop-blur-sm text-white flex items-center justify-center hover:bg-white/30 transition-all duration-200 touch-target">
                        <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                        </svg>
                    </button>
                    <button @click="nextSlide" 
                            class="w-10 h-10 sm:w-12 sm:h-12 rounded-full bg-white/20 backdrop-blur-sm text-white flex items-center justify-center hover:bg-white/30 transition-all duration-200 touch-target">
                        <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
<section id="unit-usaha" class="py-12 sm:py-16 lg:py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-10 sm:mb-16">
            <h2 class="text-2xl xs:text-3xl sm:text-4xl md:text-5xl font-bold text-gray-900 mb-3 sm:mb-4">
                {{ $settings['about_title'] ?? 'Unit Usaha Kami' }}
            </h2>
            <p class="text-base sm:text-lg md:text-xl text-gray-600 max-w-2xl mx-auto px-4">
                {{ $settings['about_description'] ?? 'Berbagai unit usaha yang kami kelola' }}
            </p>
        </div>
        
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6 lg:gap-8">
            @foreach($bumnagProfiles as $profile)
            <div class="group bg-white rounded-xl sm:rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden hover:-translate-y-2">
                @if($profile->banner)
                <div class="h-40 sm:h-48 lg:h-56 overflow-hidden">
                    <img src="{{ Storage::url($profile->banner) }}" 
                         alt="{{ $profile->name }}" 
                         class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500"
                         loading="lazy">
                </div>
                @elseif($profile->logo)
                <div class="h-40 sm:h-48 lg:h-56 bg-gradient-to-br from-primary to-sage flex items-center justify-center p-6 sm:p-8">
                    <img src="{{ Storage::url($profile->logo) }}" 
                         alt="{{ $profile->name }}" 
                         class="max-h-full max-w-full object-contain"
                         loading="lazy">
                </div>
                @else
                <div class="h-40 sm:h-48 lg:h-56 bg-gradient-to-br from-primary to-sage flex items-center justify-center">
                    <svg class="w-14 h-14 sm:w-20 sm:h-20 text-white/50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                </div>
                @endif
                
                <div class="p-4 sm:p-6">
                    @if($profile->tagline)
                    <div class="inline-block px-2 sm:px-3 py-1 bg-secondary/10 text-secondary rounded-full text-xs sm:text-sm font-medium mb-2 sm:mb-3">
                        {{ $profile->tagline }}
                    </div>
                    @endif
                    <h3 class="text-lg sm:text-xl lg:text-2xl font-bold text-gray-900 mb-2 sm:mb-3 group-hover:text-primary transition-colors duration-200">
                        {{ $profile->name }}
                    </h3>
                    @if($profile->about)
                    <p class="text-sm sm:text-base text-gray-600 mb-3 sm:mb-4 line-clamp-3">
                        {{ Str::limit(strip_tags($profile->about), 150) }}
                    </p>
                    @endif
                    <a href="{{ route('bumnag.show', $profile->slug) }}" 
                       class="inline-flex items-center text-primary font-semibold hover:text-primary-600 transition-colors duration-200 text-sm sm:text-base">
                        Selengkapnya
                        <svg class="w-4 h-4 sm:w-5 sm:h-5 ml-2 group-hover:translate-x-1 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                        </svg>
                    </a>
                </div>
            </div>
            @endforeach
        </div>
        
        <div class="text-center mt-8 sm:mt-12">
            <a href="{{ route('about') }}" 
               class="inline-flex items-center px-6 sm:px-8 py-3 sm:py-4 bg-primary text-white font-semibold rounded-full hover:bg-primary-600 transition-all duration-200 shadow-lg hover:shadow-xl text-sm sm:text-base">
                {{ $settings['about_cta_text'] ?? 'Lihat Semua Unit Usaha' }}
                <svg class="w-4 h-4 sm:w-5 sm:h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                </svg>
            </a>
        </div>
    </div>
</section>

<!-- Berita Section -->
<section class="py-12 sm:py-16 lg:py-20 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-end mb-8 sm:mb-12 gap-4">
            <div>
                <h2 class="text-2xl xs:text-3xl sm:text-4xl md:text-5xl font-bold text-gray-900 mb-2 sm:mb-4">
                    {{ $settings['news_title'] ?? 'Berita Terbaru' }}
                </h2>
                <p class="text-base sm:text-lg md:text-xl text-gray-600">
                    {{ $settings['news_description'] ?? 'Informasi dan update terkini' }}
                </p>
            </div>
            <a href="{{ route('news.index') }}" 
               class="hidden sm:inline-flex items-center text-primary font-semibold hover:text-primary-600 transition-colors duration-200 whitespace-nowrap">
                {{ $settings['news_cta_text'] ?? 'Lihat Semua Berita' }}
                <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                </svg>
            </a>
        </div>
        
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6 lg:gap-8">
            @foreach($latestNews as $news)
            <article class="bg-white rounded-xl sm:rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden group hover:-translate-y-2">
                @if($news->featured_image)
                <div class="h-40 sm:h-48 lg:h-56 overflow-hidden">
                    <img src="{{ Storage::url($news->featured_image) }}" 
                         alt="{{ $news->title }}" 
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
                
                <div class="p-4 sm:p-6">
                    <div class="flex flex-wrap items-center justify-between gap-2 mb-2 sm:mb-3">
                        @if($news->category)
                        <span class="inline-block px-2 sm:px-3 py-1 bg-primary/10 text-primary rounded-full text-xs font-medium">
                            {{ $news->category->name }}
                        </span>
                        @endif
                        <span class="text-xs sm:text-sm text-gray-500">
                            {{ $news->published_at->format('d M Y') }}
                        </span>
                    </div>
                    
                    <h3 class="text-base sm:text-lg lg:text-xl font-bold text-gray-900 mb-2 sm:mb-3 line-clamp-2 group-hover:text-primary transition-colors duration-200">
                        {{ $news->title }}
                    </h3>
                    
                    <!-- Excerpt -->
                    @if($news->excerpt)
                    <p class="text-sm sm:text-base text-gray-600 mb-3 sm:mb-4 line-clamp-2 sm:line-clamp-3">
                        {{ $news->excerpt }}
                    </p>
                    @endif
                    
                    <div class="flex items-center justify-between pt-3 sm:pt-4 border-t border-gray-100">
                        <a href="{{ route('news.show', $news->slug) }}" 
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
                            {{ number_format($news->views ?? 0) }}
                        </div>
                    </div>
                </div>
            </article>
            @endforeach
        </div>
        
        <div class="text-center mt-8 sm:mt-12 sm:hidden">
            <a href="{{ route('news.index') }}" 
               class="inline-flex items-center px-6 sm:px-8 py-3 sm:py-4 bg-primary text-white font-semibold rounded-full hover:bg-primary-600 transition-all duration-200 shadow-lg hover:shadow-xl text-sm sm:text-base">
                {{ $settings['news_cta_text'] ?? 'Lihat Semua Berita' }}
                <svg class="w-4 h-4 sm:w-5 sm:h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                </svg>
            </a>
        </div>
    </div>
</section>

<!-- Promosi Section -->
@if($promotions->count() > 0)
<section class="py-12 sm:py-16 lg:py-20 bg-gradient-to-br from-amber-50 to-orange-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-end mb-8 sm:mb-12 gap-4">
            <div>
                <h2 class="text-2xl xs:text-3xl sm:text-4xl md:text-5xl font-bold text-gray-900 mb-2 sm:mb-4">
                    {{ $settings['promotion_title'] ?? 'Promo Spesial' }}
                </h2>
                <p class="text-base sm:text-lg md:text-xl text-gray-600">
                    {{ $settings['promotion_description'] ?? 'Penawaran menarik dari unit usaha kami' }}
                </p>
            </div>
            <a href="{{ route('promotions.index') }}" 
               class="hidden sm:inline-flex items-center text-primary font-semibold hover:text-primary-600 transition-colors duration-200 whitespace-nowrap">
                {{ $settings['promotion_cta_text'] ?? 'Lihat Semua Promo' }}
                <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                </svg>
            </a>
        </div>
        
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6 lg:gap-8">
            @foreach($promotions as $promotion)
            <article class="bg-white rounded-xl sm:rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden group hover:-translate-y-2 border-2 border-amber-200">
                <a href="{{ route('promotions.show', $promotion->slug) }}" class="block relative">
                    @if($promotion->featured_image)
                    <div class="h-40 sm:h-48 lg:h-56 overflow-hidden relative">
                        <img src="{{ Storage::url($promotion->featured_image) }}" 
                             alt="{{ $promotion->title }}" 
                             class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500"
                             loading="lazy">
                        <!-- Overlay gradient for better text readability -->
                        <div class="absolute inset-0 bg-gradient-to-t from-black/50 via-transparent to-transparent"></div>
                    </div>
                    @else
                    <div class="h-40 sm:h-48 lg:h-56 bg-gradient-to-br from-amber-400 via-orange-400 to-red-400 flex items-center justify-center">
                        <svg class="w-14 h-14 sm:w-16 sm:h-16 lg:w-20 lg:h-20 text-white/50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7"></path>
                        </svg>
                    </div>
                    @endif
                    
                    <!-- Promo Badge -->
                    <div class="absolute top-2 right-2 sm:top-4 sm:right-4 bg-red-500 text-white px-2 sm:px-3 py-1 rounded-full text-xs font-bold flex items-center gap-1 shadow-lg animate-pulse">
                        <svg class="w-3 h-3 sm:w-4 sm:h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                        </svg>
                        PROMO
                    </div>
                    
                    <!-- Discount Badge (if applicable) -->
                    @if($promotion->discount_percentage)
                    <div class="absolute top-2 left-2 sm:top-4 sm:left-4 bg-gradient-to-r from-red-600 to-pink-600 text-white px-3 sm:px-4 py-1.5 sm:py-2 rounded-lg text-sm sm:text-base font-bold shadow-lg">
                        {{ $promotion->discount_percentage }}% OFF
                    </div>
                    @endif
                </a>
                
                <div class="p-4 sm:p-6">
                    <div class="flex flex-wrap items-center justify-between gap-2 mb-2 sm:mb-3">
                        @if($promotion->category)
                        <span class="inline-block px-2 sm:px-3 py-1 bg-amber-100 text-amber-800 text-xs font-semibold rounded-full truncate max-w-[140px] sm:max-w-none">
                            {{ $promotion->category->name }}
                        </span>
                        @endif
                        
                        <!-- Validity Period -->
                        @if($promotion->end_date)
                        <span class="flex items-center text-xs text-gray-500">
                            <svg class="w-3 h-3 sm:w-4 sm:h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            s/d {{ \Carbon\Carbon::parse($promotion->end_date)->format('d M Y') }}
                        </span>
                        @endif
                    </div>
                    
                    <h3 class="text-base sm:text-lg lg:text-xl font-bold text-gray-900 mb-2 sm:mb-3 line-clamp-2 group-hover:text-primary transition-colors duration-200">
                        <a href="{{ route('promotions.show', $promotion->slug) }}">
                            {{ $promotion->title }}
                        </a>
                    </h3>
                    
                    @if($promotion->description)
                    <p class="text-sm sm:text-base text-gray-600 mb-3 sm:mb-4 line-clamp-2 sm:line-clamp-3">
                        {{ Str::limit(strip_tags($promotion->description), 100) }}
                    </p>
                    @endif
                    
                    <div class="flex items-center justify-between pt-3 sm:pt-4 border-t border-gray-100">
                        <!-- Terms & Conditions hint -->
                        <div class="text-xs text-gray-500 flex items-center">
                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            S&K berlaku
                        </div>
                        
                        <a href="{{ route('promotions.show', $promotion->slug) }}" 
                           class="inline-flex items-center px-3 sm:px-4 py-2 bg-gradient-to-r from-amber-500 to-orange-500 text-white text-xs sm:text-sm font-semibold rounded-lg hover:from-amber-600 hover:to-orange-600 transition-all duration-200 shadow-md hover:shadow-lg touch-target">
                            <span class="hidden xs:inline">Lihat </span>Detail
                            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </a>
                    </div>
                </div>
            </article>
            @endforeach
        </div>
        
        <div class="text-center mt-8 sm:mt-12">
            <a href="{{ route('promotions.index') }}" 
               class="inline-flex items-center px-6 sm:px-8 py-3 sm:py-4 bg-gradient-to-r from-amber-600 to-orange-600 text-white font-semibold rounded-full hover:from-amber-700 hover:to-orange-700 transition-all duration-200 shadow-lg hover:shadow-xl text-sm sm:text-base">
                {{ $settings['promotion_cta_text'] ?? 'Lihat Semua Promo' }}
                <svg class="w-4 h-4 sm:w-5 sm:h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                </svg>
            </a>
        </div>
    </div>
</section>
@endif

<!-- Laporan Section -->
<section class="py-12 sm:py-16 lg:py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-end mb-8 sm:mb-12 gap-4">
            <div>
                <h2 class="text-2xl xs:text-3xl sm:text-4xl md:text-5xl font-bold text-gray-900 mb-2 sm:mb-4">
                    {{ $settings['reports_title'] ?? 'Laporan & Transparansi' }}
                </h2>
                <p class="text-base sm:text-lg md:text-xl text-gray-600">
                    {{ $settings['reports_description'] ?? 'Laporan keuangan dan kegiatan' }}
                </p>
            </div>
            <a href="{{ route('reports.index') }}" 
               class="hidden sm:inline-flex items-center text-primary font-semibold hover:text-primary-600 transition-colors duration-200 whitespace-nowrap">
                {{ $settings['reports_cta_text'] ?? 'Lihat Semua Laporan' }}
                <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                </svg>
            </a>
        </div>
        
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6 lg:gap-8">
            @foreach($latestReports as $report)
            <div class="bg-gradient-to-br from-sage-50 to-mint-50 rounded-xl sm:rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden group hover:-translate-y-2 border border-sage-100">
                <div class="p-5 sm:p-6 lg:p-8">
                    <div class="w-12 h-12 sm:w-14 sm:h-14 lg:w-16 lg:h-16 bg-primary rounded-xl sm:rounded-2xl flex items-center justify-center mb-4 sm:mb-6 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-6 h-6 sm:w-7 sm:h-7 lg:w-8 lg:h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    
                    <div class="flex flex-wrap items-center gap-2 mb-2 sm:mb-3">
                        <span class="inline-block px-2 sm:px-3 py-1 bg-secondary/10 text-secondary rounded-full text-xs font-medium">
                            {{ $report->type }}
                        </span>
                        <span class="text-xs sm:text-sm text-gray-500">
                            {{ $report->year }}
                        </span>
                    </div>
                    
                    <h3 class="text-lg sm:text-xl font-bold text-gray-900 mb-2 sm:mb-3 group-hover:text-primary transition-colors duration-200 line-clamp-2">
                        {{ $report->title }}
                    </h3>
                    
                    <p class="text-sm sm:text-base text-gray-600 mb-4 sm:mb-6 line-clamp-2">
                        {{ $report->description }}
                    </p>
                    
                    <div class="flex items-center gap-2 sm:gap-3">
                        <a href="{{ route('reports.show', $report->slug) }}" 
                           class="flex-1 inline-flex items-center justify-center px-3 sm:px-4 py-2 sm:py-2.5 bg-primary text-white font-medium rounded-lg hover:bg-primary-600 transition-all duration-200 text-sm sm:text-base">
                            Lihat Detail
                            <svg class="w-4 h-4 ml-2 hidden xs:inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                        </a>
                        @if($report->file_path)
                        <a href="{{ Storage::url($report->file_path) }}" 
                           target="_blank"
                           class="inline-flex items-center justify-center w-10 h-10 sm:w-12 sm:h-11 bg-sage text-white rounded-lg hover:bg-sage-600 transition-all duration-200 touch-target">
                            <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </a>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        
        <div class="text-center mt-8 sm:mt-12">
            <a href="{{ route('reports.index') }}" 
               class="inline-flex items-center px-6 sm:px-8 py-3 sm:py-4 bg-sage text-white font-semibold rounded-full hover:bg-sage-600 transition-all duration-200 shadow-lg hover:shadow-xl text-sm sm:text-base">
                {{ $settings['reports_cta_text'] ?? 'Lihat Semua Laporan' }}
                <svg class="w-4 h-4 sm:w-5 sm:h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                </svg>
            </a>
        </div>
    </div>
</section>

<!-- Kadai (Katalog Produk) Section -->
@if($featuredCatalogs->count() > 0)
<section class="py-12 sm:py-16 lg:py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-end mb-8 sm:mb-12 gap-4">
            <div>
                <h2 class="text-2xl xs:text-3xl sm:text-4xl md:text-5xl font-bold text-gray-900 mb-2 sm:mb-4">
                    {{ $settings['catalog_title'] ?? 'Kodai Kami' }}
                </h2>
                <p class="text-base sm:text-lg md:text-xl text-gray-600">
                    {{ $settings['catalog_description'] ?? 'Produk-produk berkualitas dari unit usaha kami' }}
                </p>
            </div>
            <a href="{{ route('catalogs.index') }}" 
               class="hidden sm:inline-flex items-center text-primary font-semibold hover:text-primary-600 transition-colors duration-200 whitespace-nowrap">
                {{ $settings['catalog_cta_text'] ?? 'Lihat Semua Produk' }}
                <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </a>
        </div>
        
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6 lg:gap-8">
            @foreach($featuredCatalogs as $catalog)
            <article class="bg-white rounded-xl sm:rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden group hover:-translate-y-2">
                <a href="{{ route('catalogs.show', $catalog->slug) }}" class="block relative">
                    @if($catalog->featured_image)
                    <div class="h-40 sm:h-48 lg:h-56 overflow-hidden">
                        <img src="{{ Storage::url($catalog->featured_image) }}" 
                             alt="{{ $catalog->name }}" 
                             class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500"
                             loading="lazy">
                    </div>
                    @else
                    <div class="h-40 sm:h-48 lg:h-56 bg-gradient-to-br from-mint-100 to-sage-100 flex items-center justify-center">
                        <svg class="w-14 h-14 sm:w-16 sm:h-16 lg:w-20 lg:h-20 text-sage-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                        </svg>
                    </div>
                    @endif
                    
                    <!-- Featured Badge -->
                    @if($catalog->is_featured)
                    <div class="absolute top-2 right-2 sm:top-4 sm:right-4 bg-secondary text-white px-2 sm:px-3 py-1 rounded-full text-xs font-semibold flex items-center gap-1">
                        <svg class="w-3 h-3 sm:w-4 sm:h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                        </svg>
                        <span class="hidden xs:inline">Unggulan</span>
                    </div>
                    @endif
                    
                    <!-- Stock Badge -->
                    @if($catalog->stock === 0)
                    <div class="absolute top-2 left-2 sm:top-4 sm:left-4 bg-red-500 text-white px-2 sm:px-3 py-1 rounded-full text-xs font-semibold">
                        Stok Habis
                    </div>
                    @elseif($catalog->stock < 10)
                    <div class="absolute top-2 left-2 sm:top-4 sm:left-4 bg-orange-500 text-white px-2 sm:px-3 py-1 rounded-full text-xs font-semibold">
                        <span class="hidden xs:inline">Stok </span>Terbatas
                    </div>
                    @endif
                </a>
                
                <div class="p-4 sm:p-6">
                    <div class="flex flex-wrap items-center justify-between gap-2 mb-2 sm:mb-3">
                        <span class="inline-block px-2 sm:px-3 py-1 bg-primary/10 text-primary text-xs font-semibold rounded-full truncate max-w-[140px] sm:max-w-none">
                            {{ $catalog->bumnagProfile->name }}
                        </span>
                        @if($catalog->category)
                        <span class="text-xs text-gray-500">
                            {{ $catalog->category }}
                        </span>
                        @endif
                    </div>
                    
                    <h3 class="text-base sm:text-lg lg:text-xl font-bold text-gray-900 mb-2 sm:mb-3 line-clamp-2 group-hover:text-primary transition-colors duration-200">
                        <a href="{{ route('catalogs.show', $catalog->slug) }}">
                            {{ $catalog->name }}
                        </a>
                    </h3>
                    
                    @if($catalog->description)
                    <p class="text-sm sm:text-base text-gray-600 mb-3 sm:mb-4 line-clamp-2 sm:line-clamp-3">
                        {{ Str::limit(strip_tags($catalog->description), 100) }}
                    </p>
                    @endif
                    
                    <div class="flex items-center justify-between pt-3 sm:pt-4 border-t border-gray-100">
                        <div>
                            <div class="text-lg sm:text-xl lg:text-2xl font-bold text-primary">
                                {{ $catalog->formatted_price }}
                            </div>
                            @if($catalog->unit && $catalog->price)
                            <div class="text-xs text-gray-500">
                                per {{ $catalog->unit }}
                            </div>
                            @endif
                        </div>
                        <a href="{{ route('catalogs.show', $catalog->slug) }}" 
                           class="inline-flex items-center px-3 sm:px-4 py-2 bg-primary text-white text-xs sm:text-sm font-semibold rounded-lg hover:bg-primary-600 transition-colors duration-200 touch-target">
                            <span class="hidden xs:inline">Lihat </span>Detail
                            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </a>
                    </div>
                </div>
            </article>
            @endforeach
        </div>
        
        <div class="text-center mt-8 sm:mt-12 sm:hidden">
            <a href="{{ route('catalogs.index') }}" 
               class="inline-flex items-center px-6 sm:px-8 py-3 sm:py-4 bg-primary text-white font-semibold rounded-full hover:bg-primary-600 transition-all duration-200 shadow-lg hover:shadow-xl text-sm sm:text-base">
                {{ $settings['catalog_cta_text'] ?? 'Lihat Semua Produk' }}
                <svg class="w-4 h-4 sm:w-5 sm:h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </a>
        </div>
    </div>
</section>
@endif

<!-- CTA Section -->
<section class="py-12 sm:py-16 lg:py-20 bg-gradient-to-r from-primary to-sage-600 text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-2xl xs:text-3xl sm:text-4xl md:text-5xl font-bold mb-4 sm:mb-6">
            {{ $settings['cta_title'] ?? 'Mari Berkembang Bersama' }}
        </h2>
        <p class="text-base sm:text-lg md:text-xl text-white/90 max-w-2xl mx-auto mb-6 sm:mb-8 lg:mb-10 px-4">
            {{ $settings['cta_description'] ?? 'Bergabunglah dengan kami dalam membangun ekonomi nagari' }}
        </p>
        <div class="flex flex-col xs:flex-row flex-wrap justify-center gap-3 sm:gap-4">
            <a href="https://wa.me/{{ $globalSettings['contact_whatsapp'] ?? '6281234567890' }}" 
               target="_blank"
               rel="noopener noreferrer"
               class="inline-flex items-center justify-center px-6 sm:px-8 py-3 sm:py-4 bg-white text-primary font-semibold rounded-full hover:bg-gray-50 transition-all duration-200 shadow-xl hover:shadow-2xl hover:-translate-y-1 text-sm sm:text-base">
                {{ $settings['cta_primary_text'] ?? 'Hubungi Kami' }}
                <svg class="w-4 h-4 sm:w-5 sm:h-5 ml-2" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/>
                </svg>
            </a>
            <a href="{{ $settings['cta_secondary_link'] ?? route('about') }}" 
               class="inline-flex items-center justify-center px-6 sm:px-8 py-3 sm:py-4 bg-secondary text-white font-semibold rounded-full hover:bg-secondary-600 transition-all duration-200 shadow-xl hover:shadow-2xl hover:-translate-y-1 text-sm sm:text-base">
                {{ $settings['cta_secondary_text'] ?? 'Pelajari Lebih Lanjut' }}
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
