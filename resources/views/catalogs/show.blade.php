@extends('layouts.app')

@section('title', $catalog->name)
@section('description', strip_tags(Str::limit($catalog->description, 160)))

@section('content')
<!-- Breadcrumb -->
<nav class="bg-gray-50 py-3 sm:py-4 mt-16 sm:mt-20 border-b">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <ol class="flex items-center flex-wrap gap-1 sm:gap-2 text-xs sm:text-sm">
            <li><a href="{{ route('home') }}" class="text-gray-600 hover:text-primary">Beranda</a></li>
            <li class="text-gray-400">/</li>
            <li><a href="{{ route('catalogs.index') }}" class="text-gray-600 hover:text-primary">Kodai</a></li>
            <li class="text-gray-400">/</li>
            <li class="text-gray-900 font-medium truncate max-w-[150px] xs:max-w-[200px] sm:max-w-none">{{ $catalog->name }}</li>
        </ol>
    </div>
</nav>

<!-- Product Detail -->
<section class="py-8 sm:py-10 lg:py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 sm:gap-8 lg:gap-12" x-data="{ currentImage: '{{ $catalog->featured_image ? Storage::url($catalog->featured_image) : '/images/placeholder.jpg' }}' }">
            <!-- Product Images -->
            <div>
                <!-- Main Image -->
                <div class="mb-3 sm:mb-4 rounded-xl sm:rounded-2xl overflow-hidden bg-gray-100">
                    <img :src="currentImage" 
                         alt="{{ $catalog->name }}" 
                         class="w-full h-64 sm:h-80 lg:h-96 object-cover">
                </div>
                
                <!-- Image Thumbnails -->
                @if(($catalog->images && is_array($catalog->images) && count($catalog->images) > 0) || $catalog->featured_image)
                <div class="grid grid-cols-4 gap-2 sm:gap-3">
                    @if($catalog->featured_image)
                    <button @click="currentImage = '{{ Storage::url($catalog->featured_image) }}'"
                            class="rounded-lg overflow-hidden border-2 transition-colors"
                            :class="currentImage === '{{ Storage::url($catalog->featured_image) }}' ? 'border-primary' : 'border-gray-200 hover:border-primary'">
                        <img src="{{ Storage::url($catalog->featured_image) }}" 
                             alt="{{ $catalog->name }}" 
                             class="w-full h-16 sm:h-20 lg:h-24 object-cover">
                    </button>
                    @endif
                    @if($catalog->images && is_array($catalog->images))
                    @foreach($catalog->images as $image)
                    <button @click="currentImage = '{{ Storage::url($image) }}'"
                            class="rounded-lg overflow-hidden border-2 transition-colors"
                            :class="currentImage === '{{ Storage::url($image) }}' ? 'border-primary' : 'border-gray-200 hover:border-primary'">
                        <img src="{{ Storage::url($image) }}" 
                             alt="{{ $catalog->name }}" 
                             class="w-full h-16 sm:h-20 lg:h-24 object-cover">
                    </button>
                    @endforeach
                    @endif
                </div>
                @endif
            </div>
            
            <!-- Product Info -->
            <div>
                <!-- Unit Usaha Badge -->
                <a href="{{ route('catalogs.index', ['unit_usaha' => $catalog->bumnagProfile->id]) }}" 
                   class="inline-block px-3 sm:px-4 py-1.5 sm:py-2 bg-primary/10 text-primary text-xs sm:text-sm font-semibold rounded-full hover:bg-primary/20 transition-colors mb-3 sm:mb-4">
                    {{ $catalog->bumnagProfile->name }}
                </a>
                
                <!-- Product Name -->
                <h1 class="text-2xl xs:text-3xl sm:text-4xl font-bold text-gray-900 mb-3 sm:mb-4">
                    {{ $catalog->name }}
                </h1>
                
                <!-- Category & SKU -->
                <div class="flex flex-wrap items-center gap-2 sm:gap-4 mb-4 sm:mb-6">
                    @if($catalog->category)
                    <span class="px-2 sm:px-3 py-1 bg-sage-100 text-sage-700 text-xs sm:text-sm rounded-full">
                        {{ $catalog->category }}
                    </span>
                    @endif
                    @if($catalog->sku)
                    <span class="text-gray-600 text-xs sm:text-sm">SKU: {{ $catalog->sku }}</span>
                    @endif
                </div>
                
                <!-- Price -->
                <div class="mb-4 sm:mb-6 p-4 sm:p-6 bg-gradient-to-br from-primary/5 to-sage/5 rounded-xl">
                    <div class="text-2xl sm:text-3xl font-bold text-primary mb-1 sm:mb-2">
                        {{ $catalog->formatted_price }}
                    </div>
                    @if($catalog->unit && $catalog->price)
                    <div class="text-sm sm:text-base text-gray-600">
                        per {{ $catalog->unit }}
                    </div>
                    @endif
                </div>
                
                <!-- Stock Status -->
                <div class="mb-4 sm:mb-6 flex flex-wrap items-center gap-2 sm:gap-3">
                    <span class="font-semibold text-gray-700 text-sm sm:text-base">Ketersediaan:</span>
                    @if($catalog->is_available && $catalog->stock > 0)
                        <span class="flex items-center text-green-600 font-medium text-sm sm:text-base">
                            <svg class="w-4 h-4 sm:w-5 sm:h-5 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                            Tersedia (Stok: {{ $catalog->stock }})
                        </span>
                    @else
                        <span class="flex items-center text-red-600 font-medium text-sm sm:text-base">
                            <svg class="w-4 h-4 sm:w-5 sm:h-5 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                            </svg>
                            Stok Habis
                        </span>
                    @endif
                </div>
                
                <!-- Description -->
                @if($catalog->description)
                <div class="mb-6 sm:mb-8">
                    <h2 class="text-lg sm:text-xl font-bold text-gray-900 mb-3 sm:mb-4">Deskripsi Produk</h2>
                    <div class="prose prose-sm max-w-none text-gray-600 text-sm sm:text-base">
                        {!! $catalog->description !!}
                    </div>
                </div>
                @endif
                
                <!-- Specifications -->
                @if($catalog->specifications && is_array($catalog->specifications) && count($catalog->specifications) > 0)
                <div class="mb-6 sm:mb-8">
                    <h2 class="text-lg sm:text-xl font-bold text-gray-900 mb-3 sm:mb-4">Spesifikasi</h2>
                    <dl class="grid grid-cols-1 gap-2 sm:gap-3">
                        @foreach($catalog->specifications as $key => $value)
                        <div class="flex flex-col xs:flex-row border-b border-gray-200 pb-2">
                            <dt class="font-semibold text-gray-700 text-sm sm:text-base xs:w-1/3">{{ $key }}</dt>
                            <dd class="text-gray-600 text-sm sm:text-base xs:w-2/3">{{ $value }}</dd>
                        </div>
                        @endforeach
                    </dl>
                </div>
                @endif
                
                <!-- Contact Buttons -->
                <div class="space-y-2 sm:space-y-3">
                    <a href="https://wa.me/{{ $globalSettings['contact_whatsapp'] ?? '62812345678' }}?text=Halo, saya tertarik dengan {{ $catalog->name }}" 
                       target="_blank"
                       class="w-full flex items-center justify-center gap-2 px-4 sm:px-6 py-3 sm:py-4 bg-green-600 text-white font-semibold rounded-xl hover:bg-green-700 transition-colors duration-200 text-sm sm:text-base touch-target">
                        <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/>
                        </svg>
                        Hubungi via WhatsApp
                    </a>
                    @if($globalSettings['contact_phone'])
                    <a href="tel:{{ $globalSettings['contact_phone'] }}" 
                       class="w-full flex items-center justify-center gap-2 px-4 sm:px-6 py-3 sm:py-4 bg-primary text-white font-semibold rounded-xl hover:bg-primary-600 transition-colors duration-200 text-sm sm:text-base touch-target">
                        <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                        </svg>
                        Hubungi via Telepon
                    </a>
                    @endif
                </div>
                
                <!-- Share -->
                <div class="mt-6 sm:mt-8 pt-4 sm:pt-6 border-t border-gray-200">
                    <p class="text-xs sm:text-sm text-gray-600 mb-2 sm:mb-3">Bagikan produk ini:</p>
                    <div class="flex gap-2">
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(route('catalogs.show', $catalog->slug)) }}" 
                           target="_blank"
                           class="w-9 h-9 sm:w-10 sm:h-10 bg-blue-600 text-white rounded-full flex items-center justify-center hover:bg-blue-700 touch-target">
                            <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                            </svg>
                        </a>
                        <a href="https://wa.me/?text={{ urlencode($catalog->name . ' - ' . route('catalogs.show', $catalog->slug)) }}" 
                           target="_blank"
                           class="w-9 h-9 sm:w-10 sm:h-10 bg-green-600 text-white rounded-full flex items-center justify-center hover:bg-green-700 touch-target">
                            <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981z"/>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Related Products -->
@if($relatedProducts->count() > 0)
<section class="py-10 sm:py-12 lg:py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-xl sm:text-2xl lg:text-3xl font-bold text-gray-900 mb-6 sm:mb-8">
            Produk Lainnya dari {{ $catalog->bumnagProfile->name }}
        </h2>
        
        <div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4 lg:gap-6">
            @foreach($relatedProducts as $product)
            <div class="bg-white rounded-lg sm:rounded-xl shadow-md hover:shadow-xl transition-all duration-300 overflow-hidden group hover:-translate-y-1">
                <a href="{{ route('catalogs.show', $product->slug) }}">
                    @if($product->featured_image)
                    <div class="h-32 sm:h-40 lg:h-48 overflow-hidden">
                        <img src="{{ Storage::url($product->featured_image) }}" 
                             alt="{{ $product->name }}" 
                             class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500"
                             loading="lazy">
                    </div>
                    @else
                    <div class="h-32 sm:h-40 lg:h-48 bg-gradient-to-br from-mint-100 to-sage-100 flex items-center justify-center">
                        <svg class="w-10 h-10 sm:w-12 sm:h-12 lg:w-16 lg:h-16 text-sage-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                        </svg>
                    </div>
                    @endif
                </a>
                
                <div class="p-3 sm:p-4">
                    <h3 class="font-bold text-gray-900 text-sm sm:text-base mb-1 sm:mb-2 line-clamp-2 group-hover:text-primary transition-colors">
                        <a href="{{ route('catalogs.show', $product->slug) }}">{{ $product->name }}</a>
                    </h3>
                    <div class="text-base sm:text-lg font-bold text-primary">
                        {{ $product->formatted_price }}
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- Reviews Section -->
<section class="py-10 sm:py-12 lg:py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <x-review-section 
            reviewable-type="catalog"
            :reviewable-id="$catalog->id"
            :reviews="$reviews"
            :stats="$reviewStats"
        />
    </div>
</section>
@endsection
