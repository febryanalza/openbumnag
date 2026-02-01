@extends('admin.layouts.app')

@section('title', 'Detail Pesan Kontak')
@section('page-title', 'Detail Pesan Kontak')

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Header -->
    <div class="bg-gradient-to-r from-amber-500 to-orange-600 rounded-xl shadow-lg p-6 mb-6 text-white">
        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <div class="flex-shrink-0 w-16 h-16 bg-white/20 rounded-full flex items-center justify-center">
                    <span class="text-2xl font-bold">{{ strtoupper(substr($contact->name, 0, 2)) }}</span>
                </div>
                <div class="ml-6">
                    <h1 class="text-xl font-bold">{{ $contact->name }}</h1>
                    <p class="text-amber-100">{{ $contact->email }}</p>
                    @if($contact->phone)
                        <p class="text-amber-100 text-sm">{{ $contact->phone }}</p>
                    @endif
                </div>
            </div>
            <div class="flex items-center gap-3">
                @php
                    $statusColors = [
                        'new' => 'bg-yellow-500',
                        'read' => 'bg-blue-500',
                        'replied' => 'bg-green-500',
                        'archived' => 'bg-gray-500',
                    ];
                @endphp
                <span class="px-3 py-1 {{ $statusColors[$contact->status] ?? 'bg-gray-500' }} rounded-full text-sm">
                    {{ $statuses[$contact->status] ?? $contact->status }}
                </span>
                <a href="{{ route('admin.contacts.index') }}" class="px-4 py-2 bg-white/20 hover:bg-white/30 rounded-lg transition-colors flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Kembali
                </a>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Message -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                    <h3 class="text-lg font-medium text-gray-900">{{ $contact->subject }}</h3>
                    <p class="text-sm text-gray-500">{{ $contact->created_at->format('d M Y, H:i') }} ({{ $contact->created_at->diffForHumans() }})</p>
                </div>
                <div class="p-6">
                    <div class="prose max-w-none text-gray-700">
                        {!! nl2br(e($contact->message)) !!}
                    </div>
                </div>
            </div>

            <!-- Reply Section -->
            @if($contact->reply)
                <div class="bg-green-50 rounded-xl shadow-sm border border-green-200 overflow-hidden">
                    <div class="px-6 py-4 border-b border-green-200 bg-green-100">
                        <div class="flex items-center justify-between">
                            <h3 class="text-lg font-medium text-green-800">Balasan</h3>
                            <span class="text-sm text-green-600">
                                {{ $contact->replied_at?->format('d M Y, H:i') }}
                                @if($contact->repliedBy)
                                    oleh {{ $contact->repliedBy->name }}
                                @endif
                            </span>
                        </div>
                    </div>
                    <div class="p-6">
                        <div class="prose max-w-none text-green-800">
                            {!! nl2br(e($contact->reply)) !!}
                        </div>
                    </div>
                </div>
            @endif

            <!-- Reply Form -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                    <h3 class="text-lg font-medium text-gray-900">
                        {{ $contact->reply ? 'Perbarui Balasan' : 'Balas Pesan' }}
                    </h3>
                </div>
                <form method="POST" action="{{ route('admin.contacts.reply', $contact) }}" class="p-6">
                    @csrf
                    <div class="space-y-4">
                        <div>
                            <label for="reply" class="block text-sm font-medium text-gray-700 mb-2">
                                Pesan Balasan <span class="text-red-500">*</span>
                            </label>
                            <textarea name="reply" id="reply" rows="6" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500 @error('reply') border-red-500 @enderror"
                                placeholder="Tulis balasan Anda...">{{ old('reply', $contact->reply) }}</textarea>
                            @error('reply')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="flex items-center">
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" name="send_email" value="1" class="sr-only peer">
                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-amber-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-amber-600"></div>
                                <span class="ml-3 text-sm font-medium text-gray-700">Kirim via Email</span>
                            </label>
                        </div>
                        <div class="flex justify-end">
                            <button type="submit" class="px-6 py-2 bg-amber-600 text-white rounded-lg hover:bg-amber-700 transition-colors flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"/>
                                </svg>
                                {{ $contact->reply ? 'Perbarui Balasan' : 'Kirim Balasan' }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Contact Info -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Informasi Kontak</h3>
                <dl class="space-y-4">
                    <div>
                        <dt class="text-sm text-gray-500">Email</dt>
                        <dd class="mt-1">
                            <a href="mailto:{{ $contact->email }}" class="text-amber-600 hover:underline">{{ $contact->email }}</a>
                        </dd>
                    </div>
                    @if($contact->phone)
                        <div>
                            <dt class="text-sm text-gray-500">Telepon</dt>
                            <dd class="mt-1">
                                <a href="tel:{{ $contact->phone }}" class="text-amber-600 hover:underline">{{ $contact->phone }}</a>
                            </dd>
                        </div>
                    @endif
                    @if($contact->ip_address)
                        <div>
                            <dt class="text-sm text-gray-500">IP Address</dt>
                            <dd class="mt-1 text-sm text-gray-700 font-mono">{{ $contact->ip_address }}</dd>
                        </div>
                    @endif
                </dl>
            </div>

            <!-- Status Management -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Ubah Status</h3>
                <form method="POST" action="{{ route('admin.contacts.update-status', $contact) }}">
                    @csrf
                    @method('PATCH')
                    <select name="status" onchange="this.form.submit()" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500">
                        @foreach($statuses as $key => $label)
                            <option value="{{ $key }}" {{ $contact->status == $key ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                </form>
            </div>

            <!-- Timestamps -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Waktu</h3>
                <dl class="space-y-4">
                    <div>
                        <dt class="text-sm text-gray-500">Diterima</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $contact->created_at->format('d M Y, H:i') }}</dd>
                    </div>
                    @if($contact->replied_at)
                        <div>
                            <dt class="text-sm text-gray-500">Dibalas</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $contact->replied_at->format('d M Y, H:i') }}</dd>
                        </div>
                    @endif
                    @if($contact->deleted_at)
                        <div>
                            <dt class="text-sm text-gray-500">Dihapus</dt>
                            <dd class="mt-1 text-sm text-red-600">{{ $contact->deleted_at->format('d M Y, H:i') }}</dd>
                        </div>
                    @endif
                </dl>
            </div>

            <!-- Quick Actions -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Aksi Cepat</h3>
                <div class="space-y-3">
                    <a href="mailto:{{ $contact->email }}?subject=Re: {{ $contact->subject }}" class="w-full px-4 py-2 bg-blue-100 text-blue-700 rounded-lg hover:bg-blue-200 transition-colors flex items-center justify-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                        Buka Email Client
                    </a>
                    @if($contact->status != 'archived')
                        <form method="POST" action="{{ route('admin.contacts.update-status', $contact) }}">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="status" value="archived">
                            <button type="submit" class="w-full px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors flex items-center justify-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/>
                                </svg>
                                Arsipkan
                            </button>
                        </form>
                    @endif
                    <form method="POST" action="{{ route('admin.contacts.destroy', $contact) }}" onsubmit="return confirm('Hapus pesan ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-full px-4 py-2 bg-red-100 text-red-700 rounded-lg hover:bg-red-200 transition-colors flex items-center justify-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                            Hapus Pesan
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
