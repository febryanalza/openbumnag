@extends('layouts.app')

@section('title', $settings['promotion_title'] ?? 'Promo Spesial')
@section('description', $settings['promotion_description'] ?? 'Penawaran menarik dari unit usaha kami')

@section('content')
<!-- Page Header -->
<section class="relative bg-gradient-to-br from-amber-500 via-orange-500 to-red-500 text-white py-16 sm:py-20 lg:py-24 mt-16 sm:mt-20">
    <div class="absolute inset-0 bg-black/20"></div>
    <div class="absolute inset-0 overflow-hidden">
        <div class="absolute -top-4 -right-4 w-64 h-64 bg-white/10 rounded-full blur-3xl"></div>
        <div class="absolute -bottom-8 -left-8 w-96 h-96 bg-white/10 rounded-full blur-3xl"></div>
    </div>
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center">
            <div class="inline-flex items-center gap-2 px-4 py-2 bg-white/20 backdrop-blur-sm rounded-full text-sm font-semibold mb-4">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                </svg>
                Promo Terbatas
            </div>
            <h1 class="text-3xl xs:text-4xl sm:text-5xl lg:text-6xl font-bold mb-3 sm:mb-4">
                {{ $settings['promotion_title'] ?? 'Promo Spesial' }}
            </h1>
            <p class="text-base sm:text-lg md:text-xl text-white/90 max-w-2xl mx-auto px-4">
                {{ $settings['promotion_description'] ?? 'Penawaran menarik dari unit usaha kami' }}
            </p>
        </div>
    </div>
</section>

<!-- Search & Filter Section -->
<section class="py-6 sm:py-8 bg-white border-b">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <form method="GET" action="{{ route('promotions.index') }}" class="flex flex-col gap-3 sm:gap-4">
            <div class="flex flex-col sm:flex-row gap-3 sm:gap-4">
                <!-- Search Input -->
                <div class="flex-1">
                    <div class="relative">
                        <input type="text" 
                               name="search" 
                               value="{{ request('search') }}"
                               placeholder="Cari promo..." 
                               class="w-full px-4 py-2.5 sm:py-3 pl-10 sm:pl-12 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500 text-sm sm:text-base">
                        <svg class="w-4 h-4 sm:w-5 sm:h-5 text-gray-400 absolute left-3 sm:left-4 top-1/2 transform -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                </div>
                
                <!-- Unit Usaha Filter -->
                <div class="w-full sm:w-48 md:w-56">
                    <select name="unit_usaha" 
                            class="w-full px-4 py-2.5 sm:py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500 text-sm sm:text-base">
                        <option value="">Semua Unit Usaha</option>
                        @foreach($bumnagProfiles as $profile)
                        <option value="{{ $profile->id }}" {{ request('unit_usaha') == $profile->id ? 'selected' : '' }}>
                            {{ $profile->name }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <!-- Status Filter -->
                <div class="w-full sm:w-40 md:w-48">
                    <select name="status" 
                            class="w-full px-4 py-2.5 sm:py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500 text-sm sm:text-base">
                        <option value="">Semua Status</option>
                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Masih Berlaku</option>
                        <option value="expired" {{ request('status') == 'expired' ? 'selected' : '' }}>Sudah Berakhir</option>
                    </select>
                </div>
            </div>
            
            <div class="flex flex-col xs:flex-row gap-2 sm:gap-3">
                <!-- Submit Button -->
                <button type="submit" 
                        class="flex-1 xs:flex-none px-6 sm:px-8 py-2.5 sm:py-3 bg-gradient-to-r from-amber-600 to-orange-600 text-white font-semibold rounded-lg hover:from-amber-700 hover:to-orange-700 transition-all duration-200 text-sm sm:text-base touch-target shadow-md hover:shadow-lg">
                    Filter
                </button>
                
                @if(request('search') || request('unit_usaha') || request('status'))
                <a href="{{ route('promotions.index') }}" 
                   class="flex-1 xs:flex-none px-5 sm:px-6 py-2.5 sm:py-3 bg-gray-200 text-gray-700 font-medium rounded-lg hover:bg-gray-300 transition-colors duration-200 text-center text-sm sm:text-base touch-target">
                    Reset
                </a>
                @endif
            </div>
        </form>
    </div>
</section>

<!-- Promotions Grid Section -->
<section class="py-10 sm:py-12 lg:py-16 bg-gradient-to-br from-amber-50 to-orange-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        @if($promotions->count() > 0)
            <!-- Results Info -->
            <div class="mb-6 sm:mb-8 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-2 sm:gap-4">
                <p class="text-sm sm:text-base text-gray-600">
                    Menampilkan <span class="font-semibold">{{ $promotions->firstItem() }}</span> 
                    - <span class="font-semibold">{{ $promotions->lastItem() }}</span> 
                    dari <span class="font-semibold">{{ $promotions->total() }}</span> promo
                </p>
                
                @if(request('search'))
                <p class="text-xs sm:text-sm text-gray-600">
                    Hasil pencarian untuk: <span class="font-semibold text-amber-600">{{ request('search') }}</span>
                </p>
                @endif
            </div>

            <!-- Promotions Grid -->
            <div class="grid grid-cols-1 xs:grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-4 sm:gap-5 lg:gap-6 mb-8 sm:mb-12">
                @foreach($promotions as $promotion)
                <article class="bg-white rounded-xl sm:rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden group hover:-translate-y-2 border-2 border-amber-200">
                    <!-- Promotion Image -->
                    <a href="{{ route('promotions.show', $promotion->slug) }}" class="block relative">
                        @if($promotion->featured_image)
                        <div class="h-44 sm:h-52 lg:h-64 overflow-hidden bg-gray-100 relative">
                            <img src="{{ Storage::url($promotion->featured_image) }}" 
                                 alt="{{ $promotion->title }}" 
                                 class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500"
                                 loading="lazy">
                            <!-- Overlay gradient -->
                            <div class="absolute inset-0 bg-gradient-to-t from-black/50 via-transparent to-transparent"></div>
                        </div>
                        @else
                        <div class="h-44 sm:h-52 lg:h-64 bg-gradient-to-br from-amber-400 via-orange-400 to-red-400 flex items-center justify-center">
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
                        
                        <!-- Discount Badge -->
                        @if($promotion->discount_percentage)
                        <div class="absolute top-2 left-2 sm:top-4 sm:left-4 bg-gradient-to-r from-red-600 to-pink-600 text-white px-3 sm:px-4 py-1.5 sm:py-2 rounded-lg text-sm sm:text-base font-bold shadow-lg">
                            {{ $promotion->discount_percentage }}% OFF
                        </div>
                        @endif

                        <!-- Expired Badge -->
                        @if($promotion->valid_until && $promotion->valid_until->isPast())
                        <div class="absolute inset-0 bg-black/60 flex items-center justify-center">
                            <div class="bg-gray-800 text-white px-4 py-2 rounded-lg font-bold">
                                Promo Berakhir
                            </div>
                        </div>
                        @endif
                    </a>
                    
                    <!-- Promotion Info -->
                    <div class="p-4 sm:p-5">
                        <!-- Unit Usaha & Date -->
                        <div class="flex flex-wrap items-center justify-between gap-2 mb-2 sm:mb-3">
                            @if($promotion->bumnagProfile)
                            <span class="inline-block px-2 sm:px-3 py-1 bg-amber-100 text-amber-800 text-xs font-semibold rounded-full truncate max-w-[140px] sm:max-w-none">
                                {{ $promotion->bumnagProfile->name }}
                            </span>
                            @endif
                            
                            @if($promotion->valid_until)
                            <span class="flex items-center text-xs text-gray-500">
                                <svg class="w-3 h-3 sm:w-4 sm:h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                s/d {{ $promotion->valid_until->format('d M Y') }}
                            </span>
                            @endif
                        </div>
                        
                        <!-- Promotion Title -->
                        <h3 class="text-base sm:text-lg font-bold text-gray-900 mb-1 sm:mb-2 group-hover:text-amber-600 transition-colors duration-200 line-clamp-2">
                            <a href="{{ route('promotions.show', $promotion->slug) }}">
                                {{ $promotion->title }}
                            </a>
                        </h3>
                        
                        <!-- Description -->
                        @if($promotion->description)
                        <p class="text-xs sm:text-sm text-gray-600 mb-3 sm:mb-4 line-clamp-2">
                            {{ Str::limit(strip_tags($promotion->description), 80) }}
                        </p>
                        @endif
                        
                        <!-- Footer -->
                        <div class="flex items-center justify-between pt-3 sm:pt-4 border-t border-gray-100">
                            <!-- Terms hint -->
                            <div class="text-xs text-gray-500 flex items-center">
                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                S&K berlaku
                            </div>
                            
                            <a href="{{ route('promotions.show', $promotion->slug) }}" 
                               class="inline-flex items-center px-3 sm:px-4 py-1.5 sm:py-2 bg-gradient-to-r from-amber-500 to-orange-500 text-white text-xs sm:text-sm font-semibold rounded-lg hover:from-amber-600 hover:to-orange-600 transition-all duration-200 shadow-md hover:shadow-lg touch-target">
                                Lihat
                                <svg class="w-3 h-3 sm:w-4 sm:h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </a>
                        </div>
                    </div>
                </article>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="flex justify-center">
                {{ $promotions->links() }}
            </div>
        @else
            <!-- Empty State -->
            <div class="text-center py-12 sm:py-16 lg:py-20 bg-white rounded-2xl shadow-md">
                <svg class="w-16 h-16 sm:w-20 sm:h-20 lg:w-24 lg:h-24 text-gray-300 mx-auto mb-4 sm:mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7"></path>
                </svg>
                <h3 class="text-xl sm:text-2xl font-bold text-gray-700 mb-2">Promo Tidak Ditemukan</h3>
                <p class="text-sm sm:text-base text-gray-500 mb-6 sm:mb-8 px-4">
                    @if(request('search') || request('unit_usaha') || request('status'))
                        Tidak ada promo yang sesuai dengan filter Anda. Coba ubah filter atau
                        <a href="{{ route('promotions.index') }}" class="text-amber-600 hover:underline font-semibold">reset pencarian</a>
                    @else
                        Belum ada promo yang tersedia saat ini.
                    @endif
                </p>
            </div>
        @endif
    </div>
</section>
@endsection
