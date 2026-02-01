@extends('admin.layouts.app')

@section('title', $bumnagProfile->name)
@section('header', 'Detail BUMNag')

@section('content')
<div class="max-w-5xl mx-auto">
    <div class="mb-6 flex items-center justify-between">
        <a href="{{ route('admin.bumnag-profiles.index') }}" class="inline-flex items-center gap-2 text-gray-600 hover:text-gray-900 transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Kembali
        </a>
        <a href="{{ route('admin.bumnag-profiles.edit', $bumnagProfile) }}" class="inline-flex items-center gap-2 px-4 py-2 bg-amber-500 hover:bg-amber-600 text-white font-medium text-sm rounded-lg transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
            </svg>
            Edit
        </a>
    </div>

    {{-- Header --}}
    <div class="relative rounded-xl overflow-hidden mb-6">
        @if($bumnagProfile->banner)
            <img src="{{ Storage::url($bumnagProfile->banner) }}" alt="Banner" class="w-full h-48 object-cover">
            <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent"></div>
        @else
            <div class="w-full h-48 bg-gradient-to-r from-amber-500 to-orange-500"></div>
        @endif
        <div class="absolute bottom-0 left-0 right-0 p-6">
            <div class="flex items-end gap-4">
                @if($bumnagProfile->logo)
                    <img src="{{ Storage::url($bumnagProfile->logo) }}" alt="{{ $bumnagProfile->name }}" class="w-20 h-20 rounded-xl object-cover border-4 border-white shadow-lg">
                @else
                    <div class="w-20 h-20 rounded-xl bg-white shadow-lg flex items-center justify-center">
                        <span class="text-2xl font-bold text-amber-600">{{ strtoupper(substr($bumnagProfile->name, 0, 2)) }}</span>
                    </div>
                @endif
                <div class="text-white mb-1">
                    <h1 class="text-2xl font-bold">{{ $bumnagProfile->name }}</h1>
                    <p class="text-white/80">{{ $bumnagProfile->nagari_name }}</p>
                </div>
                <div class="ml-auto">
                    @if($bumnagProfile->is_active)
                        <span class="px-3 py-1 rounded-full text-sm font-medium bg-green-500 text-white">Aktif</span>
                    @else
                        <span class="px-3 py-1 rounded-full text-sm font-medium bg-yellow-500 text-white">Nonaktif</span>
                    @endif
                </div>
            </div>
        </div>
    </div>

    @if($bumnagProfile->tagline)
        <p class="text-lg text-gray-600 italic mb-6 text-center">"{{ $bumnagProfile->tagline }}"</p>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Main Content --}}
        <div class="lg:col-span-2 space-y-6">
            {{-- Tentang --}}
            @if($bumnagProfile->about)
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-3">Tentang BUMNag</h3>
                    <div class="prose prose-sm max-w-none text-gray-600">
                        {!! nl2br(e($bumnagProfile->about)) !!}
                    </div>
                </div>
            @endif

            {{-- Visi Misi --}}
            @if($bumnagProfile->vision || $bumnagProfile->mission)
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Visi & Misi</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        @if($bumnagProfile->vision)
                            <div>
                                <h4 class="text-sm font-medium text-amber-600 mb-2">VISI</h4>
                                <p class="text-gray-600 text-sm">{!! nl2br(e($bumnagProfile->vision)) !!}</p>
                            </div>
                        @endif
                        @if($bumnagProfile->mission)
                            <div>
                                <h4 class="text-sm font-medium text-amber-600 mb-2">MISI</h4>
                                <p class="text-gray-600 text-sm">{!! nl2br(e($bumnagProfile->mission)) !!}</p>
                            </div>
                        @endif
                    </div>
                </div>
            @endif

            {{-- Sejarah --}}
            @if($bumnagProfile->history)
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-3">Sejarah</h3>
                    <p class="text-gray-600 text-sm">{!! nl2br(e($bumnagProfile->history)) !!}</p>
                </div>
            @endif

            {{-- Katalog Produk --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between">
                    <h3 class="text-lg font-semibold text-gray-900">Katalog Produk</h3>
                    <span class="px-2 py-1 bg-amber-100 text-amber-800 text-xs font-medium rounded-full">{{ $bumnagProfile->catalogs->count() }} produk</span>
                </div>
                @if($bumnagProfile->catalogs->count() > 0)
                    <div class="p-6 grid grid-cols-2 md:grid-cols-3 gap-4">
                        @foreach($bumnagProfile->catalogs->take(6) as $catalog)
                            <a href="{{ route('admin.catalogs.show', $catalog) }}" class="group block">
                                <div class="aspect-square rounded-lg overflow-hidden bg-gray-100 mb-2">
                                    @if($catalog->featured_image)
                                        <img src="{{ Storage::url($catalog->featured_image) }}" alt="{{ $catalog->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center">
                                            <svg class="w-12 h-12 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                            </svg>
                                        </div>
                                    @endif
                                </div>
                                <p class="text-sm font-medium text-gray-900 truncate group-hover:text-amber-600">{{ $catalog->name }}</p>
                                <p class="text-sm text-amber-600 font-semibold">{{ $catalog->formatted_price }}</p>
                            </a>
                        @endforeach
                    </div>
                    @if($bumnagProfile->catalogs->count() > 6)
                        <div class="px-6 pb-6 text-center">
                            <a href="{{ route('admin.catalogs.index', ['bumnag_profile_id' => $bumnagProfile->id]) }}" class="text-amber-600 hover:text-amber-700 text-sm font-medium">
                                Lihat semua {{ $bumnagProfile->catalogs->count() }} produk →
                            </a>
                        </div>
                    @endif
                @else
                    <div class="p-12 text-center">
                        <svg class="w-12 h-12 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                        </svg>
                        <p class="text-gray-500 text-sm">Belum ada produk</p>
                        <a href="{{ route('admin.catalogs.create') }}" class="mt-2 inline-block text-amber-600 hover:text-amber-700 text-sm font-medium">Tambah Produk</a>
                    </div>
                @endif
            </div>
        </div>

        {{-- Sidebar --}}
        <div class="space-y-6">
            {{-- Legalitas --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Informasi Legalitas</h3>
                <div class="space-y-3 text-sm">
                    <div>
                        <p class="text-gray-500">Nomor Badan Hukum</p>
                        <p class="font-medium text-gray-900">{{ $bumnagProfile->legal_entity_number ?: '-' }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500">Tanggal Pendirian</p>
                        <p class="font-medium text-gray-900">{{ $bumnagProfile->established_date?->format('d F Y') ?: '-' }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500">Notaris</p>
                        <p class="font-medium text-gray-900">{{ $bumnagProfile->notary_name ?: '-' }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500">Nomor Akta</p>
                        <p class="font-medium text-gray-900">{{ $bumnagProfile->deed_number ?: '-' }}</p>
                    </div>
                </div>
            </div>

            {{-- Kontak --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Kontak</h3>
                <div class="space-y-3">
                    @if($bumnagProfile->address)
                        <div class="flex gap-3">
                            <svg class="w-5 h-5 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            <p class="text-sm text-gray-600">{{ $bumnagProfile->address }}{{ $bumnagProfile->postal_code ? ', ' . $bumnagProfile->postal_code : '' }}</p>
                        </div>
                    @endif
                    @if($bumnagProfile->phone)
                        <div class="flex items-center gap-3">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                            </svg>
                            <a href="tel:{{ $bumnagProfile->phone }}" class="text-sm text-gray-600 hover:text-amber-600">{{ $bumnagProfile->phone }}</a>
                        </div>
                    @endif
                    @if($bumnagProfile->email)
                        <div class="flex items-center gap-3">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                            <a href="mailto:{{ $bumnagProfile->email }}" class="text-sm text-gray-600 hover:text-amber-600">{{ $bumnagProfile->email }}</a>
                        </div>
                    @endif
                    @if($bumnagProfile->website)
                        <div class="flex items-center gap-3">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"></path>
                            </svg>
                            <a href="{{ $bumnagProfile->website }}" target="_blank" class="text-sm text-amber-600 hover:underline">{{ $bumnagProfile->website }}</a>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Sosial Media --}}
            @if($bumnagProfile->whatsapp || $bumnagProfile->facebook || $bumnagProfile->instagram || $bumnagProfile->twitter || $bumnagProfile->youtube || $bumnagProfile->tiktok)
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Media Sosial</h3>
                    <div class="flex flex-wrap gap-2">
                        @if($bumnagProfile->whatsapp)
                            <a href="https://wa.me/{{ $bumnagProfile->whatsapp }}" target="_blank" class="p-2 bg-green-100 text-green-600 rounded-lg hover:bg-green-200 transition-colors" title="WhatsApp">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                            </a>
                        @endif
                        @if($bumnagProfile->facebook)
                            <a href="https://facebook.com/{{ $bumnagProfile->facebook }}" target="_blank" class="p-2 bg-blue-100 text-blue-600 rounded-lg hover:bg-blue-200 transition-colors" title="Facebook">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                            </a>
                        @endif
                        @if($bumnagProfile->instagram)
                            <a href="https://instagram.com/{{ ltrim($bumnagProfile->instagram, '@') }}" target="_blank" class="p-2 bg-pink-100 text-pink-600 rounded-lg hover:bg-pink-200 transition-colors" title="Instagram">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/></svg>
                            </a>
                        @endif
                        @if($bumnagProfile->twitter)
                            <a href="https://twitter.com/{{ ltrim($bumnagProfile->twitter, '@') }}" target="_blank" class="p-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors" title="Twitter/X">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                            </a>
                        @endif
                        @if($bumnagProfile->youtube)
                            <a href="{{ $bumnagProfile->youtube }}" target="_blank" class="p-2 bg-red-100 text-red-600 rounded-lg hover:bg-red-200 transition-colors" title="YouTube">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>
                            </a>
                        @endif
                        @if($bumnagProfile->tiktok)
                            <a href="https://tiktok.com/{{ $bumnagProfile->tiktok }}" target="_blank" class="p-2 bg-gray-900 text-white rounded-lg hover:bg-gray-800 transition-colors" title="TikTok">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12.525.02c1.31-.02 2.61-.01 3.91-.02.08 1.53.63 3.09 1.75 4.17 1.12 1.11 2.7 1.62 4.24 1.79v4.03c-1.44-.05-2.89-.35-4.2-.97-.57-.26-1.1-.59-1.62-.93-.01 2.92.01 5.84-.02 8.75-.08 1.4-.54 2.79-1.35 3.94-1.31 1.92-3.58 3.17-5.91 3.21-1.43.08-2.86-.31-4.08-1.03-2.02-1.19-3.44-3.37-3.65-5.71-.02-.5-.03-1-.01-1.49.18-1.9 1.12-3.72 2.58-4.96 1.66-1.44 3.98-2.13 6.15-1.72.02 1.48-.04 2.96-.04 4.44-.99-.32-2.15-.23-3.02.37-.63.41-1.11 1.04-1.36 1.75-.21.51-.15 1.07-.14 1.61.24 1.64 1.82 3.02 3.5 2.87 1.12-.01 2.19-.66 2.77-1.61.19-.33.4-.67.41-1.06.1-1.79.06-3.57.07-5.36.01-4.03-.01-8.05.02-12.07z"/></svg>
                            </a>
                        @endif
                    </div>
                </div>
            @endif

            {{-- Metadata --}}
            <div class="bg-gray-50 rounded-xl p-4 text-sm text-gray-500">
                <p>Dibuat: {{ $bumnagProfile->created_at->format('d M Y, H:i') }}</p>
                <p>Diperbarui: {{ $bumnagProfile->updated_at->format('d M Y, H:i') }}</p>
                <p class="mt-2 font-mono text-xs text-gray-400">Slug: {{ $bumnagProfile->slug }}</p>
            </div>
        </div>
    </div>
</div>
@endsection
