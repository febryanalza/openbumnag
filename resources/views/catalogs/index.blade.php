@extends('layouts.app')

@section('title', $settings['catalog_title'] ?? 'Kodai Kami')
@section('description', $settings['catalog_description'] ?? 'Produk-produk berkualitas dari unit usaha kami')

@section('content')
<!-- Page Header -->
<section class="relative bg-gradient-to-br from-primary via-sage to-sage-700 text-white py-16 sm:py-20 lg:py-24 mt-16 sm:mt-20">
    <div class="absolute inset-0 bg-black/20"></div>
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center">
            <h1 class="text-3xl xs:text-4xl sm:text-5xl lg:text-6xl font-bold mb-3 sm:mb-4">
                {{ $settings['catalog_title'] ?? 'Kodai Kami' }}
            </h1>
            <p class="text-base sm:text-lg md:text-xl text-white/90 max-w-2xl mx-auto px-4">
                {{ $settings['catalog_description'] ?? 'Produk-produk berkualitas dari unit usaha kami' }}
            </p>
        </div>
    </div>
</section>

<!-- Search & Filter Section -->
<section class="py-6 sm:py-8 bg-white border-b">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <form method="GET" action="{{ route('catalogs.index') }}" class="flex flex-col gap-3 sm:gap-4">
            <div class="flex flex-col sm:flex-row gap-3 sm:gap-4">
                <!-- Search Input -->
                <div class="flex-1">
                    <div class="relative">
                        <input type="text" 
                               name="search" 
                               value="{{ request('search') }}"
                               placeholder="Cari produk..." 
                               class="w-full px-4 py-2.5 sm:py-3 pl-10 sm:pl-12 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary text-sm sm:text-base">
                        <svg class="w-4 h-4 sm:w-5 sm:h-5 text-gray-400 absolute left-3 sm:left-4 top-1/2 transform -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                </div>
                
                <!-- Category Filter -->
                <div class="w-full sm:w-40 md:w-48">
                    <select name="category" 
                            class="w-full px-4 py-2.5 sm:py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary text-sm sm:text-base">
                        <option value="">Semua Kategori</option>
                        @foreach($categories as $category)
                        <option value="{{ $category }}" {{ request('category') == $category ? 'selected' : '' }}>
                            {{ $category }}
                        </option>
                        @endforeach
                    </select>
                </div>
                
                <!-- Unit Usaha Filter -->
                <div class="w-full sm:w-48 md:w-56">
                    <select name="unit_usaha" 
                            class="w-full px-4 py-2.5 sm:py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary text-sm sm:text-base">
                        <option value="">Semua Unit Usaha</option>
                        @foreach($bumnagProfiles as $profile)
                        <option value="{{ $profile->id }}" {{ request('unit_usaha') == $profile->id ? 'selected' : '' }}>
                            {{ $profile->name }}
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
                
                @if(request('search') || request('category') || request('unit_usaha'))
                <a href="{{ route('catalogs.index') }}" 
                   class="flex-1 xs:flex-none px-5 sm:px-6 py-2.5 sm:py-3 bg-gray-200 text-gray-700 font-medium rounded-lg hover:bg-gray-300 transition-colors duration-200 text-center text-sm sm:text-base touch-target">
                    Reset
                </a>
                @endif
            </div>
        </form>
    </div>
</section>

<!-- Catalog Grid Section -->
<section class="py-10 sm:py-12 lg:py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        @if($catalogs->count() > 0)
            <!-- Results Info -->
            <div class="mb-6 sm:mb-8 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-2 sm:gap-4">
                <p class="text-sm sm:text-base text-gray-600">
                    Menampilkan <span class="font-semibold">{{ $catalogs->firstItem() }}</span> 
                    - <span class="font-semibold">{{ $catalogs->lastItem() }}</span> 
                    dari <span class="font-semibold">{{ $catalogs->total() }}</span> produk
                </p>
                
                @if(request('search'))
                <p class="text-xs sm:text-sm text-gray-600">
                    Hasil pencarian untuk: <span class="font-semibold text-primary">{{ request('search') }}</span>
                </p>
                @endif
            </div>

            <!-- Catalog Grid -->
            <div class="grid grid-cols-1 xs:grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-4 sm:gap-5 lg:gap-6 mb-8 sm:mb-12">
                @foreach($catalogs as $catalog)
                <div class="bg-white rounded-xl sm:rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden group hover:-translate-y-2">
                    <!-- Product Image -->
                    <a href="{{ route('catalogs.show', $catalog->slug) }}" class="block relative">
                        @if($catalog->featured_image)
                        <div class="h-44 sm:h-52 lg:h-64 overflow-hidden bg-gray-100">
                            <img src="{{ Storage::url($catalog->featured_image) }}" 
                                 alt="{{ $catalog->name }}" 
                                 class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500"
                                 loading="lazy">
                        </div>
                        @else
                        <div class="h-44 sm:h-52 lg:h-64 bg-gradient-to-br from-mint-100 to-sage-100 flex items-center justify-center">
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
                    
                    <!-- Product Info -->
                    <div class="p-4 sm:p-5">
                        <!-- Unit Usaha Badge -->
                        <div class="mb-2">
                            <span class="inline-block px-2 sm:px-3 py-1 bg-primary/10 text-primary text-xs font-semibold rounded-full truncate max-w-full">
                                {{ $catalog->bumnagProfile->name }}
                            </span>
                        </div>
                        
                        <!-- Product Name -->
                        <h3 class="text-base sm:text-lg font-bold text-gray-900 mb-1 sm:mb-2 group-hover:text-primary transition-colors duration-200 line-clamp-2">
                            <a href="{{ route('catalogs.show', $catalog->slug) }}">
                                {{ $catalog->name }}
                            </a>
                        </h3>
                        
                        <!-- Category -->
                        @if($catalog->category)
                        <p class="text-xs sm:text-sm text-gray-500 mb-2 sm:mb-3">
                            {{ $catalog->category }}
                        </p>
                        @endif
                        
                        <!-- Description -->
                        @if($catalog->description)
                        <p class="text-xs sm:text-sm text-gray-600 mb-3 sm:mb-4 line-clamp-2">
                            {{ Str::limit(strip_tags($catalog->description), 80) }}
                        </p>
                        @endif
                        
                        <!-- Price & Action -->
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
                               class="inline-flex items-center px-3 sm:px-4 py-1.5 sm:py-2 bg-primary text-white text-xs sm:text-sm font-semibold rounded-lg hover:bg-primary-600 transition-colors duration-200 touch-target">
                                Lihat
                                <svg class="w-3 h-3 sm:w-4 sm:h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="flex justify-center">
                {{ $catalogs->links() }}
            </div>
        @else
            <!-- Empty State -->
            <div class="text-center py-12 sm:py-16 lg:py-20">
                <svg class="w-16 h-16 sm:w-20 sm:h-20 lg:w-24 lg:h-24 text-gray-300 mx-auto mb-4 sm:mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                </svg>
                <h3 class="text-xl sm:text-2xl font-bold text-gray-700 mb-2">Produk Tidak Ditemukan</h3>
                <p class="text-sm sm:text-base text-gray-500 mb-6 sm:mb-8 px-4">
                    @if(request('search') || request('category') || request('unit_usaha'))
                        Tidak ada produk yang sesuai dengan filter Anda. Coba ubah filter atau
                        <a href="{{ route('catalogs.index') }}" class="text-primary hover:underline font-semibold">reset pencarian</a>
                    @else
                        Belum ada produk yang tersedia saat ini.
                    @endif
                </p>
            </div>
        @endif
    </div>
</section>
@endsection
