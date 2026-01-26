@extends('layouts.app')

@section('title', 'Galeri Foto & Video')
@section('description', 'Galeri foto dan video kegiatan BUMNag Lubas Mandiri')

@section('content')
<div x-data="galleryModal()">
    <!-- Page Header -->
    <section class="relative bg-gradient-to-br from-sage via-sage-600 to-primary text-white py-24 mt-20">
        <div class="absolute inset-0 bg-black/20"></div>
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold mb-4">
                    Galeri Kami
                </h1>
                <p class="text-xl text-white/90 max-w-2xl mx-auto">
                    Dokumentasi kegiatan dan momen berharga BUMNag Lubas Mandiri
                </p>
            </div>
        </div>
    </section>

    <!-- Gallery Grid -->
    <section class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            @if($galleries->count() > 0)
            <!-- Instagram-style Grid -->
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-1 md:gap-2">
                @foreach($galleries as $index => $gallery)
                <div class="relative aspect-square bg-gray-200 overflow-hidden group cursor-pointer"
                     @click="openModal({{ $index }})">
                    @if($gallery->file_type === 'image')
                        <img src="{{ Storage::url($gallery->file_path) }}" 
                             alt="{{ $gallery->title }}" 
                             class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                    @else
                        <video class="w-full h-full object-cover">
                            <source src="{{ Storage::url($gallery->file_path) }}" type="{{ $gallery->mime_type }}">
                        </video>
                        <div class="absolute top-2 right-2">
                            <svg class="w-6 h-6 text-white drop-shadow-lg" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M8 5v14l11-7z"/>
                            </svg>
                        </div>
                    @endif
                    
                    <!-- Hover Overlay -->
                    <div class="absolute inset-0 bg-black/0 group-hover:bg-black/40 transition-all duration-300 flex items-center justify-center opacity-0 group-hover:opacity-100">
                        <div class="text-white text-center">
                            <div class="flex items-center justify-center space-x-4">
                                @if($gallery->views)
                                <div class="flex items-center">
                                    <svg class="w-6 h-6 mr-1" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z"/>
                                    </svg>
                                    <span class="font-semibold">{{ number_format($gallery->views) }}</span>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-12 flex justify-center">
                {{ $galleries->links() }}
            </div>
            @else
            <div class="text-center py-20">
                <svg class="w-24 h-24 text-gray-300 mx-auto mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
                <h3 class="text-2xl font-bold text-gray-700 mb-2">Belum Ada Galeri</h3>
                <p class="text-gray-500">Galeri akan ditampilkan di sini.</p>
            </div>
            @endif
        </div>
    </section>

    <!-- Modal Detail (Instagram-style) -->
    <div x-show="isOpen" 
         x-cloak
         @click.self="closeModal()"
         class="fixed inset-0 z-50 flex items-center justify-center bg-black/90 backdrop-blur-sm"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0">
        
        <div class="relative w-full h-full max-w-7xl mx-auto flex items-center justify-center p-4">
            <!-- Close Button -->
            <button @click="closeModal()" 
                    class="absolute top-4 right-4 z-10 text-white hover:text-gray-300 transition-colors">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>

            <!-- Previous Button -->
            <button @click="previousImage()" 
                    x-show="currentIndex > 0"
                    class="absolute left-4 text-white hover:text-gray-300 transition-colors z-10">
                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
            </button>

            <!-- Next Button -->
            <button @click="nextImage()" 
                    x-show="currentIndex < galleries.length - 1"
                    class="absolute right-4 text-white hover:text-gray-300 transition-colors z-10">
                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </button>

            <!-- Modal Content -->
            <div class="bg-white rounded-none md:rounded-lg overflow-hidden flex flex-col md:flex-row max-h-[90vh] w-full md:w-auto shadow-2xl">
                <!-- Image/Video Section -->
                <div class="flex-shrink-0 bg-black flex items-center justify-center md:max-w-[60vw]">
                    <template x-if="currentGallery && currentGallery.file_type === 'image'">
                        <img :src="currentGallery.file_url" 
                             :alt="currentGallery.title"
                             class="max-h-[50vh] md:max-h-[90vh] w-auto object-contain">
                    </template>
                    <template x-if="currentGallery && currentGallery.file_type === 'video'">
                        <video controls class="max-h-[50vh] md:max-h-[90vh] w-auto">
                            <source :src="currentGallery.file_url" :type="currentGallery.mime_type">
                        </video>
                    </template>
                </div>

                <!-- Info Section (Instagram-style sidebar) -->
                <div class="w-full md:w-96 flex flex-col bg-white max-h-[40vh] md:max-h-[90vh]">
                    <!-- Header -->
                    <div class="p-4 border-b border-gray-200">
                        <div class="flex items-center">
                            <div class="w-10 h-10 bg-gradient-to-br from-primary to-sage rounded-full flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="font-semibold text-gray-900" x-text="currentGallery?.photographer || 'BUMNag Lubas Mandiri'"></p>
                                <p class="text-xs text-gray-500" x-text="currentGallery?.location"></p>
                            </div>
                        </div>
                    </div>

                    <!-- Caption & Info -->
                    <div class="flex-1 overflow-y-auto p-4">
                        <div class="mb-4">
                            <h3 class="text-lg font-bold text-gray-900 mb-2" x-text="currentGallery?.title"></h3>
                            <p class="text-gray-700 whitespace-pre-line" x-text="currentGallery?.description"></p>
                        </div>

                        <!-- Meta Info -->
                        <div class="space-y-2 text-sm text-gray-600">
                            <div class="flex items-center" x-show="currentGallery?.taken_date">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                <span x-text="currentGallery?.taken_date_formatted"></span>
                            </div>
                            <div class="flex items-center" x-show="currentGallery?.album">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                </svg>
                                <span>Album: <span x-text="currentGallery?.album"></span></span>
                            </div>
                            <div class="flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                                <span x-text="(currentGallery?.views || 0) + ' views'"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function galleryModal() {
        return {
            isOpen: false,
            currentIndex: 0,
            galleries: [
                @foreach($galleries as $gallery)
                {
                    id: {{ $gallery->id }},
                    title: {!! json_encode($gallery->title) !!},
                    description: {!! json_encode($gallery->description) !!},
                    file_url: {!! json_encode(Storage::url($gallery->file_path)) !!},
                    file_type: {!! json_encode($gallery->file_type) !!},
                    mime_type: {!! json_encode($gallery->mime_type) !!},
                    photographer: {!! json_encode($gallery->photographer) !!},
                    location: {!! json_encode($gallery->location) !!},
                    taken_date: {!! json_encode($gallery->taken_date) !!},
                    taken_date_formatted: {!! json_encode($gallery->taken_date ? $gallery->taken_date->format('d F Y') : null) !!},
                    album: {!! json_encode($gallery->album) !!},
                    views: {{ $gallery->views ?? 0 }}
                }{{ !$loop->last ? ',' : '' }}
                @endforeach
            ],

            get currentGallery() {
                return this.galleries[this.currentIndex] || null;
            },

            openModal(index) {
                this.currentIndex = index;
                this.isOpen = true;
                document.body.style.overflow = 'hidden';
            },

            closeModal() {
                this.isOpen = false;
                document.body.style.overflow = '';
            },

            nextImage() {
                if (this.currentIndex < this.galleries.length - 1) {
                    this.currentIndex++;
                }
            },

            previousImage() {
                if (this.currentIndex > 0) {
                    this.currentIndex--;
                }
            },

            init() {
                // Keyboard navigation
                window.addEventListener('keydown', (e) => {
                    if (!this.isOpen) return;
                    
                    if (e.key === 'Escape') {
                        this.closeModal();
                    } else if (e.key === 'ArrowRight') {
                        this.nextImage();
                    } else if (e.key === 'ArrowLeft') {
                        this.previousImage();
                    }
                });
            }
        }
    }
</script>
@endpush

<style>
    [x-cloak] {
        display: none !important;
    }
</style>
@endsection
