@extends('layouts.app')

@section('title', $promotion->title)
@section('description', strip_tags(Str::limit($promotion->description, 160)))

@section('content')
<!-- Breadcrumb -->
<nav class="bg-gray-50 py-3 sm:py-4 mt-16 sm:mt-20 border-b">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <ol class="flex items-center flex-wrap gap-1 sm:gap-2 text-xs sm:text-sm">
            <li><a href="{{ route('home') }}" class="text-gray-600 hover:text-amber-600">Beranda</a></li>
            <li class="text-gray-400">/</li>
            <li><a href="{{ route('promotions.index') }}" class="text-gray-600 hover:text-amber-600">Promo</a></li>
            <li class="text-gray-400">/</li>
            <li class="text-gray-900 font-medium truncate max-w-[150px] xs:max-w-[200px] sm:max-w-none">{{ $promotion->title }}</li>
        </ol>
    </div>
</nav>

<!-- Promotion Detail -->
<section class="py-8 sm:py-10 lg:py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 sm:gap-8 lg:gap-12" x-data="{ currentImage: '{{ $promotion->featured_image ? Storage::url($promotion->featured_image) : '/images/placeholder.jpg' }}' }">
            <!-- Promotion Images -->
            <div>
                <!-- Main Image -->
                <div class="mb-3 sm:mb-4 rounded-xl sm:rounded-2xl overflow-hidden bg-gradient-to-br from-amber-100 to-orange-100 shadow-xl">
                    <div class="relative">
                        <img :src="currentImage" 
                             alt="{{ $promotion->title }}" 
                             class="w-full h-64 sm:h-80 lg:h-96 object-cover">
                        
                        <!-- Promo Badge Overlay -->
                        <div class="absolute top-4 right-4 bg-red-500 text-white px-4 py-2 rounded-full text-sm font-bold flex items-center gap-2 shadow-lg animate-pulse">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                            </svg>
                            PROMO
                        </div>

                        @if($promotion->discount_percentage)
                        <div class="absolute top-4 left-4 bg-gradient-to-r from-red-600 to-pink-600 text-white px-5 py-3 rounded-xl text-lg font-bold shadow-lg">
                            {{ $promotion->discount_percentage }}% OFF
                        </div>
                        @endif

                        <!-- Expired Overlay -->
                        @if($promotion->end_date && \Carbon\Carbon::parse($promotion->end_date)->isPast())
                        <div class="absolute inset-0 bg-black/70 flex items-center justify-center">
                            <div class="text-center">
                                <div class="bg-gray-800 text-white px-6 py-3 rounded-xl font-bold text-xl mb-2">
                                    Promo Telah Berakhir
                                </div>
                                <p class="text-white text-sm">Berakhir pada {{ \Carbon\Carbon::parse($promotion->end_date)->format('d F Y') }}</p>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
                
                <!-- Image Thumbnails -->
                @if(($promotion->images && is_array($promotion->images) && count($promotion->images) > 0) || $promotion->featured_image)
                <div class="grid grid-cols-4 gap-2 sm:gap-3">
                    @if($promotion->featured_image)
                    <button @click="currentImage = '{{ Storage::url($promotion->featured_image) }}'"
                            class="rounded-lg overflow-hidden border-2 transition-colors"
                            :class="currentImage === '{{ Storage::url($promotion->featured_image) }}' ? 'border-amber-500' : 'border-gray-200 hover:border-amber-500'">
                        <img src="{{ Storage::url($promotion->featured_image) }}" 
                             alt="{{ $promotion->title }}" 
                             class="w-full h-16 sm:h-20 lg:h-24 object-cover">
                    </button>
                    @endif
                    @if($promotion->images && is_array($promotion->images))
                    @foreach($promotion->images as $image)
                    <button @click="currentImage = '{{ Storage::url($image) }}'"
                            class="rounded-lg overflow-hidden border-2 transition-colors"
                            :class="currentImage === '{{ Storage::url($image) }}' ? 'border-amber-500' : 'border-gray-200 hover:border-amber-500'">
                        <img src="{{ Storage::url($image) }}" 
                             alt="{{ $promotion->title }}" 
                             class="w-full h-16 sm:h-20 lg:h-24 object-cover">
                    </button>
                    @endforeach
                    @endif
                </div>
                @endif
            </div>
            
            <!-- Promotion Info -->
            <div>
                <!-- Category Badge -->
                @if($promotion->category)
                <a href="{{ route('promotions.index', ['category' => $promotion->category->id]) }}" 
                   class="inline-block px-3 sm:px-4 py-1.5 sm:py-2 bg-amber-100 text-amber-800 text-xs sm:text-sm font-semibold rounded-full hover:bg-amber-200 transition-colors mb-3 sm:mb-4">
                    {{ $promotion->category->name }}
                </a>
                @endif
                
                <!-- Promotion Title -->
                <h1 class="text-2xl xs:text-3xl sm:text-4xl font-bold text-gray-900 mb-3 sm:mb-4">
                    {{ $promotion->title }}
                </h1>
                
                <!-- Validity Period -->
                @if($promotion->start_date || $promotion->end_date)
                <div class="mb-4 sm:mb-6 p-4 sm:p-5 bg-gradient-to-br from-amber-50 to-orange-50 rounded-xl border-2 border-amber-200">
                    <h3 class="font-semibold text-gray-900 mb-2 flex items-center gap-2">
                        <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        Periode Promo
                    </h3>
                    <div class="text-sm sm:text-base text-gray-700">
                        @if($promotion->start_date)
                        <p>Mulai: <span class="font-semibold">{{ \Carbon\Carbon::parse($promotion->start_date)->format('d F Y') }}</span></p>
                        @endif
                        @if($promotion->end_date)
                        <p>Berakhir: <span class="font-semibold">{{ \Carbon\Carbon::parse($promotion->end_date)->format('d F Y') }}</span></p>
                        @endif
                        
                        @if($promotion->end_date && !\Carbon\Carbon::parse($promotion->end_date)->isPast())
                        <div class="mt-2 text-amber-700 font-semibold flex items-center gap-1">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                            </svg>
                            Tersisa {{ \Carbon\Carbon::parse($promotion->end_date)->diffForHumans() }}
                        </div>
                        @endif
                    </div>
                </div>
                @endif
                
                <!-- Discount Info -->
                @if($promotion->discount_percentage || $promotion->discount_amount)
                <div class="mb-4 sm:mb-6 p-4 sm:p-5 bg-gradient-to-r from-red-50 to-pink-50 rounded-xl border-2 border-red-200">
                    <h3 class="font-semibold text-gray-900 mb-2 flex items-center gap-2">
                        <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Diskon
                    </h3>
                    <div class="text-2xl sm:text-3xl font-bold text-red-600">
                        @if($promotion->discount_percentage)
                        {{ $promotion->discount_percentage }}% OFF
                        @elseif($promotion->discount_amount)
                        Rp {{ number_format($promotion->discount_amount, 0, ',', '.') }}
                        @endif
                    </div>
                </div>
                @endif
                
                <!-- Description -->
                @if($promotion->description)
                <div class="mb-6 sm:mb-8">
                    <h2 class="text-lg sm:text-xl font-bold text-gray-900 mb-3 sm:mb-4">Detail Promo</h2>
                    <div class="prose prose-sm max-w-none text-gray-600 text-sm sm:text-base">
                        {!! $promotion->description !!}
                    </div>
                </div>
                @endif
                
                <!-- Terms & Conditions -->
                @if($promotion->terms_conditions)
                <div class="mb-6 sm:mb-8 p-4 sm:p-5 bg-gray-50 rounded-xl border border-gray-200">
                    <h3 class="font-semibold text-gray-900 mb-3 flex items-center gap-2">
                        <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        Syarat & Ketentuan
                    </h3>
                    <div class="prose prose-sm max-w-none text-gray-600 text-sm">
                        {!! $promotion->terms_conditions !!}
                    </div>
                </div>
                @endif
                
                <!-- Contact Buttons -->
                @if(!$promotion->end_date || !\Carbon\Carbon::parse($promotion->end_date)->isPast())
                <div class="space-y-2 sm:space-y-3">
                    <a href="https://wa.me/{{ $globalSettings['contact_whatsapp'] ?? '62812345678' }}?text=Halo, saya tertarik dengan promo {{ $promotion->title }}" 
                       target="_blank"
                       class="w-full flex items-center justify-center gap-2 px-4 sm:px-6 py-3 sm:py-4 bg-green-600 text-white font-semibold rounded-xl hover:bg-green-700 transition-colors duration-200 text-sm sm:text-base touch-target shadow-lg hover:shadow-xl">
                        <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/>
                        </svg>
                        Klaim Promo via WhatsApp
                    </a>
                    @if($globalSettings['contact_phone'])
                    <a href="tel:{{ $globalSettings['contact_phone'] }}" 
                       class="w-full flex items-center justify-center gap-2 px-4 sm:px-6 py-3 sm:py-4 bg-gradient-to-r from-amber-600 to-orange-600 text-white font-semibold rounded-xl hover:from-amber-700 hover:to-orange-700 transition-all duration-200 text-sm sm:text-base touch-target shadow-lg hover:shadow-xl">
                        <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                        </svg>
                        Hubungi via Telepon
                    </a>
                    @endif
                </div>
                @else
                <div class="p-4 bg-red-50 border border-red-200 rounded-xl text-center">
                    <p class="text-red-600 font-semibold">Promo ini telah berakhir</p>
                    <p class="text-sm text-gray-600 mt-1">Lihat promo lainnya yang masih tersedia</p>
                </div>
                @endif
                
                <!-- Share -->
                <div class="mt-6 sm:mt-8 pt-4 sm:pt-6 border-t border-gray-200">
                    <p class="text-xs sm:text-sm text-gray-600 mb-2 sm:mb-3">Bagikan promo ini:</p>
                    <div class="flex gap-2">
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(route('promotions.show', $promotion->slug)) }}" 
                           target="_blank"
                           class="w-9 h-9 sm:w-10 sm:h-10 bg-blue-600 text-white rounded-full flex items-center justify-center hover:bg-blue-700 touch-target">
                            <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                            </svg>
                        </a>
                        <a href="https://wa.me/?text={{ urlencode($promotion->title . ' - ' . route('promotions.show', $promotion->slug)) }}" 
                           target="_blank"
                           class="w-9 h-9 sm:w-10 sm:h-10 bg-green-600 text-white rounded-full flex items-center justify-center hover:bg-green-700 touch-target">
                            <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654z"/>
                            </svg>
                        </a>
                        <a href="https://twitter.com/intent/tweet?text={{ urlencode($promotion->title) }}&url={{ urlencode(route('promotions.show', $promotion->slug)) }}" 
                           target="_blank"
                           class="w-9 h-9 sm:w-10 sm:h-10 bg-gray-800 text-white rounded-full flex items-center justify-center hover:bg-gray-900 touch-target">
                            <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Related Promotions -->
@if($relatedPromotions->count() > 0)
<section class="py-10 sm:py-12 lg:py-16 bg-gradient-to-br from-amber-50 to-orange-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-xl sm:text-2xl lg:text-3xl font-bold text-gray-900 mb-6 sm:mb-8">
            Promo Lainnya @if($promotion->category) dari {{ $promotion->category->name }} @endif
        </h2>
        
        <div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4 lg:gap-6">
            @foreach($relatedPromotions as $relatedPromo)
            <div class="bg-white rounded-lg sm:rounded-xl shadow-md hover:shadow-xl transition-all duration-300 overflow-hidden group hover:-translate-y-1 border-2 border-amber-100">
                <a href="{{ route('promotions.show', $relatedPromo->slug) }}" class="block relative">
                    @if($relatedPromo->featured_image)
                    <div class="h-32 sm:h-40 lg:h-48 overflow-hidden">
                        <img src="{{ Storage::url($relatedPromo->featured_image) }}" 
                             alt="{{ $relatedPromo->title }}" 
                             class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500"
                             loading="lazy">
                    </div>
                    @else
                    <div class="h-32 sm:h-40 lg:h-48 bg-gradient-to-br from-amber-400 to-orange-400 flex items-center justify-center">
                        <svg class="w-10 h-10 sm:w-12 sm:h-12 lg:w-16 lg:h-16 text-white/50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7"></path>
                        </svg>
                    </div>
                    @endif
                    
                    @if($relatedPromo->discount_percentage)
                    <div class="absolute top-2 left-2 bg-red-600 text-white px-2 py-1 rounded-md text-xs font-bold">
                        -{{ $relatedPromo->discount_percentage }}%
                    </div>
                    @endif
                </a>
                
                <div class="p-3 sm:p-4">
                    <h3 class="font-bold text-gray-900 text-sm sm:text-base mb-1 sm:mb-2 line-clamp-2 group-hover:text-amber-600 transition-colors">
                        <a href="{{ route('promotions.show', $relatedPromo->slug) }}">{{ $relatedPromo->title }}</a>
                    </h3>
                    @if($relatedPromo->end_date)
                    <div class="text-xs text-gray-500 flex items-center">
                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        s/d {{ \Carbon\Carbon::parse($relatedPromo->end_date)->format('d M Y') }}
                    </div>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif
@endsection
