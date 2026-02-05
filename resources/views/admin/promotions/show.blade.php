@extends('admin.layouts.app')

@section('title', 'Detail Promosi')
@section('page-title', 'Detail Promosi')

@section('content')
<div class="max-w-5xl mx-auto">
    <!-- Breadcrumb -->
    <nav class="mb-6">
        <ol class="flex items-center space-x-2 text-sm text-gray-500">
            <li><a href="{{ route('admin.dashboard') }}" class="hover:text-amber-600">Dashboard</a></li>
            <li><span class="mx-2">/</span></li>
            <li><a href="{{ route('admin.promotions.index') }}" class="hover:text-amber-600">Promosi</a></li>
            <li><span class="mx-2">/</span></li>
            <li class="text-gray-900 font-medium">Detail</li>
        </ol>
    </nav>

    <!-- Promotion Header -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden mb-6">
        @if($promotion->featured_image)
            <div class="relative h-64 md:h-80">
                <img src="{{ Storage::url($promotion->featured_image) }}" alt="{{ $promotion->title }}" class="w-full h-full object-cover">
                <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent"></div>
                
                <!-- Badges -->
                <div class="absolute top-4 right-4 flex flex-col gap-2">
                    @if($promotion->is_featured)
                        <span class="px-3 py-1 bg-yellow-500 text-white text-sm rounded-full font-medium shadow">
                            ⭐ Unggulan
                        </span>
                    @endif
                    @if($promotion->discount_percentage)
                        <span class="px-3 py-1 bg-red-500 text-white text-sm rounded-full font-medium shadow">
                            Diskon {{ $promotion->discount_percentage }}%
                        </span>
                    @endif
                </div>

                <div class="absolute bottom-0 left-0 right-0 p-6 text-white">
                    <div class="flex items-center gap-2 mb-2">
                        @php
                            $statusColors = [
                                'draft' => 'bg-gray-500',
                                'active' => 'bg-green-500',
                                'expired' => 'bg-orange-500',
                                'archived' => 'bg-red-500',
                            ];
                        @endphp
                        <span class="px-2 py-1 rounded-full text-xs font-medium {{ $statusColors[$promotion->status] ?? 'bg-gray-500' }}">
                            {{ $statuses[$promotion->status] ?? $promotion->status }}
                        </span>
                        <span class="px-2 py-1 rounded-full text-xs font-medium bg-purple-500">
                            {{ $promotionTypes[$promotion->promotion_type] ?? $promotion->promotion_type }}
                        </span>
                        @if($promotion->category)
                            <span class="px-2 py-1 rounded-full text-xs font-medium bg-blue-500">
                                {{ $promotion->category->name }}
                            </span>
                        @endif
                    </div>
                    <h1 class="text-2xl md:text-3xl font-bold">{{ $promotion->title }}</h1>
                </div>
            </div>
        @else
            <div class="p-6 bg-gradient-to-r from-purple-600 to-indigo-700 text-white">
                <div class="flex items-center gap-2 mb-2">
                    @php
                        $statusColors = [
                            'draft' => 'bg-gray-500',
                            'active' => 'bg-green-500',
                            'expired' => 'bg-orange-500',
                            'archived' => 'bg-red-500',
                        ];
                    @endphp
                    <span class="px-2 py-1 rounded-full text-xs font-medium {{ $statusColors[$promotion->status] ?? 'bg-gray-500' }}">
                        {{ $statuses[$promotion->status] ?? $promotion->status }}
                    </span>
                    <span class="px-2 py-1 rounded-full text-xs font-medium bg-white/30">
                        {{ $promotionTypes[$promotion->promotion_type] ?? $promotion->promotion_type }}
                    </span>
                    @if($promotion->is_featured)
                        <span class="px-2 py-1 rounded-full text-xs font-medium bg-yellow-500">Unggulan</span>
                    @endif
                </div>
                <h1 class="text-2xl md:text-3xl font-bold">{{ $promotion->title }}</h1>
            </div>
        @endif

        <!-- Price Display -->
        @if($promotion->discount_price || $promotion->original_price)
            <div class="p-6 border-b border-gray-200 bg-gradient-to-r from-green-50 to-emerald-50">
                <div class="flex items-center gap-4">
                    @if($promotion->discount_price)
                        <span class="text-3xl font-bold text-green-600">Rp {{ number_format($promotion->discount_price, 0, ',', '.') }}</span>
                        @if($promotion->original_price)
                            <span class="text-xl text-gray-400 line-through">Rp {{ number_format($promotion->original_price, 0, ',', '.') }}</span>
                            @if($promotion->discount_percentage)
                                <span class="px-3 py-1 bg-red-500 text-white text-sm rounded-full font-bold">
                                    HEMAT {{ $promotion->discount_percentage }}%
                                </span>
                            @endif
                        @endif
                    @elseif($promotion->original_price)
                        <span class="text-3xl font-bold text-gray-900">Rp {{ number_format($promotion->original_price, 0, ',', '.') }}</span>
                    @endif
                </div>
            </div>
        @endif

        <!-- Meta Info -->
        <div class="p-6 border-b border-gray-200">
            <div class="flex flex-wrap items-center gap-6 text-sm text-gray-600">
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                    <span>{{ $promotion->user->name ?? 'Unknown' }}</span>
                </div>
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                    </svg>
                    <span>{{ number_format($promotion->views) }} views</span>
                </div>
                @if($promotion->start_date || $promotion->end_date)
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        <span>
                            @if($promotion->start_date && $promotion->end_date)
                                {{ $promotion->start_date->format('d M Y') }} - {{ $promotion->end_date->format('d M Y') }}
                            @elseif($promotion->start_date)
                                Mulai {{ $promotion->start_date->format('d M Y') }}
                            @elseif($promotion->end_date)
                                Sampai {{ $promotion->end_date->format('d M Y') }}
                            @endif
                        </span>
                    </div>
                @endif
            </div>
        </div>

        <!-- Actions -->
        <div class="p-4 bg-gray-50 flex items-center justify-between">
            <a href="{{ route('admin.promotions.index') }}" class="inline-flex items-center gap-2 text-gray-600 hover:text-gray-800">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Kembali
            </a>
            <div class="flex items-center gap-2">
                <a href="{{ route('admin.promotions.edit', $promotion) }}" class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                    Edit
                </a>
                <form method="POST" action="{{ route('admin.promotions.destroy', $promotion) }}" class="inline" onsubmit="return confirm('Hapus promosi ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="inline-flex items-center gap-2 px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                        Hapus
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Excerpt -->
            @if($promotion->excerpt)
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-3">Ringkasan</h2>
                    <p class="text-gray-600 italic leading-relaxed">{{ $promotion->excerpt }}</p>
                </div>
            @endif

            <!-- Description -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Deskripsi</h2>
                <div class="prose max-w-none text-gray-700">
                    {!! nl2br(e($promotion->description)) !!}
                </div>
            </div>

            <!-- Terms & Conditions -->
            @if($promotion->terms_conditions)
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Syarat & Ketentuan</h2>
                    <div class="prose max-w-none text-gray-700 text-sm">
                        {!! nl2br(e($promotion->terms_conditions)) !!}
                    </div>
                </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Contact Info -->
            @if($promotion->contact_person || $promotion->contact_phone || $promotion->contact_email || $promotion->location)
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Informasi Kontak</h2>
                    <div class="space-y-4">
                        @if($promotion->contact_person)
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-gray-100 rounded-lg flex items-center justify-center">
                                    <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500">Kontak Person</p>
                                    <p class="text-sm font-medium text-gray-900">{{ $promotion->contact_person }}</p>
                                </div>
                            </div>
                        @endif
                        @if($promotion->contact_phone)
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500">Telepon</p>
                                    <a href="tel:{{ $promotion->contact_phone }}" class="text-sm font-medium text-amber-600 hover:text-amber-700">
                                        {{ $promotion->contact_phone }}
                                    </a>
                                </div>
                            </div>
                        @endif
                        @if($promotion->contact_email)
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500">Email</p>
                                    <a href="mailto:{{ $promotion->contact_email }}" class="text-sm font-medium text-amber-600 hover:text-amber-700 break-all">
                                        {{ $promotion->contact_email }}
                                    </a>
                                </div>
                            </div>
                        @endif
                        @if($promotion->location)
                            <div class="flex items-start gap-3">
                                <div class="w-10 h-10 bg-red-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                    <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500">Lokasi</p>
                                    <p class="text-sm text-gray-900">{{ $promotion->location }}</p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            @endif

            <!-- Timestamps -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Informasi</h2>
                <div class="space-y-3 text-sm">
                    <div class="flex justify-between">
                        <span class="text-gray-500">ID</span>
                        <span class="text-gray-900 font-medium">#{{ $promotion->id }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-500">Dibuat</span>
                        <span class="text-gray-900">{{ $promotion->created_at->format('d M Y, H:i') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-500">Diperbarui</span>
                        <span class="text-gray-900">{{ $promotion->updated_at->format('d M Y, H:i') }}</span>
                    </div>
                    @if($promotion->start_date)
                        <div class="flex justify-between">
                            <span class="text-gray-500">Mulai</span>
                            <span class="text-gray-900">{{ $promotion->start_date->format('d M Y, H:i') }}</span>
                        </div>
                    @endif
                    @if($promotion->end_date)
                        <div class="flex justify-between">
                            <span class="text-gray-500">Berakhir</span>
                            <span class="text-gray-900">{{ $promotion->end_date->format('d M Y, H:i') }}</span>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Aksi Cepat</h2>
                <div class="space-y-2">
                    @if($promotion->status !== 'active')
                        <form method="POST" action="{{ route('admin.promotions.bulk-action') }}">
                            @csrf
                            <input type="hidden" name="action" value="activate">
                            <input type="hidden" name="ids[]" value="{{ $promotion->id }}">
                            <button type="submit" class="w-full px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors text-sm">
                                Aktifkan Promosi
                            </button>
                        </form>
                    @endif
                    @if(!$promotion->is_featured)
                        <form method="POST" action="{{ route('admin.promotions.bulk-action') }}">
                            @csrf
                            <input type="hidden" name="action" value="feature">
                            <input type="hidden" name="ids[]" value="{{ $promotion->id }}">
                            <button type="submit" class="w-full px-4 py-2 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600 transition-colors text-sm">
                                Jadikan Unggulan
                            </button>
                        </form>
                    @else
                        <form method="POST" action="{{ route('admin.promotions.bulk-action') }}">
                            @csrf
                            <input type="hidden" name="action" value="unfeature">
                            <input type="hidden" name="ids[]" value="{{ $promotion->id }}">
                            <button type="submit" class="w-full px-4 py-2 border border-yellow-500 text-yellow-600 rounded-lg hover:bg-yellow-50 transition-colors text-sm">
                                Hapus dari Unggulan
                            </button>
                        </form>
                    @endif
                    @if($promotion->status === 'active')
                        <form method="POST" action="{{ route('admin.promotions.bulk-action') }}">
                            @csrf
                            <input type="hidden" name="action" value="expire">
                            <input type="hidden" name="ids[]" value="{{ $promotion->id }}">
                            <button type="submit" class="w-full px-4 py-2 border border-orange-500 text-orange-600 rounded-lg hover:bg-orange-50 transition-colors text-sm">
                                Tandai Kadaluarsa
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

