@extends('layouts.app')

@section('title', $bumnag->name)
@section('description', $bumnag->tagline)

@section('content')
<!-- Hero Banner -->
<section class="relative h-96 overflow-hidden mt-20">
    @if($bumnag->banner)
    <img src="{{ Storage::url($bumnag->banner) }}" 
         alt="{{ $bumnag->name }}" 
         class="w-full h-full object-cover">
    <div class="absolute inset-0 bg-gradient-to-r from-black/70 via-black/50 to-transparent"></div>
    @else
    <div class="w-full h-full bg-gradient-to-br from-primary via-sage to-mint"></div>
    <div class="absolute inset-0 bg-gradient-to-r from-black/70 via-black/50 to-transparent"></div>
    @endif
    
    <!-- Hero Content -->
    <div class="absolute inset-0 flex items-center">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full">
            <div class="flex items-center gap-8">
                @if($bumnag->logo)
                <div class="hidden md:block flex-shrink-0">
                    <img src="{{ Storage::url($bumnag->logo) }}" 
                         alt="{{ $bumnag->name }}" 
                         class="w-32 h-32 object-contain bg-white/10 backdrop-blur-sm rounded-2xl p-4 border-2 border-white/20">
                </div>
                @endif
                <div>
                    <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-white mb-4">
                        {{ $bumnag->name }}
                    </h1>
                    @if($bumnag->tagline)
                    <p class="text-xl md:text-2xl text-white/90">
                        {{ $bumnag->tagline }}
                    </p>
                    @endif
                    @if($bumnag->nagari_name)
                    <p class="text-lg text-white/80 mt-2">
                        <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        Nagari {{ $bumnag->nagari_name }}
                    </p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Statistics Section -->
<section class="py-12 bg-gradient-to-br from-sage-50 to-mint-50 border-b border-sage-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="text-center p-6 bg-white rounded-2xl shadow-md">
                <div class="w-16 h-16 bg-primary rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                    </svg>
                </div>
                <h3 class="text-3xl font-bold text-gray-900 mb-2">{{ $stats['total_products'] }}</h3>
                <p class="text-gray-600">Total Produk</p>
            </div>
            
            <div class="text-center p-6 bg-white rounded-2xl shadow-md">
                <div class="w-16 h-16 bg-sage rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <h3 class="text-3xl font-bold text-gray-900 mb-2">{{ $stats['available_products'] }}</h3>
                <p class="text-gray-600">Produk Tersedia</p>
            </div>
            
            <div class="text-center p-6 bg-white rounded-2xl shadow-md">
                <div class="w-16 h-16 bg-mint rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path>
                    </svg>
                </div>
                <h3 class="text-3xl font-bold text-gray-900 mb-2">{{ $stats['featured_products'] }}</h3>
                <p class="text-gray-600">Produk Unggulan</p>
            </div>
        </div>
    </div>
</section>

<!-- Profile Section -->
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
            <!-- Main Content -->
            <div class="lg:col-span-2">
                <!-- About -->
                @if($bumnag->about)
                <div class="mb-12">
                    <h2 class="text-3xl font-bold text-gray-900 mb-6 flex items-center">
                        <svg class="w-8 h-8 mr-3 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Tentang Kami
                    </h2>
                    <div class="prose prose-lg max-w-none text-gray-700 leading-relaxed">
                        {!! $bumnag->about !!}
                    </div>
                </div>
                @endif

                <!-- Vision & Mission -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-12">
                    @if($bumnag->vision)
                    <div class="bg-gradient-to-br from-primary/5 to-sage/5 rounded-2xl p-6 border border-primary/10">
                        <h3 class="text-2xl font-bold text-gray-900 mb-4 flex items-center">
                            <svg class="w-6 h-6 mr-2 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                            Visi
                        </h3>
                        <div class="text-gray-700 leading-relaxed">{!! $bumnag->vision !!}</div>
                    </div>
                    @endif

                    @if($bumnag->mission)
                    <div class="bg-gradient-to-br from-sage/5 to-mint/5 rounded-2xl p-6 border border-sage/10">
                        <h3 class="text-2xl font-bold text-gray-900 mb-4 flex items-center">
                            <svg class="w-6 h-6 mr-2 text-sage" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                            </svg>
                            Misi
                        </h3>
                        <div class="text-gray-700 leading-relaxed">{!! $bumnag->mission !!}</div>
                    </div>
                    @endif
                </div>

                <!-- History -->
                @if($bumnag->history)
                <div class="mb-12">
                    <h2 class="text-3xl font-bold text-gray-900 mb-6 flex items-center">
                        <svg class="w-8 h-8 mr-3 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Sejarah
                    </h2>
                    <div class="prose prose-lg max-w-none text-gray-700 leading-relaxed">
                        {!! $bumnag->history !!}
                    </div>
                </div>
                @endif
            </div>

            <!-- Sidebar -->
            <div class="lg:col-span-1">
                <!-- Contact Information -->
                <div class="bg-gradient-to-br from-sage-50 to-mint-50 rounded-2xl p-6 shadow-lg border border-sage-100 sticky top-24">
                    <h3 class="text-2xl font-bold text-gray-900 mb-6">Informasi Kontak</h3>
                    
                    @if($bumnag->address)
                    <div class="mb-4 flex items-start">
                        <svg class="w-6 h-6 text-primary mr-3 flex-shrink-0 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        <div>
                            <p class="font-semibold text-gray-900 mb-1">Alamat</p>
                            <p class="text-gray-700">{{ $bumnag->address }}</p>
                            @if($bumnag->postal_code)
                            <p class="text-gray-600 text-sm mt-1">{{ $bumnag->postal_code }}</p>
                            @endif
                        </div>
                    </div>
                    @endif

                    @if($bumnag->phone)
                    <div class="mb-4 flex items-start">
                        <svg class="w-6 h-6 text-primary mr-3 flex-shrink-0 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                        </svg>
                        <div>
                            <p class="font-semibold text-gray-900 mb-1">Telepon</p>
                            <a href="tel:{{ $bumnag->phone }}" class="text-primary hover:text-primary-600 transition-colors">{{ $bumnag->phone }}</a>
                        </div>
                    </div>
                    @endif

                    @if($bumnag->email)
                    <div class="mb-4 flex items-start">
                        <svg class="w-6 h-6 text-primary mr-3 flex-shrink-0 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                        <div>
                            <p class="font-semibold text-gray-900 mb-1">Email</p>
                            <a href="mailto:{{ $bumnag->email }}" class="text-primary hover:text-primary-600 transition-colors break-all">{{ $bumnag->email }}</a>
                        </div>
                    </div>
                    @endif

                    @if($bumnag->website)
                    <div class="mb-4 flex items-start">
                        <svg class="w-6 h-6 text-primary mr-3 flex-shrink-0 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"></path>
                        </svg>
                        <div>
                            <p class="font-semibold text-gray-900 mb-1">Website</p>
                            <a href="{{ $bumnag->website }}" target="_blank" class="text-primary hover:text-primary-600 transition-colors break-all">{{ $bumnag->website }}</a>
                        </div>
                    </div>
                    @endif

                    <!-- Social Media -->
                    @if($bumnag->facebook || $bumnag->instagram || $bumnag->twitter || $bumnag->whatsapp)
                    <div class="mt-6 pt-6 border-t border-sage-200">
                        <p class="font-semibold text-gray-900 mb-3">Media Sosial</p>
                        <div class="flex flex-wrap gap-3">
                            @if($bumnag->facebook)
                            <a href="{{ $bumnag->facebook }}" target="_blank" class="w-10 h-10 bg-blue-600 text-white rounded-full flex items-center justify-center hover:bg-blue-700 transition-colors">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                            </a>
                            @endif
                            @if($bumnag->instagram)
                            <a href="{{ $bumnag->instagram }}" target="_blank" class="w-10 h-10 bg-gradient-to-br from-purple-600 to-pink-500 text-white rounded-full flex items-center justify-center hover:from-purple-700 hover:to-pink-600 transition-colors">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                            </a>
                            @endif
                            @if($bumnag->twitter)
                            <a href="{{ $bumnag->twitter }}" target="_blank" class="w-10 h-10 bg-sky-500 text-white rounded-full flex items-center justify-center hover:bg-sky-600 transition-colors">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/></svg>
                            </a>
                            @endif
                            @if($bumnag->whatsapp)
                            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $bumnag->whatsapp) }}" target="_blank" class="w-10 h-10 bg-green-600 text-white rounded-full flex items-center justify-center hover:bg-green-700 transition-colors">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.890-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/></svg>
                            </a>
                            @endif
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Products Section -->
<section class="py-20 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4">
                Produk & Layanan
            </h2>
            <p class="text-xl text-gray-600">
                Katalog produk dari {{ $bumnag->name }}
            </p>
        </div>

        @if($products->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
            @foreach($products as $product)
            <article class="bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden group hover:-translate-y-2">
                <a href="{{ route('catalogs.show', $product->slug) }}" class="block relative">
                    @if($product->featured_image)
                    <img src="{{ Storage::url($product->featured_image) }}" 
                         alt="{{ $product->name }}" 
                         class="w-full h-56 object-cover group-hover:scale-110 transition-transform duration-300">
                    @else
                    <div class="w-full h-56 bg-gradient-to-br from-gray-200 to-gray-300 flex items-center justify-center">
                        <svg class="w-20 h-20 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                        </svg>
                    </div>
                    @endif
                    
                    <!-- Featured Badge -->
                    @if($product->is_featured)
                    <div class="absolute top-4 right-4 bg-primary text-white px-3 py-1 rounded-full text-xs font-semibold">
                        Unggulan
                    </div>
                    @endif
                    
                    <!-- Stock Badge -->
                    @if($product->stock === 0)
                    <div class="absolute top-4 left-4 bg-red-500 text-white px-3 py-1 rounded-full text-xs font-semibold">
                        Habis
                    </div>
                    @elseif($product->stock < 10)
                    <div class="absolute top-4 left-4 bg-orange-500 text-white px-3 py-1 rounded-full text-xs font-semibold">
                        Stok Terbatas
                    </div>
                    @endif
                </a>
                
                <div class="p-6">
                    @if($product->category)
                    <p class="text-sm text-primary font-medium mb-2">{{ $product->category }}</p>
                    @endif
                    
                    <h3 class="text-xl font-bold text-gray-900 mb-3 line-clamp-2 group-hover:text-primary transition-colors duration-200">
                        <a href="{{ route('catalogs.show', $product->slug) }}">
                            {{ $product->name }}
                        </a>
                    </h3>
                    
                    @if($product->description)
                    <div class="text-gray-600 mb-4 line-clamp-2">
                        {!! $product->description !!}
                    </div>
                    @endif
                    
                    <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                        <div>
                            <p class="text-2xl font-bold text-primary">
                                Rp {{ number_format($product->price, 0, ',', '.') }}
                            </p>
                            @if($product->unit)
                            <p class="text-sm text-gray-500">per {{ $product->unit }}</p>
                            @endif
                        </div>
                        <a href="{{ route('catalogs.show', $product->slug) }}" 
                           class="inline-flex items-center px-4 py-2 bg-primary text-white text-sm font-semibold rounded-lg hover:bg-primary-600 transition-colors duration-200">
                            Detail
                        </a>
                    </div>
                </div>
            </article>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-12 flex justify-center">
            {{ $products->links() }}
        </div>
        @else
        <div class="text-center py-20">
            <svg class="w-24 h-24 text-gray-300 mx-auto mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
            </svg>
            <h3 class="text-2xl font-bold text-gray-700 mb-2">Belum Ada Produk</h3>
            <p class="text-gray-500">Produk akan ditampilkan di sini.</p>
        </div>
        @endif
    </div>
</section>

<!-- CTA Section -->
<section class="py-20 bg-gradient-to-r from-primary to-sage-600 text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-4xl md:text-5xl font-bold mb-6">
            Tertarik dengan Produk Kami?
        </h2>
        <p class="text-xl text-white/90 max-w-2xl mx-auto mb-10">
            Hubungi kami untuk informasi lebih lanjut atau untuk melakukan pemesanan
        </p>
        <div class="flex flex-wrap justify-center gap-4">
            @if($bumnag->whatsapp)
            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $bumnag->whatsapp) }}" 
               target="_blank"
               class="inline-flex items-center px-8 py-4 bg-green-600 text-white font-semibold rounded-full hover:bg-green-700 transition-all duration-200 shadow-xl hover:shadow-2xl hover:-translate-y-1">
                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.890-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/></svg>
                Hubungi via WhatsApp
            </a>
            @endif
            @if($bumnag->phone)
            <a href="tel:{{ $bumnag->phone }}" 
               class="inline-flex items-center px-8 py-4 bg-white text-primary font-semibold rounded-full hover:bg-gray-50 transition-all duration-200 shadow-xl hover:shadow-2xl hover:-translate-y-1">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                </svg>
                Hubungi via Telepon
            </a>
            @endif
        </div>
    </div>
</section>
@endsection
