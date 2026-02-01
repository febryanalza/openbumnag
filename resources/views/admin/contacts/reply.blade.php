@extends('admin.layouts.app')

@section('title', 'Balas Pesan')
@section('page-title', 'Balas Pesan')

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Original Message Card -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden mb-6">
        <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <div class="flex-shrink-0 w-12 h-12 bg-amber-100 rounded-full flex items-center justify-center">
                        <span class="text-amber-600 font-bold">{{ strtoupper(substr($contact->name, 0, 2)) }}</span>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-lg font-medium text-gray-900">{{ $contact->name }}</h3>
                        <p class="text-sm text-gray-500">{{ $contact->email }}</p>
                    </div>
                </div>
                <span class="text-sm text-gray-500">{{ $contact->created_at->format('d M Y, H:i') }}</span>
            </div>
        </div>
        <div class="p-6">
            <h4 class="text-lg font-medium text-gray-900 mb-4">{{ $contact->subject }}</h4>
            <div class="prose max-w-none text-gray-700 bg-gray-50 rounded-lg p-4">
                {!! nl2br(e($contact->message)) !!}
            </div>
        </div>
    </div>

    <!-- Reply Form -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 bg-amber-50">
            <div class="flex items-center">
                <svg class="w-6 h-6 text-amber-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"/>
                </svg>
                <h3 class="text-lg font-medium text-amber-800">Tulis Balasan</h3>
            </div>
        </div>
        <form method="POST" action="{{ route('admin.contacts.reply', $contact) }}" class="p-6">
            @csrf
            <div class="space-y-6">
                <!-- Reply Message -->
                <div>
                    <label for="reply" class="block text-sm font-medium text-gray-700 mb-2">
                        Pesan Balasan <span class="text-red-500">*</span>
                    </label>
                    <textarea name="reply" id="reply" rows="10" required
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500 @error('reply') border-red-500 @enderror"
                        placeholder="Tulis balasan Anda di sini...">{{ old('reply', $contact->reply) }}</textarea>
                    @error('reply')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                    <p class="mt-2 text-xs text-gray-500">Minimum 10 karakter</p>
                </div>

                <!-- Send Email Option -->
                <div class="flex items-start p-4 bg-blue-50 rounded-lg">
                    <div class="flex items-center h-5">
                        <input type="checkbox" name="send_email" id="send_email" value="1" 
                            class="w-4 h-4 text-amber-600 border-gray-300 rounded focus:ring-amber-500">
                    </div>
                    <div class="ml-3">
                        <label for="send_email" class="text-sm font-medium text-gray-900">Kirim balasan via Email</label>
                        <p class="text-xs text-gray-500">Balasan akan dikirim ke {{ $contact->email }}</p>
                    </div>
                </div>

                <!-- Quick Templates -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Template Cepat</label>
                    <div class="flex flex-wrap gap-2">
                        <button type="button" onclick="insertTemplate('terima_kasih')" class="px-3 py-1.5 text-sm bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors">
                            Terima Kasih
                        </button>
                        <button type="button" onclick="insertTemplate('info_lanjut')" class="px-3 py-1.5 text-sm bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors">
                            Info Lebih Lanjut
                        </button>
                        <button type="button" onclick="insertTemplate('akan_diproses')" class="px-3 py-1.5 text-sm bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors">
                            Akan Diproses
                        </button>
                    </div>
                </div>

                <!-- Actions -->
                <div class="flex items-center justify-between pt-4 border-t border-gray-200">
                    <a href="{{ route('admin.contacts.show', $contact) }}" class="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors">
                        Batal
                    </a>
                    <button type="submit" class="px-6 py-2 bg-amber-600 text-white rounded-lg hover:bg-amber-700 transition-colors flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                        </svg>
                        Kirim Balasan
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    const templates = {
        terima_kasih: `Terima kasih telah menghubungi kami.

Pesan Anda telah kami terima dan akan kami tindaklanjuti. Jika ada pertanyaan lebih lanjut, jangan ragu untuk menghubungi kami kembali.

Salam hangat,
Tim BUMNag`,
        info_lanjut: `Terima kasih telah menghubungi kami.

Untuk memberikan informasi lebih lanjut mengenai pertanyaan Anda, mohon dapat memberikan detail tambahan berikut:
- [Detail yang diperlukan]
- [Informasi tambahan]

Kami akan segera membantu setelah menerima informasi tersebut.

Salam,
Tim BUMNag`,
        akan_diproses: `Terima kasih atas pesan Anda.

Permintaan Anda sedang dalam proses penanganan oleh tim kami. Kami akan menghubungi Anda kembali dalam waktu 1-3 hari kerja.

Terima kasih atas kesabaran Anda.

Salam,
Tim BUMNag`
    };

    function insertTemplate(templateName) {
        const textarea = document.getElementById('reply');
        if (templates[templateName]) {
            textarea.value = templates[templateName];
            textarea.focus();
        }
    }
</script>
@endpush
@endsection
