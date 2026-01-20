@extends('layouts.app')

@section('title', 'Laporan & Transparansi')
@section('description', 'Laporan keuangan dan kegiatan BUMNag Lubas Mandiri')

@section('content')
<!-- Page Header -->
<section class="relative bg-gradient-to-br from-sage via-sage-600 to-primary text-white py-24 mt-20">
    <div class="absolute inset-0 bg-black/20"></div>
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center">
            <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold mb-4">
                Laporan & Transparansi
            </h1>
            <p class="text-xl text-white/90 max-w-2xl mx-auto">
                Laporan keuangan dan kegiatan BUMNag Lubas Mandiri
            </p>
        </div>
    </div>
</section>

<!-- Reports List -->
<section class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        @if($reports->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($reports as $report)
                <div class="bg-gradient-to-br from-sage-50 to-mint-50 rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden group hover:-translate-y-2 border border-sage-100">
                    <div class="p-8">
                        <div class="w-16 h-16 bg-primary rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                        
                        <div class="flex items-center gap-2 mb-3">
                            <span class="inline-block px-3 py-1 bg-primary/20 text-primary text-xs font-semibold rounded-full">
                                {{ ucfirst($report->type) }}
                            </span>
                            <span class="text-sm text-gray-600">{{ $report->year }}</span>
                        </div>
                        
                        <h3 class="text-xl font-bold text-gray-900 mb-3 group-hover:text-primary transition-colors duration-200">
                            <a href="{{ route('reports.show', $report->slug) }}">
                                {{ $report->title }}
                            </a>
                        </h3>
                        
                        <p class="text-gray-600 mb-6 line-clamp-2">
                            {{ $report->description }}
                        </p>
                        
                        <div class="flex items-center gap-3">
                            <a href="{{ route('reports.show', $report->slug) }}" 
                               class="flex-1 inline-flex items-center justify-center px-4 py-2 bg-primary text-white text-sm font-semibold rounded-lg hover:bg-primary-600 transition-colors duration-200">
                                Lihat Laporan
                            </a>
                            @if($report->file_path)
                            <a href="{{ Storage::url($report->file_path) }}" 
                               download
                               class="inline-flex items-center px-4 py-2 bg-sage text-white text-sm font-semibold rounded-lg hover:bg-sage-600 transition-colors duration-200">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
            <div class="mt-12 flex justify-center">
                {{ $reports->links() }}
            </div>
        @else
            <div class="text-center py-20">
                <svg class="w-24 h-24 text-gray-300 mx-auto mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                <h3 class="text-2xl font-bold text-gray-700 mb-2">Belum Ada Laporan</h3>
                <p class="text-gray-500">Laporan akan ditampilkan di sini.</p>
            </div>
        @endif
    </div>
</section>
@endsection
