@extends('admin.layouts.app')

@section('title', 'Edit BUMNag')
@section('header', 'Edit Profil BUMNag')

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

    {{-- Current Profile Info --}}
    <div class="bg-gradient-to-r from-amber-500 to-orange-500 rounded-xl p-6 mb-6 text-white">
        <div class="flex items-center gap-4">
            @if($bumnagProfile->logo)
                <img src="{{ Storage::url($bumnagProfile->logo) }}" alt="{{ $bumnagProfile->name }}" class="w-16 h-16 rounded-xl object-cover border-2 border-white/30">
            @else
                <div class="w-16 h-16 rounded-xl bg-white/20 flex items-center justify-center">
                    <span class="text-2xl font-bold">{{ strtoupper(substr($bumnagProfile->name, 0, 2)) }}</span>
                </div>
            @endif
            <div>
                <h2 class="text-xl font-bold">{{ $bumnagProfile->name }}</h2>
                <p class="text-white/80">{{ $bumnagProfile->nagari_name }}</p>
                <p class="text-white/60 text-sm mt-1">Slug: {{ $bumnagProfile->slug }}</p>
            </div>
        </div>
    </div>

    <form action="{{ route('admin.bumnag-profiles.update', $bumnagProfile) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')

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
                        <input type="text" name="name" id="name" value="{{ old('name', $bumnagProfile->name) }}" required class="block w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-amber-500 focus:border-amber-500 @error('name') border-red-500 @enderror">
                        @error('name')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="nagari_name" class="block text-sm font-medium text-gray-700 mb-1">Nama Nagari <span class="text-red-500">*</span></label>
                        <input type="text" name="nagari_name" id="nagari_name" value="{{ old('nagari_name', $bumnagProfile->nagari_name) }}" required class="block w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-amber-500 focus:border-amber-500 @error('nagari_name') border-red-500 @enderror">
                        @error('nagari_name')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div>
                    <label for="slug" class="block text-sm font-medium text-gray-700 mb-1">Slug</label>
                    <input type="text" name="slug" id="slug" value="{{ old('slug', $bumnagProfile->slug) }}" class="block w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-amber-500 focus:border-amber-500 bg-gray-50">
                    <p class="mt-1 text-xs text-gray-500">Kosongkan untuk generate otomatis dari nama</p>
                </div>

                <div>
                    <label for="tagline" class="block text-sm font-medium text-gray-700 mb-1">Tagline</label>
                    <input type="text" name="tagline" id="tagline" value="{{ old('tagline', $bumnagProfile->tagline) }}" class="block w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-amber-500 focus:border-amber-500">
                </div>

                <div>
                    <label for="about" class="block text-sm font-medium text-gray-700 mb-1">Tentang BUMNag</label>
                    <textarea name="about" id="about" rows="4" class="block w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-amber-500 focus:border-amber-500">{{ old('about', $bumnagProfile->about) }}</textarea>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="vision" class="block text-sm font-medium text-gray-700 mb-1">Visi</label>
                        <textarea name="vision" id="vision" rows="3" class="block w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-amber-500 focus:border-amber-500">{{ old('vision', $bumnagProfile->vision) }}</textarea>
                    </div>
                    <div>
                        <label for="mission" class="block text-sm font-medium text-gray-700 mb-1">Misi</label>
                        <textarea name="mission" id="mission" rows="3" class="block w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-amber-500 focus:border-amber-500">{{ old('mission', $bumnagProfile->mission) }}</textarea>
                    </div>
                </div>

                <div>
                    <label for="history" class="block text-sm font-medium text-gray-700 mb-1">Sejarah</label>
                    <textarea name="history" id="history" rows="3" class="block w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-amber-500 focus:border-amber-500">{{ old('history', $bumnagProfile->history) }}</textarea>
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
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Logo</label>
                        @if($bumnagProfile->logo)
                            <div class="mb-3 flex items-start gap-3">
                                <img src="{{ Storage::url($bumnagProfile->logo) }}" alt="Logo" class="w-20 h-20 rounded-lg object-cover border">
                                <label class="flex items-center gap-2 text-sm text-red-600 cursor-pointer">
                                    <input type="checkbox" name="remove_logo" value="1" class="rounded border-gray-300 text-red-500 focus:ring-red-500">
                                    Hapus logo
                                </label>
                            </div>
                        @endif
                        <input type="file" name="logo" accept="image/*" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-amber-50 file:text-amber-700 hover:file:bg-amber-100">
                        <p class="mt-1 text-xs text-gray-500">Maksimal 2MB</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Banner</label>
                        @if($bumnagProfile->banner)
                            <div class="mb-3 flex items-start gap-3">
                                <img src="{{ Storage::url($bumnagProfile->banner) }}" alt="Banner" class="w-32 h-20 rounded-lg object-cover border">
                                <label class="flex items-center gap-2 text-sm text-red-600 cursor-pointer">
                                    <input type="checkbox" name="remove_banner" value="1" class="rounded border-gray-300 text-red-500 focus:ring-red-500">
                                    Hapus banner
                                </label>
                            </div>
                        @endif
                        <input type="file" name="banner" accept="image/*" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-amber-50 file:text-amber-700 hover:file:bg-amber-100">
                        <p class="mt-1 text-xs text-gray-500">Maksimal 4MB</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Legalitas --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-green-50 to-emerald-50">
                <h3 class="text-lg font-semibold text-gray-900">Informasi Legalitas</h3>
            </div>
            <div class="p-6 space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="legal_entity_number" class="block text-sm font-medium text-gray-700 mb-1">Nomor Badan Hukum</label>
                        <input type="text" name="legal_entity_number" id="legal_entity_number" value="{{ old('legal_entity_number', $bumnagProfile->legal_entity_number) }}" class="block w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-amber-500 focus:border-amber-500">
                    </div>
                    <div>
                        <label for="established_date" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Pendirian</label>
                        <input type="date" name="established_date" id="established_date" value="{{ old('established_date', $bumnagProfile->established_date?->format('Y-m-d')) }}" class="block w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-amber-500 focus:border-amber-500">
                    </div>
                    <div>
                        <label for="notary_name" class="block text-sm font-medium text-gray-700 mb-1">Nama Notaris</label>
                        <input type="text" name="notary_name" id="notary_name" value="{{ old('notary_name', $bumnagProfile->notary_name) }}" class="block w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-amber-500 focus:border-amber-500">
                    </div>
                    <div>
                        <label for="deed_number" class="block text-sm font-medium text-gray-700 mb-1">Nomor Akta</label>
                        <input type="text" name="deed_number" id="deed_number" value="{{ old('deed_number', $bumnagProfile->deed_number) }}" class="block w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-amber-500 focus:border-amber-500">
                    </div>
                </div>
            </div>
        </div>

        {{-- Kontak --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-purple-50 to-pink-50">
                <h3 class="text-lg font-semibold text-gray-900">Kontak & Alamat</h3>
            </div>
            <div class="p-6 space-y-4">
                <div>
                    <label for="address" class="block text-sm font-medium text-gray-700 mb-1">Alamat Lengkap</label>
                    <textarea name="address" id="address" rows="2" class="block w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-amber-500 focus:border-amber-500">{{ old('address', $bumnagProfile->address) }}</textarea>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label for="postal_code" class="block text-sm font-medium text-gray-700 mb-1">Kode Pos</label>
                        <input type="text" name="postal_code" id="postal_code" value="{{ old('postal_code', $bumnagProfile->postal_code) }}" class="block w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-amber-500 focus:border-amber-500">
                    </div>
                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Telepon</label>
                        <input type="text" name="phone" id="phone" value="{{ old('phone', $bumnagProfile->phone) }}" class="block w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-amber-500 focus:border-amber-500">
                    </div>
                    <div>
                        <label for="fax" class="block text-sm font-medium text-gray-700 mb-1">Fax</label>
                        <input type="text" name="fax" id="fax" value="{{ old('fax', $bumnagProfile->fax) }}" class="block w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-amber-500 focus:border-amber-500">
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                        <input type="email" name="email" id="email" value="{{ old('email', $bumnagProfile->email) }}" class="block w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-amber-500 focus:border-amber-500">
                    </div>
                    <div>
                        <label for="website" class="block text-sm font-medium text-gray-700 mb-1">Website</label>
                        <input type="url" name="website" id="website" value="{{ old('website', $bumnagProfile->website) }}" class="block w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-amber-500 focus:border-amber-500">
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="latitude" class="block text-sm font-medium text-gray-700 mb-1">Latitude</label>
                        <input type="number" step="any" name="latitude" id="latitude" value="{{ old('latitude', $bumnagProfile->latitude) }}" class="block w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-amber-500 focus:border-amber-500">
                    </div>
                    <div>
                        <label for="longitude" class="block text-sm font-medium text-gray-700 mb-1">Longitude</label>
                        <input type="number" step="any" name="longitude" id="longitude" value="{{ old('longitude', $bumnagProfile->longitude) }}" class="block w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-amber-500 focus:border-amber-500">
                    </div>
                </div>
            </div>
        </div>

        {{-- Sosial Media --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-cyan-50 to-blue-50">
                <h3 class="text-lg font-semibold text-gray-900">Media Sosial</h3>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    <div>
                        <label for="whatsapp" class="block text-sm font-medium text-gray-700 mb-1">WhatsApp</label>
                        <input type="text" name="whatsapp" id="whatsapp" value="{{ old('whatsapp', $bumnagProfile->whatsapp) }}" class="block w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-amber-500 focus:border-amber-500">
                    </div>
                    <div>
                        <label for="facebook" class="block text-sm font-medium text-gray-700 mb-1">Facebook</label>
                        <input type="text" name="facebook" id="facebook" value="{{ old('facebook', $bumnagProfile->facebook) }}" class="block w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-amber-500 focus:border-amber-500">
                    </div>
                    <div>
                        <label for="instagram" class="block text-sm font-medium text-gray-700 mb-1">Instagram</label>
                        <input type="text" name="instagram" id="instagram" value="{{ old('instagram', $bumnagProfile->instagram) }}" class="block w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-amber-500 focus:border-amber-500">
                    </div>
                    <div>
                        <label for="twitter" class="block text-sm font-medium text-gray-700 mb-1">Twitter/X</label>
                        <input type="text" name="twitter" id="twitter" value="{{ old('twitter', $bumnagProfile->twitter) }}" class="block w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-amber-500 focus:border-amber-500">
                    </div>
                    <div>
                        <label for="youtube" class="block text-sm font-medium text-gray-700 mb-1">YouTube</label>
                        <input type="text" name="youtube" id="youtube" value="{{ old('youtube', $bumnagProfile->youtube) }}" class="block w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-amber-500 focus:border-amber-500">
                    </div>
                    <div>
                        <label for="tiktok" class="block text-sm font-medium text-gray-700 mb-1">TikTok</label>
                        <input type="text" name="tiktok" id="tiktok" value="{{ old('tiktok', $bumnagProfile->tiktok) }}" class="block w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-amber-500 focus:border-amber-500">
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
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', $bumnagProfile->is_active) ? 'checked' : '' }} class="w-5 h-5 rounded border-gray-300 text-amber-500 focus:ring-amber-500">
                    <span class="text-sm text-gray-700">Aktifkan profil BUMNag ini</span>
                </label>
            </div>
        </div>

        {{-- Submit --}}
        <div class="flex items-center justify-between">
            <button type="button" onclick="document.getElementById('deleteModal').classList.remove('hidden')" class="px-4 py-2 text-red-600 hover:bg-red-50 font-medium text-sm rounded-lg transition-colors">
                Hapus Profil
            </button>
            <div class="flex items-center gap-3">
                <a href="{{ route('admin.bumnag-profiles.index') }}" class="px-6 py-2.5 border border-gray-300 text-gray-700 font-medium text-sm rounded-lg hover:bg-gray-50 transition-colors">
                    Batal
                </a>
                <button type="submit" class="px-6 py-2.5 bg-amber-500 hover:bg-amber-600 text-white font-medium text-sm rounded-lg transition-colors">
                    Simpan Perubahan
                </button>
            </div>
        </div>
    </form>
</div>

{{-- Delete Modal --}}
<div id="deleteModal" class="hidden fixed inset-0 bg-black/50 flex items-center justify-center z-50">
    <div class="bg-white rounded-xl shadow-xl max-w-md w-full mx-4 p-6">
        <div class="text-center">
            <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                </svg>
            </div>
            <h3 class="text-lg font-semibold text-gray-900 mb-2">Hapus Profil BUMNag</h3>
            <p class="text-sm text-gray-500 mb-6">Yakin ingin menghapus <strong>{{ $bumnagProfile->name }}</strong>? Data akan dipindahkan ke sampah.</p>
            <div class="flex gap-3 justify-center">
                <button type="button" onclick="document.getElementById('deleteModal').classList.add('hidden')" class="px-4 py-2 border border-gray-300 text-gray-700 font-medium text-sm rounded-lg hover:bg-gray-50">
                    Batal
                </button>
                <form action="{{ route('admin.bumnag-profiles.destroy', $bumnagProfile) }}" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white font-medium text-sm rounded-lg">
                        Ya, Hapus
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
