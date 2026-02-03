@extends('layouts.app')

@section('title', $news->meta_title ?? $news->title)
@section('description', $news->meta_description ?? strip_tags($news->excerpt ?? Str::limit($news->content, 160)))

@section('content')
<!-- Preview Badge -->
@if(isset($isPreview) && $isPreview)
<div class="fixed top-16 sm:top-20 right-2 sm:right-4 z-50 animate-pulse">
    <div class="bg-yellow-500 text-white px-4 sm:px-6 py-2 sm:py-3 rounded-full shadow-2xl border-2 sm:border-4 border-yellow-300 flex items-center gap-2">
        <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="currentColor" viewBox="0 0 20 20">
            <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"></path>
            <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"></path>
        </svg>
        <span class="font-bold text-xs sm:text-sm uppercase tracking-wider">Mode Preview</span>
    </div>
</div>
@endif

<!-- Article Header -->
<article class="mt-16 sm:mt-20">
    <header class="relative bg-gradient-to-br from-primary/10 via-sage/10 to-mint/10 py-8 sm:py-12 md:py-16">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Category & Date -->
            <div class="flex flex-wrap items-center gap-2 sm:gap-4 mb-4 sm:mb-6">
                @if($news->category)
                <a href="{{ route('news.index', ['category' => $news->category->id]) }}" 
                   class="inline-block px-3 sm:px-4 py-1.5 sm:py-2 bg-primary text-white rounded-full text-xs sm:text-sm font-medium hover:bg-primary-600 transition-colors duration-200">
                    {{ $news->category->name }}
                </a>
                @endif
                <time class="text-gray-600 text-xs sm:text-sm font-medium" datetime="{{ $news->published_at->toISOString() }}">
                    {{ $news->published_at->format('d F Y') }}
                </time>
            </div>
            
            <!-- Title -->
            <h1 class="text-2xl xs:text-3xl sm:text-4xl lg:text-5xl font-bold text-gray-900 mb-4 sm:mb-6 leading-tight">
                {{ $news->title }}
            </h1>
            
            <!-- Meta Info -->
            <div class="flex flex-wrap items-center gap-3 sm:gap-6 text-gray-600">
                @if($news->user)
                <div class="flex items-center gap-2">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                    <span class="text-xs sm:text-sm font-medium">{{ $news->user->name }}</span>
                </div>
                @endif
                
                <div class="flex items-center gap-2">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                    </svg>
                    <span class="text-xs sm:text-sm">{{ number_format($news->views) }} <span class="hidden xs:inline">kali dibaca</span></span>
                </div>
                
                <div class="flex items-center gap-2">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span class="text-xs sm:text-sm">{{ $news->created_at ? $news->created_at->diffForHumans() : 'Baru saja' }}</span>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-12">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 lg:gap-12">
            <!-- Article Content -->
            <div class="lg:col-span-2">
                <!-- Featured Image -->
                @if($news->featured_image)
                <figure class="mb-6 sm:mb-8 rounded-xl sm:rounded-2xl overflow-hidden shadow-lg">
                    <img src="{{ Storage::url($news->featured_image) }}" 
                         alt="{{ $news->title }}" 
                         class="w-full h-auto">
                    @if($news->excerpt)
                    <figcaption class="bg-gray-50 px-4 sm:px-6 py-3 sm:py-4 text-sm sm:text-base text-gray-600 italic">
                        {{ $news->excerpt }}
                    </figcaption>
                    @endif
                </figure>
                @endif

                <!-- Article Body -->
                <div class="prose prose-sm sm:prose-base lg:prose-lg max-w-none">
                    {!! $news->content !!}
                </div>

                <!-- Additional Images -->
                @if($news->images && is_array($news->images) && count($news->images) > 0)
                <div class="mt-8 sm:mt-12">
                    <h3 class="text-xl sm:text-2xl font-bold text-gray-900 mb-4 sm:mb-6">Galeri Foto</h3>
                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-3 sm:gap-4">
                        @foreach($news->images as $image)
                        <div class="rounded-lg overflow-hidden shadow-md hover:shadow-xl transition-shadow duration-300">
                            <img src="{{ Storage::url($image) }}" 
                                 alt="Foto berita {{ $news->title }}" 
                                 class="w-full h-32 sm:h-40 lg:h-48 object-cover hover:scale-110 transition-transform duration-300"
                                 loading="lazy">
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Share Buttons -->
                <div class="mt-8 sm:mt-12 pt-6 sm:pt-8 border-t border-gray-200">
                    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                        <h4 class="text-base sm:text-lg font-semibold text-gray-900">Bagikan Berita Ini:</h4>
                        <div class="flex items-center gap-2 sm:gap-3">
                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(route('news.show', $news->slug)) }}" 
                               target="_blank"
                               class="w-10 h-10 sm:w-11 sm:h-11 bg-blue-600 text-white rounded-full flex items-center justify-center hover:bg-blue-700 transition-colors duration-200 touch-target">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                                </svg>
                            </a>
                            <a href="https://twitter.com/intent/tweet?url={{ urlencode(route('news.show', $news->slug)) }}&text={{ urlencode($news->title) }}" 
                               target="_blank"
                               class="w-10 h-10 sm:w-11 sm:h-11 bg-sky-500 text-white rounded-full flex items-center justify-center hover:bg-sky-600 transition-colors duration-200 touch-target">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/>
                                </svg>
                            </a>
                            <a href="https://wa.me/?text={{ urlencode($news->title . ' - ' . route('news.show', $news->slug)) }}" 
                               target="_blank"
                               class="w-10 h-10 sm:w-11 sm:h-11 bg-green-600 text-white rounded-full flex items-center justify-center hover:bg-green-700 transition-colors duration-200 touch-target">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Navigation -->
                <div class="mt-6 sm:mt-8 flex items-center justify-between">
                    <a href="{{ route('news.index') }}" 
                       class="inline-flex items-center text-gray-600 hover:text-primary transition-colors duration-200 text-sm sm:text-base">
                        <svg class="w-4 h-4 sm:w-5 sm:h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                        </svg>
                        Kembali ke Berita
                    </a>
                </div>
            </div>

            <!-- Sidebar -->
            <aside class="lg:col-span-1">
                <!-- Latest News -->
                <div class="bg-white rounded-xl sm:rounded-2xl shadow-lg p-4 sm:p-6 mb-6 sm:mb-8 lg:sticky lg:top-24">
                    <h3 class="text-lg sm:text-xl font-bold text-gray-900 mb-4 sm:mb-6 pb-3 sm:pb-4 border-b border-gray-200">
                        Berita Terbaru
                    </h3>
                    <div class="space-y-4 sm:space-y-6">
                        @foreach($latestNews as $item)
                        <article class="group">
                            <a href="{{ route('news.show', $item->slug) }}" class="block">
                                <h4 class="text-sm sm:text-base font-semibold text-gray-900 mb-2 line-clamp-2 group-hover:text-primary transition-colors duration-200">
                                    {{ $item->title }}
                                </h4>
                                <div class="flex items-center justify-between text-xs sm:text-sm text-gray-500">
                                    <time>{{ $item->published_at->format('d M Y') }}</time>
                                    <div class="flex items-center gap-1">
                                        <svg class="w-3 h-3 sm:w-4 sm:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                        <span>{{ number_format($item->views) }}</span>
                                    </div>
                                </div>
                            </a>
                        </article>
                        @if(!$loop->last)
                        <hr class="border-gray-200">
                        @endif
                        @endforeach
                    </div>
                    
                    <div class="mt-4 sm:mt-6 pt-4 sm:pt-6 border-t border-gray-200">
                        <a href="{{ route('news.index') }}" 
                           class="block text-center py-2 text-primary font-semibold hover:text-primary-600 transition-colors duration-200 text-sm sm:text-base">
                            Lihat Semua Berita →
                        </a>
                    </div>
                </div>
            </aside>
        </div>
    </div>
</article>

<!-- Related News Section -->
@if($relatedNews->count() > 0)
<section class="py-10 sm:py-12 lg:py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-2xl sm:text-3xl font-bold text-gray-900 mb-6 sm:mb-8">
            Berita Terkait
        </h2>
        
        <div class="grid grid-cols-1 xs:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">
            @foreach($relatedNews as $item)
            <article class="bg-white rounded-lg sm:rounded-xl shadow-md hover:shadow-xl transition-all duration-300 overflow-hidden group hover:-translate-y-1">
                <a href="{{ route('news.show', $item->slug) }}">
                    @if($item->featured_image)
                    <div class="h-32 sm:h-40 overflow-hidden">
                        <img src="{{ Storage::url($item->featured_image) }}" 
                             alt="{{ $item->title }}" 
                             class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500"
                             loading="lazy">
                    </div>
                    @else
                    <div class="h-32 sm:h-40 bg-gradient-to-br from-sage to-mint flex items-center justify-center">
                        <svg class="w-10 h-10 sm:w-12 sm:h-12 text-white/50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                        </svg>
                    </div>
                    @endif
                    
                    <div class="p-3 sm:p-4">
                        <time class="text-xs text-gray-500">{{ $item->published_at->format('d M Y') }}</time>
                        <h3 class="text-sm sm:text-base font-bold text-gray-900 mt-1 sm:mt-2 line-clamp-2 group-hover:text-primary transition-colors duration-200">
                            {{ $item->title }}
                        </h3>
                        @if($item->excerpt)
                        <p class="text-xs sm:text-sm text-gray-600 mt-1 sm:mt-2 line-clamp-2">
                            {{ strip_tags($item->excerpt) }}
                        </p>
                        @endif
                    </div>
                </a>
            </article>
            @endforeach
        </div>
    </div>
</section>
@endif
@endsection

@push('styles')
<style>
    /* Prose Styling for Article Content */
    .prose {
        @apply text-gray-700 leading-relaxed;
    }
    
    .prose h2 {
        @apply text-2xl font-bold text-gray-900 mt-8 mb-4;
    }
    
    .prose h3 {
        @apply text-xl font-bold text-gray-900 mt-6 mb-3;
    }
    
    .prose p {
        @apply mb-4;
    }
    
    .prose ul, .prose ol {
        @apply ml-6 mb-4;
    }
    
    .prose ul {
        @apply list-disc;
    }
    
    .prose ol {
        @apply list-decimal;
    }
    
    .prose li {
        @apply mb-2;
    }
    
    .prose a {
        @apply text-primary hover:text-primary-600 underline;
    }
    
    .prose blockquote {
        @apply border-l-4 border-primary bg-gray-50 pl-4 py-2 italic my-4;
    }
    
    .prose img {
        @apply rounded-lg my-6;
    }
    
    .prose strong {
        @apply font-bold text-gray-900;
    }
    
    .prose em {
        @apply italic;
    }
</style>
@endpush
