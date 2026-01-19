@extends('layouts.app')

@section('title', 'Beranda')
@section('description', 'BUMNag Lubas Mandiri - Badan Usaha Milik Nagari yang berkomitmen untuk kesejahteraan masyarakat Desa Lubas')

@section('content')
<!-- Hero Slider Section -->
<section class="relative h-screen" x-data="heroSlider()">
    <div class="absolute inset-0">
        @foreach($heroImages as $index => $image)
        <div x-show="currentSlide === {{ $index }}"
             x-transition:enter="transition ease-out duration-1000"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-500"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="absolute inset-0">
            <img src="{{ Storage::url($image->file_path) }}" 
                 alt="{{ $image->title }}" 
                 class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-gradient-to-r from-black/70 via-black/50 to-transparent"></div>
        </div>
        @endforeach
    </div>
    
    <!-- Hero Content -->
    <div class="relative h-full flex items-center">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full">
            <div class="max-w-3xl">
                <h1 class="text-5xl md:text-6xl lg:text-7xl font-bold text-white mb-6 leading-tight"
                    data-aos="fade-up">
                    Selamat Datang di<br>
                    <span class="text-secondary">Lubas Mandiri</span>
                </h1>
                <p class="text-xl md:text-2xl text-white/90 mb-8 leading-relaxed"
                   data-aos="fade-up" data-aos-delay="100">
                    Badan Usaha Milik Nagari yang berkomitmen untuk meningkatkan kesejahteraan masyarakat Desa Lubas melalui berbagai unit usaha yang berkelanjutan
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
</section>

<!-- Unit Usaha Section -->
<section id="unit-usaha" class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4">
                Unit Usaha Kami
            </h2>
            <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                Berbagai unit usaha yang kami kelola untuk meningkatkan perekonomian masyarakat
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
                    <a href="{{ route('about') }}#{{ $profile->slug }}" 
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
                    Berita Terbaru
                </h2>
                <p class="text-xl text-gray-600">
                    Informasi dan update terkini dari Lubas Mandiri
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
                    
                    <p class="text-gray-600 mb-4 line-clamp-3">
                        {{ strip_tags($news->excerpt ?? $news->content) }}
                    </p>
                    
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
                    Laporan & Transparansi
                </h2>
                <p class="text-xl text-gray-600">
                    Laporan keuangan dan kegiatan untuk transparansi dan akuntabilitas
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

<!-- CTA Section -->
<section class="py-20 bg-gradient-to-r from-primary to-sage-600 text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-4xl md:text-5xl font-bold mb-6">
            Mari Berkembang Bersama
        </h2>
        <p class="text-xl text-white/90 max-w-2xl mx-auto mb-10">
            Bergabunglah dengan kami dalam membangun ekonomi nagari yang lebih kuat dan berkelanjutan
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
                }, 5000);
            },
            
            resetAutoplay() {
                clearInterval(this.autoplayInterval);
                this.startAutoplay();
            }
        }
    }
</script>
@endpush
