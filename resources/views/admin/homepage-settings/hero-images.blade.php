@extends('admin.layouts.app')

@section('title', 'Kelola Gambar Slider')
@section('header', 'Kelola Gambar Slider')

@section('content')
<div class="space-y-6" x-data="heroImagesManager()">
    {{-- Breadcrumb --}}
    <nav class="flex" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
            <li class="inline-flex items-center">
                <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center text-sm font-medium text-gray-500 hover:text-amber-600">
                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path>
                    </svg>
                    Dashboard
                </a>
            </li>
            <li>
                <div class="flex items-center">
                    <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                    </svg>
                    <a href="{{ route('admin.homepage-settings.index') }}" class="ml-1 text-sm font-medium text-gray-500 hover:text-amber-600 md:ml-2">Pengaturan Homepage</a>
                </div>
            </li>
            <li aria-current="page">
                <div class="flex items-center">
                    <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                    </svg>
                    <span class="ml-1 text-sm font-medium text-gray-900 md:ml-2">Gambar Slider</span>
                </div>
            </li>
        </ol>
    </nav>

    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Gambar Slider Hero</h1>
            <p class="text-gray-600">Kelola gambar yang ditampilkan di slider halaman depan. Maksimal {{ $maxSlides }} gambar.</p>
        </div>
        <a href="{{ route('admin.homepage-settings.index', ['section' => 'hero']) }}" 
           class="inline-flex items-center gap-2 px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium text-sm rounded-lg transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Kembali ke Pengaturan
        </a>
    </div>

    {{-- Stats --}}
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4">
            <div class="flex items-center gap-3">
                <div class="p-2 bg-purple-100 rounded-lg">
                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-2xl font-bold text-gray-900">{{ count($heroImages) }}</p>
                    <p class="text-sm text-gray-500">Gambar Aktif</p>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4">
            <div class="flex items-center gap-3">
                <div class="p-2 bg-blue-100 rounded-lg">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-2xl font-bold text-gray-900">{{ $maxSlides }}</p>
                    <p class="text-sm text-gray-500">Maksimal Gambar</p>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4">
            <div class="flex items-center gap-3">
                <div class="p-2 bg-green-100 rounded-lg">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-2xl font-bold text-gray-900">{{ $maxSlides - count($heroImages) }}</p>
                    <p class="text-sm text-gray-500">Slot Tersedia</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Upload Form --}}
    @if(count($heroImages) < $maxSlides)
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="p-4 border-b border-gray-200 bg-gradient-to-r from-green-50 to-emerald-50">
                <h3 class="font-semibold text-gray-900 flex items-center gap-2">
                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path>
                    </svg>
                    Upload Gambar Baru
                </h3>
            </div>
            <form method="POST" action="{{ route('admin.homepage-settings.hero-images.upload') }}" enctype="multipart/form-data" class="p-6">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="image" class="block text-sm font-medium text-gray-700 mb-2">
                            Pilih Gambar <span class="text-red-500">*</span>
                        </label>
                        <input type="file" 
                               id="image" 
                               name="image" 
                               accept="image/jpeg,image/png,image/jpg,image/webp"
                               required
                               class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-amber-50 file:text-amber-700 hover:file:bg-amber-100">
                        <p class="mt-1 text-xs text-gray-500">Format: JPEG, PNG, JPG, WEBP. Maksimal 5MB. Resolusi disarankan: 1920x1080</p>
                        @error('image')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                            Judul/Keterangan
                        </label>
                        <input type="text" 
                               id="title" 
                               name="title" 
                               placeholder="Contoh: Slider Utama"
                               class="block w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-amber-500 focus:border-amber-500">
                        <p class="mt-1 text-xs text-gray-500">Opsional. Untuk referensi internal saja.</p>
                    </div>
                </div>
                <div class="mt-6">
                    <button type="submit" class="inline-flex items-center gap-2 px-6 py-3 bg-green-600 hover:bg-green-700 text-white font-medium text-sm rounded-lg transition-colors shadow-lg hover:shadow-xl">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path>
                        </svg>
                        Upload Gambar
                    </button>
                </div>
            </form>
        </div>
    @else
        <div class="bg-amber-50 border border-amber-200 rounded-xl p-4">
            <div class="flex gap-3">
                <svg class="w-6 h-6 text-amber-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                </svg>
                <div>
                    <h4 class="font-medium text-amber-800">Batas Maksimal Tercapai</h4>
                    <p class="text-sm text-amber-700 mt-1">Anda telah mencapai batas maksimal {{ $maxSlides }} gambar. Hapus gambar yang ada untuk menambah gambar baru.</p>
                </div>
            </div>
        </div>
    @endif

    {{-- Images List --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="p-4 border-b border-gray-200 bg-gray-50 flex items-center justify-between">
            <h3 class="font-semibold text-gray-900">Daftar Gambar Slider</h3>
            @if(count($heroImages) > 1)
                <p class="text-sm text-gray-500">Drag & drop untuk mengubah urutan</p>
            @endif
        </div>

        @if(count($heroImages) > 0)
            <div class="p-4">
                <div class="space-y-4" id="sortable-images">
                    @foreach($heroImages as $index => $image)
                        <div class="flex flex-col sm:flex-row gap-4 p-4 bg-gray-50 rounded-xl border border-gray-200 hover:border-amber-300 transition-colors group" data-index="{{ $index }}">
                            {{-- Image Preview --}}
                            <div class="sm:w-48 flex-shrink-0">
                                <div class="aspect-video rounded-lg overflow-hidden bg-gray-200 relative">
                                    <img src="{{ Storage::url($image['path']) }}" 
                                         alt="{{ $image['title'] }}" 
                                         class="w-full h-full object-cover">
                                    <div class="absolute top-2 left-2 bg-black/60 text-white text-xs font-medium px-2 py-1 rounded">
                                        Slide {{ $index + 1 }}
                                    </div>
                                </div>
                            </div>

                            {{-- Image Details --}}
                            <div class="flex-1 min-w-0">
                                <form method="POST" action="{{ route('admin.homepage-settings.hero-images.update-title', $index) }}" class="flex flex-col sm:flex-row gap-3">
                                    @csrf
                                    @method('PUT')
                                    <div class="flex-1">
                                        <label class="block text-xs font-medium text-gray-500 mb-1">Judul/Keterangan</label>
                                        <input type="text" 
                                               name="title" 
                                               value="{{ $image['title'] }}"
                                               class="block w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-amber-500 focus:border-amber-500">
                                    </div>
                                    <div class="flex items-end">
                                        <button type="submit" class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium text-sm rounded-lg transition-colors">
                                            Simpan
                                        </button>
                                    </div>
                                </form>
                                
                                <div class="mt-3 flex flex-wrap gap-2">
                                    <span class="inline-flex items-center gap-1 text-xs text-gray-500">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                        {{ basename($image['path']) }}
                                    </span>
                                </div>
                            </div>

                            {{-- Actions --}}
                            <div class="flex sm:flex-col gap-2 sm:items-end justify-end">
                                {{-- Move buttons --}}
                                @if(count($heroImages) > 1)
                                    <div class="flex gap-1">
                                        @if($index > 0)
                                            <form method="POST" action="{{ route('admin.homepage-settings.hero-images.order') }}">
                                                @csrf
                                                <input type="hidden" name="order" value="{{ json_encode(array_merge([$index], array_diff(range(0, count($heroImages) - 1), [$index]))) }}">
                                                <button type="submit" class="p-2 bg-gray-100 hover:bg-gray-200 text-gray-600 rounded-lg transition-colors" title="Pindah ke atas">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path>
                                                    </svg>
                                                </button>
                                            </form>
                                        @endif
                                        @if($index < count($heroImages) - 1)
                                            <form method="POST" action="{{ route('admin.homepage-settings.hero-images.order') }}">
                                                @csrf
                                                @php
                                                    $newOrder = range(0, count($heroImages) - 1);
                                                    $temp = $newOrder[$index];
                                                    $newOrder[$index] = $newOrder[$index + 1];
                                                    $newOrder[$index + 1] = $temp;
                                                @endphp
                                                <input type="hidden" name="order" value="{{ json_encode($newOrder) }}">
                                                <button type="submit" class="p-2 bg-gray-100 hover:bg-gray-200 text-gray-600 rounded-lg transition-colors" title="Pindah ke bawah">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                                    </svg>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                @endif
                                
                                {{-- Delete button --}}
                                <form method="POST" action="{{ route('admin.homepage-settings.hero-images.delete', $index) }}" 
                                      onsubmit="return confirm('Apakah Anda yakin ingin menghapus gambar ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 bg-red-50 hover:bg-red-100 text-red-600 rounded-lg transition-colors" title="Hapus gambar">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @else
            <div class="p-12 text-center">
                <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
                <h3 class="text-lg font-medium text-gray-900 mb-2">Belum ada gambar slider</h3>
                <p class="text-gray-500 mb-4">Upload gambar pertama Anda untuk slider halaman depan.</p>
            </div>
        @endif
    </div>

    {{-- Preview Section --}}
    @if(count($heroImages) > 0)
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="p-4 border-b border-gray-200 bg-gray-50">
                <h3 class="font-semibold text-gray-900">Preview Slider</h3>
            </div>
            <div class="p-4">
                <div class="relative aspect-[21/9] rounded-xl overflow-hidden bg-gray-900" x-data="{ currentSlide: 0 }">
                    @foreach($heroImages as $index => $image)
                        <div class="absolute inset-0 transition-opacity duration-500"
                             :class="currentSlide === {{ $index }} ? 'opacity-100' : 'opacity-0'">
                            <img src="{{ Storage::url($image['path']) }}" 
                                 alt="{{ $image['title'] }}" 
                                 class="w-full h-full object-cover">
                            <div class="absolute inset-0 bg-gradient-to-r from-black/60 via-black/30 to-transparent"></div>
                        </div>
                    @endforeach
                    
                    {{-- Navigation --}}
                    @if(count($heroImages) > 1)
                        <div class="absolute bottom-4 left-1/2 transform -translate-x-1/2 flex gap-2">
                            @foreach($heroImages as $index => $image)
                                <button @click="currentSlide = {{ $index }}"
                                        class="w-2 h-2 rounded-full transition-colors"
                                        :class="currentSlide === {{ $index }} ? 'bg-white' : 'bg-white/50'">
                                </button>
                            @endforeach
                        </div>
                        <button @click="currentSlide = currentSlide > 0 ? currentSlide - 1 : {{ count($heroImages) - 1 }}"
                                class="absolute left-4 top-1/2 transform -translate-y-1/2 p-2 bg-white/20 hover:bg-white/30 rounded-full text-white transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                            </svg>
                        </button>
                        <button @click="currentSlide = currentSlide < {{ count($heroImages) - 1 }} ? currentSlide + 1 : 0"
                                class="absolute right-4 top-1/2 transform -translate-y-1/2 p-2 bg-white/20 hover:bg-white/30 rounded-full text-white transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </button>
                    @endif
                </div>
            </div>
        </div>
    @endif
</div>

@push('scripts')
<script>
    function heroImagesManager() {
        return {
            // Additional JavaScript functionality can be added here
        }
    }
</script>
@endpush
@endsection
