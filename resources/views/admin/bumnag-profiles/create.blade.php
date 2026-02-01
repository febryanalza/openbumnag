@extends('admin.layouts.app')

@section('title', 'Tambah BUMNag')
@section('header', 'Tambah Profil BUMNag')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="mb-6">
        <a href="{{ route('admin.bumnag-profiles.index') }}" class="inline-flex items-center gap-2 text-gray-600 hover:text-gray-900 transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Kembali
        </a>
    </div>

    <form action="{{ route('admin.bumnag-profiles.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf

        {{-- Informasi Dasar --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-amber-50 to-orange-50">
                <h3 class="text-lg font-semibold text-gray-900">Informasi Dasar</h3>
                <p class="text-sm text-gray-500">Informasi utama tentang BUMNag</p>
            </div>
            <div class="p-6 space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama BUMNag <span class="text-red-500">*</span></label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}" required class="block w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-amber-500 focus:border-amber-500 @error('name') border-red-500 @enderror" placeholder="Contoh: BUMNag Saiyo Sakato">
                        @error('name')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="nagari_name" class="block text-sm font-medium text-gray-700 mb-1">Nama Nagari <span class="text-red-500">*</span></label>
                        <input type="text" name="nagari_name" id="nagari_name" value="{{ old('nagari_name') }}" required class="block w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-amber-500 focus:border-amber-500 @error('nagari_name') border-red-500 @enderror" placeholder="Contoh: Nagari Koto Tangah">
                        @error('nagari_name')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div>
                    <label for="tagline" class="block text-sm font-medium text-gray-700 mb-1">Tagline</label>
                    <input type="text" name="tagline" id="tagline" value="{{ old('tagline') }}" class="block w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-amber-500 focus:border-amber-500" placeholder="Slogan atau tagline BUMNag">
                </div>

                <div>
                    <label for="about" class="block text-sm font-medium text-gray-700 mb-1">Tentang BUMNag</label>
                    <textarea name="about" id="about" rows="4" class="block w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-amber-500 focus:border-amber-500" placeholder="Deskripsi lengkap tentang BUMNag">{{ old('about') }}</textarea>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="vision" class="block text-sm font-medium text-gray-700 mb-1">Visi</label>
                        <textarea name="vision" id="vision" rows="3" class="block w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-amber-500 focus:border-amber-500" placeholder="Visi BUMNag">{{ old('vision') }}</textarea>
                    </div>
                    <div>
                        <label for="mission" class="block text-sm font-medium text-gray-700 mb-1">Misi</label>
                        <textarea name="mission" id="mission" rows="3" class="block w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-amber-500 focus:border-amber-500" placeholder="Misi BUMNag">{{ old('mission') }}</textarea>
                    </div>
                </div>

                <div>
                    <label for="history" class="block text-sm font-medium text-gray-700 mb-1">Sejarah</label>
                    <textarea name="history" id="history" rows="3" class="block w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-amber-500 focus:border-amber-500" placeholder="Sejarah singkat BUMNag">{{ old('history') }}</textarea>
                </div>
            </div>
        </div>

        {{-- Media --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-blue-50 to-indigo-50">
                <h3 class="text-lg font-semibold text-gray-900">Media</h3>
                <p class="text-sm text-gray-500">Logo dan banner BUMNag</p>
            </div>
            <div class="p-6 space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="logo" class="block text-sm font-medium text-gray-700 mb-1">Logo</label>
                        <input type="file" name="logo" id="logo" accept="image/*" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-amber-50 file:text-amber-700 hover:file:bg-amber-100">
                        <p class="mt-1 text-xs text-gray-500">Maksimal 2MB (JPG, PNG, SVG, WebP)</p>
                    </div>
                    <div>
                        <label for="banner" class="block text-sm font-medium text-gray-700 mb-1">Banner</label>
                        <input type="file" name="banner" id="banner" accept="image/*" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-amber-50 file:text-amber-700 hover:file:bg-amber-100">
                        <p class="mt-1 text-xs text-gray-500">Maksimal 4MB (JPG, PNG, WebP)</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Legalitas --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-green-50 to-emerald-50">
                <h3 class="text-lg font-semibold text-gray-900">Informasi Legalitas</h3>
                <p class="text-sm text-gray-500">Data legalitas dan pendirian BUMNag</p>
            </div>
            <div class="p-6 space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="legal_entity_number" class="block text-sm font-medium text-gray-700 mb-1">Nomor Badan Hukum</label>
                        <input type="text" name="legal_entity_number" id="legal_entity_number" value="{{ old('legal_entity_number') }}" class="block w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-amber-500 focus:border-amber-500">
                    </div>
                    <div>
                        <label for="established_date" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Pendirian</label>
                        <input type="date" name="established_date" id="established_date" value="{{ old('established_date') }}" class="block w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-amber-500 focus:border-amber-500">
                    </div>
                    <div>
                        <label for="notary_name" class="block text-sm font-medium text-gray-700 mb-1">Nama Notaris</label>
                        <input type="text" name="notary_name" id="notary_name" value="{{ old('notary_name') }}" class="block w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-amber-500 focus:border-amber-500">
                    </div>
                    <div>
                        <label for="deed_number" class="block text-sm font-medium text-gray-700 mb-1">Nomor Akta</label>
                        <input type="text" name="deed_number" id="deed_number" value="{{ old('deed_number') }}" class="block w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-amber-500 focus:border-amber-500">
                    </div>
                </div>
            </div>
        </div>

        {{-- Kontak --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-purple-50 to-pink-50">
                <h3 class="text-lg font-semibold text-gray-900">Kontak & Alamat</h3>
                <p class="text-sm text-gray-500">Informasi kontak BUMNag</p>
            </div>
            <div class="p-6 space-y-4">
                <div>
                    <label for="address" class="block text-sm font-medium text-gray-700 mb-1">Alamat Lengkap</label>
                    <textarea name="address" id="address" rows="2" class="block w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-amber-500 focus:border-amber-500">{{ old('address') }}</textarea>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label for="postal_code" class="block text-sm font-medium text-gray-700 mb-1">Kode Pos</label>
                        <input type="text" name="postal_code" id="postal_code" value="{{ old('postal_code') }}" class="block w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-amber-500 focus:border-amber-500">
                    </div>
                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Telepon</label>
                        <input type="text" name="phone" id="phone" value="{{ old('phone') }}" class="block w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-amber-500 focus:border-amber-500" placeholder="08xxxxxxxxxx">
                    </div>
                    <div>
                        <label for="fax" class="block text-sm font-medium text-gray-700 mb-1">Fax</label>
                        <input type="text" name="fax" id="fax" value="{{ old('fax') }}" class="block w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-amber-500 focus:border-amber-500">
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                        <input type="email" name="email" id="email" value="{{ old('email') }}" class="block w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-amber-500 focus:border-amber-500">
                    </div>
                    <div>
                        <label for="website" class="block text-sm font-medium text-gray-700 mb-1">Website</label>
                        <input type="url" name="website" id="website" value="{{ old('website') }}" class="block w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-amber-500 focus:border-amber-500" placeholder="https://">
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="latitude" class="block text-sm font-medium text-gray-700 mb-1">Latitude</label>
                        <input type="number" step="any" name="latitude" id="latitude" value="{{ old('latitude') }}" class="block w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-amber-500 focus:border-amber-500" placeholder="-0.9471951">
                    </div>
                    <div>
                        <label for="longitude" class="block text-sm font-medium text-gray-700 mb-1">Longitude</label>
                        <input type="number" step="any" name="longitude" id="longitude" value="{{ old('longitude') }}" class="block w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-amber-500 focus:border-amber-500" placeholder="100.4171234">
                    </div>
                </div>
            </div>
        </div>

        {{-- Sosial Media --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-cyan-50 to-blue-50">
                <h3 class="text-lg font-semibold text-gray-900">Media Sosial</h3>
                <p class="text-sm text-gray-500">Akun media sosial BUMNag</p>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    <div>
                        <label for="whatsapp" class="block text-sm font-medium text-gray-700 mb-1">WhatsApp</label>
                        <input type="text" name="whatsapp" id="whatsapp" value="{{ old('whatsapp') }}" class="block w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-amber-500 focus:border-amber-500" placeholder="628xxxxxxxxxx">
                    </div>
                    <div>
                        <label for="facebook" class="block text-sm font-medium text-gray-700 mb-1">Facebook</label>
                        <input type="text" name="facebook" id="facebook" value="{{ old('facebook') }}" class="block w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-amber-500 focus:border-amber-500" placeholder="username atau URL">
                    </div>
                    <div>
                        <label for="instagram" class="block text-sm font-medium text-gray-700 mb-1">Instagram</label>
                        <input type="text" name="instagram" id="instagram" value="{{ old('instagram') }}" class="block w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-amber-500 focus:border-amber-500" placeholder="@username">
                    </div>
                    <div>
                        <label for="twitter" class="block text-sm font-medium text-gray-700 mb-1">Twitter/X</label>
                        <input type="text" name="twitter" id="twitter" value="{{ old('twitter') }}" class="block w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-amber-500 focus:border-amber-500" placeholder="@username">
                    </div>
                    <div>
                        <label for="youtube" class="block text-sm font-medium text-gray-700 mb-1">YouTube</label>
                        <input type="text" name="youtube" id="youtube" value="{{ old('youtube') }}" class="block w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-amber-500 focus:border-amber-500" placeholder="channel URL">
                    </div>
                    <div>
                        <label for="tiktok" class="block text-sm font-medium text-gray-700 mb-1">TikTok</label>
                        <input type="text" name="tiktok" id="tiktok" value="{{ old('tiktok') }}" class="block w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-amber-500 focus:border-amber-500" placeholder="@username">
                    </div>
                </div>
            </div>
        </div>

        {{-- Status --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900">Status</h3>
            </div>
            <div class="p-6">
                <label class="flex items-center gap-3 cursor-pointer">
                    <input type="hidden" name="is_active" value="0">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }} class="w-5 h-5 rounded border-gray-300 text-amber-500 focus:ring-amber-500">
                    <span class="text-sm text-gray-700">Aktifkan profil BUMNag ini</span>
                </label>
            </div>
        </div>

        {{-- Submit --}}
        <div class="flex items-center justify-end gap-3">
            <a href="{{ route('admin.bumnag-profiles.index') }}" class="px-6 py-2.5 border border-gray-300 text-gray-700 font-medium text-sm rounded-lg hover:bg-gray-50 transition-colors">
                Batal
            </a>
            <button type="submit" class="px-6 py-2.5 bg-amber-500 hover:bg-amber-600 text-white font-medium text-sm rounded-lg transition-colors">
                Simpan BUMNag
            </button>
        </div>
    </form>
</div>
@endsection
