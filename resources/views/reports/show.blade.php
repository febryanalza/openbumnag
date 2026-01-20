@extends('layouts.app')

@section('title', $report->title)
@section('description', $report->description)

@section('content')
<!-- Preview Badge -->
@if(isset($isPreview) && $isPreview)
<div class="fixed top-20 right-4 z-50 animate-pulse">
    <div class="bg-yellow-500 text-white px-6 py-3 rounded-full shadow-2xl border-4 border-yellow-300 flex items-center gap-2">
        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
            <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"></path>
            <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"></path>
        </svg>
        <span class="font-bold text-sm uppercase tracking-wider">Mode Preview</span>
    </div>
</div>
@endif

<!-- Report Header -->
<article class="mt-20">
    <header class="relative bg-gradient-to-br from-sage/10 via-mint/10 to-primary/10 py-12 md:py-16">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Type & Year -->
            <div class="flex items-center gap-4 mb-6">
                <span class="inline-block px-4 py-2 bg-sage text-white rounded-full text-sm font-medium">
                    {{ ucfirst($report->type) }}
                </span>
                <time class="text-gray-600 text-sm font-medium">
                    {{ $report->year }} - {{ $report->period }}
                </time>
            </div>
            
            <!-- Title -->
            <h1 class="text-3xl md:text-4xl lg:text-5xl font-bold text-gray-900 mb-6 leading-tight">
                {{ $report->title }}
            </h1>
            
            <!-- Meta Info -->
            <div class="flex flex-wrap items-center gap-6 text-gray-600">
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    <span class="text-sm">{{ $report->published_at ? $report->published_at->format('d F Y') : 'Belum dipublikasikan' }}</span>
                </div>
                
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                    </svg>
                    <span class="text-sm">{{ number_format($report->downloads ?? 0) }} unduhan</span>
                </div>
            </div>
        </div>
    </header>

    <!-- Report Content -->
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <!-- Cover Image -->
        @if($report->cover_image)
        <div class="mb-8 rounded-2xl overflow-hidden shadow-xl">
            <img src="{{ Storage::url($report->cover_image) }}" 
                 alt="{{ $report->title }}" 
                 class="w-full h-auto">
        </div>
        @endif

        <!-- Description -->
        @if($report->description)
        <div class="mb-8 p-6 bg-gradient-to-br from-sage-50 to-mint-50 rounded-2xl border border-sage-100">
            <p class="text-lg text-gray-700 leading-relaxed">
                {{ $report->description }}
            </p>
        </div>
        @endif

        <!-- Download Button -->
        @if($report->file_path)
        <div class="mb-12 p-6 bg-gradient-to-r from-primary to-sage text-white rounded-2xl shadow-xl">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-xl font-bold mb-2">Unduh Laporan Lengkap</h3>
                    <p class="text-white/90">File {{ strtoupper(pathinfo($report->file_path, PATHINFO_EXTENSION)) }}</p>
                </div>
                <a href="{{ Storage::url($report->file_path) }}" 
                   download
                   class="inline-flex items-center gap-2 px-6 py-3 bg-white text-primary font-semibold rounded-lg hover:bg-gray-50 transition-colors duration-200 shadow-lg">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                    </svg>
                    Unduh Laporan
                </a>
            </div>
        </div>
        @endif

        <!-- Content -->
        @if($report->content)
        <div class="prose prose-lg max-w-none prose-headings:text-gray-900 prose-p:text-gray-700 prose-a:text-primary prose-a:no-underline hover:prose-a:underline prose-strong:text-gray-900 prose-img:rounded-xl prose-img:shadow-lg">
            {!! $report->content !!}
        </div>
        @endif

        <!-- Share Buttons -->
        <div class="mt-12 pt-8 border-t border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Bagikan Laporan</h3>
            <div class="flex flex-wrap gap-3">
                <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(route('reports.show', $report->slug)) }}" 
                   target="_blank"
                   class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors duration-200">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                    </svg>
                    Facebook
                </a>
                <a href="https://twitter.com/intent/tweet?url={{ urlencode(route('reports.show', $report->slug)) }}&text={{ urlencode($report->title) }}" 
                   target="_blank"
                   class="inline-flex items-center gap-2 px-4 py-2 bg-sky-500 text-white rounded-lg hover:bg-sky-600 transition-colors duration-200">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/>
                    </svg>
                    Twitter
                </a>
                <a href="https://wa.me/?text={{ urlencode($report->title . ' ' . route('reports.show', $report->slug)) }}" 
                   target="_blank"
                   class="inline-flex items-center gap-2 px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors duration-200">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.890-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/>
                    </svg>
                    WhatsApp
                </a>
            </div>
        </div>
    </div>
</article>
@endsection
