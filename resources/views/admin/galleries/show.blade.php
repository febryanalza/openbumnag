@extends('admin.layouts.app')

@section('title', $gallery->title)
@section('page-title', 'Detail Media')

@section('content')
<div class="max-w-5xl mx-auto">
    <!-- Back Button -->
    <div class="mb-6">
        <a href="{{ route('admin.galleries.index') }}" class="inline-flex items-center text-gray-600 hover:text-gray-800 transition">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Kembali ke Galeri
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Media Display -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="relative bg-gray-900">
                    @if($gallery->file_type === 'image')
                        <img src="{{ asset('storage/' . $gallery->file_path) }}" 
                            alt="{{ $gallery->title }}" 
                            class="w-full max-h-[600px] object-contain">
                    @else
                        <video src="{{ asset('storage/' . $gallery->file_path) }}" 
                            class="w-full max-h-[600px]" 
                            controls 
                            poster="">
                            Browser Anda tidak mendukung tag video.
                        </video>
                    @endif

                    <!-- Badges -->
                    <div class="absolute top-4 left-4 flex gap-2">
                        @if($gallery->is_featured)
                            <span class="px-3 py-1 bg-yellow-500 text-white rounded-full text-sm font-medium shadow">
                                ⭐ Unggulan
                            </span>
                        @endif
                        <span class="px-3 py-1 bg-white/90 text-gray-800 rounded-full text-sm font-medium shadow capitalize">
                            {{ $fileTypes[$gallery->file_type] ?? $gallery->file_type }}
                        </span>
                    </div>

                    @if($gallery->trashed())
                        <div class="absolute inset-0 bg-red-500/30 flex items-center justify-center">
                            <span class="bg-red-600 text-white px-4 py-2 rounded-lg text-lg font-medium">
                                Media ini telah dihapus
                            </span>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Title & Description -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h1 class="text-2xl font-bold text-gray-900 mb-2">{{ $gallery->title }}</h1>
                
                <div class="flex flex-wrap items-center gap-3 mb-4 text-sm text-gray-500">
                    <span class="inline-flex items-center gap-1 px-2 py-1 rounded-full 
                        @if($gallery->type === 'event') bg-blue-100 text-blue-700
                        @elseif($gallery->type === 'activity') bg-green-100 text-green-700
                        @elseif($gallery->type === 'product') bg-purple-100 text-purple-700
                        @else bg-gray-100 text-gray-700 @endif">
                        {{ $galleryTypes[$gallery->type] ?? $gallery->type }}
                    </span>
                    @if($gallery->album)
                        <span class="inline-flex items-center gap-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"></path>
                            </svg>
                            {{ $gallery->album }}
                        </span>
                    @endif
                    <span class="inline-flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                        {{ number_format($gallery->views) }} views
                    </span>
                </div>

                @if($gallery->description)
                    <div class="prose prose-gray max-w-none">
                        <p>{{ $gallery->description }}</p>
                    </div>
                @else
                    <p class="text-gray-400 italic">Tidak ada deskripsi</p>
                @endif
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Quick Actions -->
            @if(!$gallery->trashed())
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4">
                    <h3 class="font-semibold text-gray-900 mb-3">Aksi Cepat</h3>
                    <div class="space-y-2">
                        <a href="{{ route('admin.galleries.edit', $gallery) }}" 
                            class="flex items-center gap-2 w-full px-4 py-2 text-left text-gray-700 hover:bg-gray-50 rounded-lg transition">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                            Edit Media
                        </a>
                        <a href="{{ asset('storage/' . $gallery->file_path) }}" target="_blank" download
                            class="flex items-center gap-2 w-full px-4 py-2 text-left text-gray-700 hover:bg-gray-50 rounded-lg transition">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                            </svg>
                            Download File
                        </a>
                        @if(!$gallery->is_featured)
                            <form method="POST" action="{{ route('admin.galleries.bulk-action') }}">
                                @csrf
                                <input type="hidden" name="ids" value='[{{ $gallery->id }}]'>
                                <button type="submit" name="action" value="feature"
                                    class="flex items-center gap-2 w-full px-4 py-2 text-left text-yellow-700 hover:bg-yellow-50 rounded-lg transition">
                                    <svg class="w-5 h-5 text-yellow-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                    </svg>
                                    Jadikan Unggulan
                                </button>
                            </form>
                        @else
                            <form method="POST" action="{{ route('admin.galleries.bulk-action') }}">
                                @csrf
                                <input type="hidden" name="ids" value='[{{ $gallery->id }}]'>
                                <button type="submit" name="action" value="unfeature"
                                    class="flex items-center gap-2 w-full px-4 py-2 text-left text-gray-700 hover:bg-gray-50 rounded-lg transition">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path>
                                    </svg>
                                    Hapus dari Unggulan
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            @else
                <div class="bg-red-50 rounded-xl shadow-sm border border-red-200 p-4">
                    <h3 class="font-semibold text-red-900 mb-3">Media Dihapus</h3>
                    <div class="space-y-2">
                        <form method="POST" action="{{ route('admin.galleries.restore', $gallery->id) }}">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="flex items-center gap-2 w-full px-4 py-2 text-left text-green-700 bg-white hover:bg-green-50 rounded-lg transition">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                </svg>
                                Pulihkan Media
                            </button>
                        </form>
                        <form method="POST" action="{{ route('admin.galleries.force-delete', $gallery->id) }}" onsubmit="return confirm('Hapus permanen? Tidak dapat dikembalikan!')">
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

            <!-- Media Info -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4">
                <h3 class="font-semibold text-gray-900 mb-3">Informasi File</h3>
                <dl class="space-y-3 text-sm">
                    <div class="flex justify-between">
                        <dt class="text-gray-500">Tipe File</dt>
                        <dd class="font-medium text-gray-900 capitalize">{{ $gallery->mime_type ?? ($fileTypes[$gallery->file_type] ?? $gallery->file_type) }}</dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="text-gray-500">Ukuran</dt>
                        <dd class="font-medium text-gray-900">{{ number_format($gallery->file_size / 1024 / 1024, 2) }} MB</dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="text-gray-500">Urutan</dt>
                        <dd class="font-medium text-gray-900">{{ $gallery->order }}</dd>
                    </div>
                </dl>
            </div>

            <!-- Details -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4">
                <h3 class="font-semibold text-gray-900 mb-3">Detail</h3>
                <dl class="space-y-3 text-sm">
                    @if($gallery->photographer)
                        <div class="flex justify-between">
                            <dt class="text-gray-500">Fotografer</dt>
                            <dd class="font-medium text-gray-900">{{ $gallery->photographer }}</dd>
                        </div>
                    @endif
                    @if($gallery->location)
                        <div class="flex justify-between">
                            <dt class="text-gray-500">Lokasi</dt>
                            <dd class="font-medium text-gray-900">{{ $gallery->location }}</dd>
                        </div>
                    @endif
                    @if($gallery->taken_date)
                        <div class="flex justify-between">
                            <dt class="text-gray-500">Tanggal Diambil</dt>
                            <dd class="font-medium text-gray-900">{{ $gallery->taken_date->format('d M Y') }}</dd>
                        </div>
                    @endif
                    <div class="flex justify-between">
                        <dt class="text-gray-500">Diupload oleh</dt>
                        <dd class="font-medium text-gray-900">{{ $gallery->user->name ?? 'N/A' }}</dd>
                    </div>
                </dl>
            </div>

            <!-- Timestamps -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4">
                <h3 class="font-semibold text-gray-900 mb-3">Waktu</h3>
                <dl class="space-y-3 text-sm">
                    <div class="flex justify-between">
                        <dt class="text-gray-500">Dibuat</dt>
                        <dd class="font-medium text-gray-900">{{ $gallery->created_at->format('d M Y, H:i') }}</dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="text-gray-500">Diperbarui</dt>
                        <dd class="font-medium text-gray-900">{{ $gallery->updated_at->format('d M Y, H:i') }}</dd>
                    </div>
                    @if($gallery->deleted_at)
                        <div class="flex justify-between">
                            <dt class="text-gray-500">Dihapus</dt>
                            <dd class="font-medium text-red-600">{{ $gallery->deleted_at->format('d M Y, H:i') }}</dd>
                        </div>
                    @endif
                </dl>
            </div>
        </div>
    </div>
</div>
@endsection

