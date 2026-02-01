@extends('admin.layouts.app')

@section('title', 'Detail Anggota Tim')
@section('page-title', 'Detail Anggota Tim')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="mb-6 flex items-center justify-between">
        <a href="{{ route('admin.team-members.index') }}" class="inline-flex items-center text-gray-600 hover:text-gray-900">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Kembali ke Daftar
        </a>
        <div class="flex items-center gap-2">
            <a href="{{ route('admin.team-members.edit', $teamMember) }}" class="inline-flex items-center px-4 py-2 bg-amber-600 text-white rounded-lg hover:bg-amber-700 transition-colors">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                </svg>
                Edit
            </a>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <!-- Header with Photo -->
        <div class="relative bg-gradient-to-br from-amber-500 to-orange-600 p-8">
            <div class="flex flex-col md:flex-row items-center gap-6">
                <div class="w-40 h-40 rounded-full bg-white/20 flex items-center justify-center overflow-hidden ring-4 ring-white/50">
                    @if($teamMember->photo)
                        <img src="{{ Storage::url($teamMember->photo) }}" alt="{{ $teamMember->name }}" class="w-full h-full object-cover">
                    @else
                        <span class="text-6xl font-bold text-white/80">{{ strtoupper(substr($teamMember->name, 0, 1)) }}</span>
                    @endif
                </div>
                <div class="text-center md:text-left text-white">
                    <h1 class="text-3xl font-bold mb-1">{{ $teamMember->name }}</h1>
                    <p class="text-xl text-white/90 mb-2">{{ $teamMember->position }}</p>
                    @if($teamMember->division)
                        <p class="text-white/80">{{ $divisions[$teamMember->division] ?? $teamMember->division }}</p>
                    @endif
                    <div class="mt-4">
                        @if($teamMember->is_active)
                            <span class="px-3 py-1 text-sm font-medium bg-green-500 text-white rounded-full">Aktif</span>
                        @else
                            <span class="px-3 py-1 text-sm font-medium bg-yellow-500 text-white rounded-full">Nonaktif</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="p-6 space-y-6">
            <!-- Bio -->
            @if($teamMember->bio)
                <div>
                    <h3 class="text-sm font-medium text-gray-500 mb-2">Bio / Deskripsi</h3>
                    <p class="text-gray-900 whitespace-pre-line">{{ $teamMember->bio }}</p>
                </div>
            @endif

            <!-- Contact Information -->
            <div class="border-t border-gray-200 pt-6">
                <h3 class="text-sm font-medium text-gray-500 mb-4">Informasi Kontak</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @if($teamMember->email)
                        <div class="flex items-center gap-3">
                            <div class="p-2 bg-gray-100 rounded-lg">
                                <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500">Email</p>
                                <a href="mailto:{{ $teamMember->email }}" class="text-amber-600 hover:text-amber-700">{{ $teamMember->email }}</a>
                            </div>
                        </div>
                    @endif
                    @if($teamMember->phone)
                        <div class="flex items-center gap-3">
                            <div class="p-2 bg-gray-100 rounded-lg">
                                <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500">Telepon</p>
                                <a href="tel:{{ $teamMember->phone }}" class="text-amber-600 hover:text-amber-700">{{ $teamMember->phone }}</a>
                            </div>
                        </div>
                    @endif
                    @if(!$teamMember->email && !$teamMember->phone)
                        <p class="text-gray-500 text-sm">Tidak ada informasi kontak</p>
                    @endif
                </div>
            </div>

            <!-- Social Media -->
            @if($teamMember->facebook || $teamMember->instagram || $teamMember->twitter || $teamMember->linkedin)
                <div class="border-t border-gray-200 pt-6">
                    <h3 class="text-sm font-medium text-gray-500 mb-4">Media Sosial</h3>
                    <div class="flex flex-wrap gap-4">
                        @if($teamMember->facebook)
                            <a href="{{ $teamMember->facebook }}" target="_blank" class="flex items-center gap-2 px-4 py-2 bg-blue-50 text-blue-600 rounded-lg hover:bg-blue-100 transition-colors">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                                </svg>
                                Facebook
                            </a>
                        @endif
                        @if($teamMember->instagram)
                            <a href="{{ $teamMember->instagram }}" target="_blank" class="flex items-center gap-2 px-4 py-2 bg-pink-50 text-pink-600 rounded-lg hover:bg-pink-100 transition-colors">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                                </svg>
                                Instagram
                            </a>
                        @endif
                        @if($teamMember->twitter)
                            <a href="{{ $teamMember->twitter }}" target="_blank" class="flex items-center gap-2 px-4 py-2 bg-gray-100 text-gray-800 rounded-lg hover:bg-gray-200 transition-colors">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/>
                                </svg>
                                Twitter / X
                            </a>
                        @endif
                        @if($teamMember->linkedin)
                            <a href="{{ $teamMember->linkedin }}" target="_blank" class="flex items-center gap-2 px-4 py-2 bg-blue-100 text-blue-700 rounded-lg hover:bg-blue-200 transition-colors">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                                </svg>
                                LinkedIn
                            </a>
                        @endif
                    </div>
                </div>
            @endif

            <!-- Metadata -->
            <div class="border-t border-gray-200 pt-6">
                <h3 class="text-sm font-medium text-gray-500 mb-4">Informasi Lainnya</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <p class="text-xs text-gray-500">Urutan</p>
                        <p class="text-gray-900 font-medium">{{ $teamMember->order }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500">Dibuat pada</p>
                        <p class="text-gray-900">{{ $teamMember->created_at->format('d M Y, H:i') }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500">Terakhir diperbarui</p>
                        <p class="text-gray-900">{{ $teamMember->updated_at->format('d M Y, H:i') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
