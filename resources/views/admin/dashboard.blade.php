@extends('admin.layouts.app')

@section('title', 'Dashboard')
@section('header', 'Dashboard')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
    <!-- Stats Cards -->
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
            <div class="flex-shrink-0 bg-blue-500 rounded-md p-3">
                <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                </svg>
            </div>
            <div class="ml-4">
                <h4 class="text-gray-500 text-sm font-medium">Total Users</h4>
                <p class="text-2xl font-bold text-gray-900">{{ $stats['users'] }}</p>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
            <div class="flex-shrink-0 bg-green-500 rounded-md p-3">
                <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                </svg>
            </div>
            <div class="ml-4">
                <h4 class="text-gray-500 text-sm font-medium">Berita</h4>
                <p class="text-2xl font-bold text-gray-900">{{ $stats['news'] }}</p>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
            <div class="flex-shrink-0 bg-yellow-500 rounded-md p-3">
                <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                </svg>
            </div>
            <div class="ml-4">
                <h4 class="text-gray-500 text-sm font-medium">Katalog</h4>
                <p class="text-2xl font-bold text-gray-900">{{ $stats['catalogs'] }}</p>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
            <div class="flex-shrink-0 bg-purple-500 rounded-md p-3">
                <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
            </div>
            <div class="ml-4">
                <h4 class="text-gray-500 text-sm font-medium">Galeri</h4>
                <p class="text-2xl font-bold text-gray-900">{{ $stats['galleries'] }}</p>
            </div>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <!-- Recent News -->
    <div class="bg-white rounded-lg shadow">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900">Berita Terbaru</h3>
        </div>
        <div class="p-6">
            @if($recentNews->count() > 0)
                <div class="space-y-4">
                    @foreach($recentNews as $news)
                        <div class="flex items-start">
                            <div class="flex-1">
                                <h4 class="text-sm font-medium text-gray-900">{{ $news->title }}</h4>
                                <p class="text-xs text-gray-500 mt-1">{{ $news->created_at->diffForHumans() }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-500 text-sm">Belum ada berita</p>
            @endif
        </div>
    </div>
    
    <!-- Recent Reports -->
    <div class="bg-white rounded-lg shadow">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900">Laporan Terbaru</h3>
        </div>
        <div class="p-6">
            @if($recentReports->count() > 0)
                <div class="space-y-4">
                    @foreach($recentReports as $report)
                        <div class="flex items-start">
                            <div class="flex-1">
                                <h4 class="text-sm font-medium text-gray-900">{{ $report->title }}</h4>
                                <p class="text-xs text-gray-500 mt-1">{{ $report->created_at->diffForHumans() }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-500 text-sm">Belum ada laporan</p>
            @endif
        </div>
    </div>
</div>

<div class="mt-6 bg-blue-50 border border-blue-200 rounded-lg p-6">
    <h3 class="text-lg font-semibold text-blue-900 mb-2">🎉 Selamat Datang di Admin Panel Baru!</h3>
    <p class="text-blue-700">
        Admin panel ini dibuat secara manual menggantikan Filament. Semua data Anda tetap aman dan tersimpan di database.
    </p>
    <p class="text-blue-700 mt-2">
        Resource management (CRUD) untuk setiap modul akan ditambahkan secara bertahap.
    </p>
</div>
@endsection
