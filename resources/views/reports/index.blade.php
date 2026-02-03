@extends('layouts.app')

@section('title', 'Laporan & Transparansi')
@section('description', 'Laporan keuangan dan kegiatan BUMNag Lubas Mandiri')

@section('content')
<!-- Page Header -->
<section class="relative bg-gradient-to-br from-sage via-sage-600 to-primary text-white py-16 sm:py-20 lg:py-24 mt-16 sm:mt-20">
    <div class="absolute inset-0 bg-black/20"></div>
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center">
            <h1 class="text-3xl xs:text-4xl sm:text-5xl lg:text-6xl font-bold mb-3 sm:mb-4">
                Laporan & Transparansi
            </h1>
            <p class="text-base sm:text-lg md:text-xl text-white/90 max-w-2xl mx-auto px-4">
                Laporan keuangan dan kegiatan BUMNag Lubas Mandiri
            </p>
        </div>
    </div>
</section>

<!-- Reports List -->
<section class="py-10 sm:py-12 lg:py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        @if($reports->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6 lg:gap-8">
                @foreach($reports as $report)
                <div class="bg-gradient-to-br from-sage-50 to-mint-50 rounded-xl sm:rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden group hover:-translate-y-2 border border-sage-100">
                    <div class="p-5 sm:p-6 lg:p-8">
                        <div class="w-12 h-12 sm:w-14 sm:h-14 lg:w-16 lg:h-16 bg-primary rounded-xl sm:rounded-2xl flex items-center justify-center mb-4 sm:mb-6 group-hover:scale-110 transition-transform duration-300">
                            <svg class="w-6 h-6 sm:w-7 sm:h-7 lg:w-8 lg:h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                        
                        <div class="flex flex-wrap items-center gap-2 mb-2 sm:mb-3">
                            <span class="inline-block px-2 sm:px-3 py-1 bg-primary/20 text-primary text-xs font-semibold rounded-full">
                                {{ ucfirst($report->type) }}
                            </span>
                            <span class="text-xs sm:text-sm text-gray-600">{{ $report->year }}</span>
                        </div>
                        
                        <h3 class="text-lg sm:text-xl font-bold text-gray-900 mb-2 sm:mb-3 group-hover:text-primary transition-colors duration-200 line-clamp-2">
                            <a href="{{ route('reports.show', $report->slug) }}">
                                {{ $report->title }}
                            </a>
                        </h3>
                        
                        <p class="text-sm sm:text-base text-gray-600 mb-4 sm:mb-6 line-clamp-2">
                            {{ $report->description }}
                        </p>
                        
                        <div class="flex items-center gap-2 sm:gap-3">
                            <a href="{{ route('reports.show', $report->slug) }}" 
                               class="flex-1 inline-flex items-center justify-center px-3 sm:px-4 py-2 bg-primary text-white text-xs sm:text-sm font-semibold rounded-lg hover:bg-primary-600 transition-colors duration-200 touch-target">
                                <span class="hidden xs:inline">Lihat </span>Laporan
                            </a>
                            @if($report->file_path)
                            <a href="{{ Storage::url($report->file_path) }}" 
                               download
                               class="inline-flex items-center justify-center w-10 h-10 sm:w-auto sm:h-auto sm:px-4 sm:py-2 bg-sage text-white text-sm font-semibold rounded-lg hover:bg-sage-600 transition-colors duration-200 touch-target">
                                <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                                </svg>
                            </a>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-8 sm:mt-12 flex justify-center">
                {{ $reports->links() }}
            </div>
        @else
            <div class="text-center py-12 sm:py-16 lg:py-20">
                <svg class="w-16 h-16 sm:w-20 sm:h-20 lg:w-24 lg:h-24 text-gray-300 mx-auto mb-4 sm:mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                <h3 class="text-xl sm:text-2xl font-bold text-gray-700 mb-2">Belum Ada Laporan</h3>
                <p class="text-sm sm:text-base text-gray-500">Laporan akan ditampilkan di sini.</p>
            </div>
        @endif
    </div>
</section>
@endsection
