@extends('admin.layouts.app')

@section('title', $report->title)
@section('page-title', 'Detail Laporan')

@section('content')
<div class="max-w-5xl mx-auto">
    <!-- Back Button -->
    <div class="mb-6">
        <a href="{{ route('admin.reports.index') }}" class="inline-flex items-center text-gray-600 hover:text-gray-800 transition">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Kembali ke Daftar Laporan
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Report Header -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="p-6">
                    <div class="flex items-start gap-4">
                        @if($report->cover_image)
                            <img src="{{ asset('storage/' . $report->cover_image) }}" 
                                alt="{{ $report->title }}" 
                                class="w-24 h-24 rounded-xl object-cover shadow-sm">
                        @else
                            <div class="w-24 h-24 rounded-xl bg-gradient-to-br from-blue-100 to-blue-200 flex items-center justify-center">
                                <svg class="w-12 h-12 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                            </div>
                        @endif
                        <div class="flex-1">
                            <div class="flex items-start justify-between">
                                <div>
                                    <h1 class="text-2xl font-bold text-gray-900">{{ $report->title }}</h1>
                                    <div class="flex flex-wrap items-center gap-2 mt-2">
                                        <span class="inline-flex px-2 py-1 text-xs font-medium rounded-full
                                            @if($report->type === 'financial') bg-green-100 text-green-700
                                            @elseif($report->type === 'activity') bg-blue-100 text-blue-700
                                            @elseif($report->type === 'annual') bg-purple-100 text-purple-700
                                            @else bg-orange-100 text-orange-700 @endif">
                                            {{ $reportTypes[$report->type] ?? $report->type }}
                                        </span>
                                        <span class="inline-flex px-2 py-1 text-xs font-medium rounded-full
                                            @if($report->status === 'published') bg-green-100 text-green-700
                                            @elseif($report->status === 'draft') bg-yellow-100 text-yellow-700
                                            @else bg-gray-100 text-gray-700 @endif">
                                            {{ $statuses[$report->status] ?? $report->status }}
                                        </span>
                                        @if($report->category)
                                            <span class="inline-flex px-2 py-1 text-xs font-medium rounded-full bg-gray-100 text-gray-700">
                                                {{ $report->category->name }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if($report->trashed())
                        <div class="mt-4 p-4 bg-red-50 border border-red-200 rounded-lg">
                            <div class="flex items-center gap-2 text-red-700">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                                <span class="font-medium">Laporan ini telah dihapus pada {{ $report->deleted_at->format('d M Y, H:i') }}</span>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Period & Stats -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 text-center">
                    <p class="text-gray-500 text-sm">Periode</p>
                    <p class="text-lg font-bold text-gray-900">{{ $report->period }}</p>
                </div>
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 text-center">
                    <p class="text-gray-500 text-sm">Tahun</p>
                    <p class="text-lg font-bold text-gray-900">{{ $report->year }}</p>
                </div>
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 text-center">
                    <p class="text-gray-500 text-sm">Downloads</p>
                    <p class="text-lg font-bold text-green-600">{{ number_format($report->downloads) }}</p>
                </div>
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 text-center">
                    <p class="text-gray-500 text-sm">Dipublikasikan</p>
                    <p class="text-lg font-bold text-gray-900">{{ $report->published_at?->format('d/m/Y') ?? '-' }}</p>
                </div>
            </div>

            <!-- Description -->
            @if($report->description)
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-3">Deskripsi</h3>
                    <p class="text-gray-600">{{ $report->description }}</p>
                </div>
            @endif

            <!-- Content -->
            @if($report->content)
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-3">Konten / Ringkasan</h3>
                    <div class="prose prose-gray max-w-none">
                        {!! nl2br(e($report->content)) !!}
                    </div>
                </div>
            @endif

            <!-- File Preview -->
            @if($report->file_path)
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200 bg-gray-50 flex items-center justify-between">
                        <h3 class="text-lg font-semibold text-gray-900">File Laporan</h3>
                        <a href="{{ route('admin.reports.download', $report) }}" 
                            class="inline-flex items-center gap-2 px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition text-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                            </svg>
                            Download
                        </a>
                    </div>
                    <div class="p-6">
                        <div class="flex items-center gap-4 p-4 bg-gray-50 rounded-xl">
                            <div class="w-16 h-16 rounded-xl flex items-center justify-center
                                @if($report->file_type === 'pdf') bg-red-100
                                @elseif(in_array($report->file_type, ['xls', 'xlsx'])) bg-green-100
                                @else bg-blue-100 @endif">
                                @if($report->file_type === 'pdf')
                                    <svg class="w-8 h-8 text-red-600" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8l-6-6zm-1 2l5 5h-5V4zM8.5 13H10v3.5a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-3a.5.5 0 0 1 .5-.5zm3 0h1.5a1.5 1.5 0 0 1 0 3H12v1.5a.5.5 0 0 1-.5.5.5.5 0 0 1-.5-.5V13.5a.5.5 0 0 1 .5-.5zm5 0a.5.5 0 0 1 .5.5.5.5 0 0 1-.5.5H16v1h1a.5.5 0 0 1 0 1h-1v1.5a.5.5 0 0 1-.5.5.5.5 0 0 1-.5-.5v-4a.5.5 0 0 1 .5-.5h1z"/>
                                    </svg>
                                @elseif(in_array($report->file_type, ['xls', 'xlsx']))
                                    <svg class="w-8 h-8 text-green-600" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8l-6-6zm-1 2l5 5h-5V4zM8 13h2l1 2 1-2h2l-2 3 2 3h-2l-1-2-1 2H8l2-3-2-3z"/>
                                    </svg>
                                @else
                                    <svg class="w-8 h-8 text-blue-600" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8l-6-6zm-1 2l5 5h-5V4zM8 13h8v1H8v-1zm0 2h8v1H8v-1zm0 2h5v1H8v-1z"/>
                                    </svg>
                                @endif
                            </div>
                            <div>
                                <p class="font-medium text-gray-900">{{ $report->title }}.{{ $report->file_type }}</p>
                                <p class="text-sm text-gray-500">{{ $report->getFileSizeFormatted() }} • {{ strtoupper($report->file_type) }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Quick Actions -->
            @if(!$report->trashed())
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4">
                    <h3 class="font-semibold text-gray-900 mb-3">Aksi Cepat</h3>
                    <div class="space-y-2">
                        <a href="{{ route('admin.reports.edit', $report) }}" 
                            class="flex items-center gap-2 w-full px-4 py-2 text-left text-gray-700 hover:bg-gray-50 rounded-lg transition">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                            Edit Laporan
                        </a>
                        @if($report->file_path)
                            <a href="{{ route('admin.reports.download', $report) }}" 
                                class="flex items-center gap-2 w-full px-4 py-2 text-left text-green-700 hover:bg-green-50 rounded-lg transition">
                                <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                                </svg>
                                Download File
                            </a>
                        @endif
                        @if($report->status === 'draft')
                            <form method="POST" action="{{ route('admin.reports.bulk-action') }}">
                                @csrf
                                <input type="hidden" name="ids" value='[{{ $report->id }}]'>
                                <button type="submit" name="action" value="publish"
                                    class="flex items-center gap-2 w-full px-4 py-2 text-left text-green-700 hover:bg-green-50 rounded-lg transition">
                                    <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    Publikasikan
                                </button>
                            </form>
                        @elseif($report->status === 'published')
                            <form method="POST" action="{{ route('admin.reports.bulk-action') }}">
                                @csrf
                                <input type="hidden" name="ids" value='[{{ $report->id }}]'>
                                <button type="submit" name="action" value="archive"
                                    class="flex items-center gap-2 w-full px-4 py-2 text-left text-gray-700 hover:bg-gray-50 rounded-lg transition">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path>
                                    </svg>
                                    Arsipkan
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            @else
                <div class="bg-red-50 rounded-xl shadow-sm border border-red-200 p-4">
                    <h3 class="font-semibold text-red-900 mb-3">Laporan Dihapus</h3>
                    <div class="space-y-2">
                        <form method="POST" action="{{ route('admin.reports.restore', $report->id) }}">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="flex items-center gap-2 w-full px-4 py-2 text-left text-green-700 bg-white hover:bg-green-50 rounded-lg transition">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                </svg>
                                Pulihkan Laporan
                            </button>
                        </form>
                        <form method="POST" action="{{ route('admin.reports.force-delete', $report->id) }}" onsubmit="return confirm('Hapus permanen? Tidak dapat dikembalikan!')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="flex items-center gap-2 w-full px-4 py-2 text-left text-red-700 bg-white hover:bg-red-50 rounded-lg transition">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                                Hapus Permanen
                            </button>
                        </form>
                    </div>
                </div>
            @endif

            <!-- Period Info -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4">
                <h3 class="font-semibold text-gray-900 mb-3">Informasi Periode</h3>
                <dl class="space-y-3 text-sm">
                    <div class="flex justify-between">
                        <dt class="text-gray-500">Tipe Laporan</dt>
                        <dd class="font-medium text-gray-900">{{ $reportTypes[$report->type] ?? $report->type }}</dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="text-gray-500">Periode</dt>
                        <dd class="font-medium text-gray-900">{{ $report->period }}</dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="text-gray-500">Tahun</dt>
                        <dd class="font-medium text-gray-900">{{ $report->year }}</dd>
                    </div>
                    @if($report->month)
                        <div class="flex justify-between">
                            <dt class="text-gray-500">Bulan</dt>
                            <dd class="font-medium text-gray-900">{{ $months[$report->month] ?? $report->month }}</dd>
                        </div>
                    @endif
                    @if($report->quarter)
                        <div class="flex justify-between">
                            <dt class="text-gray-500">Kuartal</dt>
                            <dd class="font-medium text-gray-900">Q{{ $report->quarter }}</dd>
                        </div>
                    @endif
                </dl>
            </div>

            <!-- Meta Info -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4">
                <h3 class="font-semibold text-gray-900 mb-3">Informasi</h3>
                <dl class="space-y-3 text-sm">
                    <div class="flex justify-between">
                        <dt class="text-gray-500">Dibuat oleh</dt>
                        <dd class="font-medium text-gray-900">{{ $report->user->name ?? 'N/A' }}</dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="text-gray-500">Dibuat</dt>
                        <dd class="font-medium text-gray-900">{{ $report->created_at->format('d M Y, H:i') }}</dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="text-gray-500">Diperbarui</dt>
                        <dd class="font-medium text-gray-900">{{ $report->updated_at->format('d M Y, H:i') }}</dd>
                    </div>
                    @if($report->published_at)
                        <div class="flex justify-between">
                            <dt class="text-gray-500">Dipublikasikan</dt>
                            <dd class="font-medium text-green-600">{{ $report->published_at->format('d M Y, H:i') }}</dd>
                        </div>
                    @endif
                    @if($report->deleted_at)
                        <div class="flex justify-between">
                            <dt class="text-gray-500">Dihapus</dt>
                            <dd class="font-medium text-red-600">{{ $report->deleted_at->format('d M Y, H:i') }}</dd>
                        </div>
                    @endif
                </dl>
            </div>
        </div>
    </div>
</div>
@endsection
