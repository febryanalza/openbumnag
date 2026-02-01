@extends('admin.layouts.app')

@section('title', 'Edit Berita')
@section('page-title', 'Edit Berita')

@section('content')
<div class="max-w-5xl mx-auto">
    <!-- Breadcrumb -->
    <nav class="mb-6">
        <ol class="flex items-center space-x-2 text-sm text-gray-500">
            <li><a href="{{ route('admin.dashboard') }}" class="hover:text-primary-600">Dashboard</a></li>
            <li><span class="mx-2">/</span></li>
            <li><a href="{{ route('admin.news.index') }}" class="hover:text-primary-600">Berita</a></li>
            <li><span class="mx-2">/</span></li>
            <li class="text-gray-900 font-medium">Edit</li>
        </ol>
    </nav>

    <!-- Current News Header -->
    <div class="bg-gradient-to-r from-blue-600 to-indigo-700 rounded-xl shadow-sm p-6 mb-6 text-white">
        <div class="flex items-start gap-4">
            @if($news->featured_image)
                <img src="{{ Storage::url($news->featured_image) }}" alt="{{ $news->title }}" class="w-24 h-16 object-cover rounded-lg">
            @else
                <div class="w-24 h-16 bg-white/20 rounded-lg flex items-center justify-center">
                    <svg class="w-8 h-8 text-white/70" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                    </svg>
                </div>
            @endif
            <div class="flex-1">
                <h2 class="text-xl font-bold">{{ $news->title }}</h2>
                <div class="flex items-center gap-4 mt-2 text-white/80 text-sm">
                    <span class="flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                        {{ number_format($news->views) }} views
                    </span>
                    <span class="flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        {{ $news->user->name ?? 'Unknown' }}
                    </span>
                    @if($news->published_at)
                        <span class="flex items-center gap-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            {{ $news->published_at->format('d M Y H:i') }}
                        </span>
                    @endif
                </div>
            </div>
            @php
                $statusColors = [
                    'draft' => 'bg-gray-500',
                    'published' => 'bg-green-500',
                    'archived' => 'bg-red-500',
                ];
            @endphp
            <span class="px-3 py-1 rounded-full text-sm font-medium {{ $statusColors[$news->status] ?? 'bg-gray-500' }}">
                {{ $statuses[$news->status] ?? $news->status }}
            </span>
        </div>
    </div>

    <form method="POST" action="{{ route('admin.news.update', $news) }}" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')

        <!-- Main Content Section -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">Konten Berita</h2>
            
            <div class="space-y-4">
                <!-- Title -->
                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Judul <span class="text-red-500">*</span></label>
                    <input type="text" name="title" id="title" value="{{ old('title', $news->title) }}" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('title') border-red-500 @enderror">
                    @error('title')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Slug -->
                <div>
                    <label for="slug" class="block text-sm font-medium text-gray-700 mb-1">Slug</label>
                    <input type="text" name="slug" id="slug" value="{{ old('slug', $news->slug) }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('slug') border-red-500 @enderror">
                    @error('slug')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Category -->
                <div>
                    <label for="category_id" class="block text-sm font-medium text-gray-700 mb-1">Kategori</label>
                    <select name="category_id" id="category_id"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                        <option value="">Pilih Kategori</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id', $news->category_id) == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Excerpt -->
                <div>
                    <label for="excerpt" class="block text-sm font-medium text-gray-700 mb-1">Ringkasan</label>
                    <textarea name="excerpt" id="excerpt" rows="2"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">{{ old('excerpt', $news->excerpt) }}</textarea>
                </div>

                <!-- Content -->
                <div>
                    <label for="content" class="block text-sm font-medium text-gray-700 mb-1">Konten <span class="text-red-500">*</span></label>
                    <textarea name="content" id="content" rows="12" required
                        class="tinymce-editor w-full @error('content') border-red-500 @enderror">{{ old('content', $news->content) }}</textarea>
                    <p class="mt-2 text-sm text-gray-500">
                        <span class="font-medium">Tips:</span> Gunakan toolbar untuk format teks, sisipkan gambar, tabel, dan media lainnya.
                    </p>
                    @error('content')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Media Section -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">Media</h2>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Gambar Utama</label>
                
                @if($news->featured_image)
                    <div class="mb-4 p-4 bg-gray-50 rounded-lg">
                        <div class="flex items-start gap-4">
                            <img src="{{ Storage::url($news->featured_image) }}" alt="Current Image" class="w-32 h-24 object-cover rounded-lg">
                            <div class="flex-1">
                                <p class="text-sm text-gray-600">Gambar saat ini</p>
                                <label class="flex items-center gap-2 mt-2 text-sm text-red-600 cursor-pointer">
                                    <input type="checkbox" name="remove_featured_image" value="1" class="rounded border-gray-300 text-red-600 focus:ring-red-500">
                                    Hapus gambar ini
                                </label>
                            </div>
                        </div>
                    </div>
                @endif
                
                <div class="flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg hover:border-primary-500 transition-colors">
                    <div class="space-y-1 text-center">
                        <div id="imagePreview" class="hidden mb-4">
                            <img id="previewImg" src="" alt="Preview" class="mx-auto h-32 object-cover rounded-lg">
                        </div>
                        <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                            <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        <div class="flex text-sm text-gray-600 justify-center">
                            <label for="featured_image" class="relative cursor-pointer bg-white rounded-md font-medium text-primary-600 hover:text-primary-500">
                                <span>{{ $news->featured_image ? 'Ganti gambar' : 'Upload gambar' }}</span>
                                <input id="featured_image" name="featured_image" type="file" class="sr-only" accept="image/*" onchange="previewImage(this)">
                            </label>
                        </div>
                        <p class="text-xs text-gray-500">PNG, JPG, GIF, WebP maks. 2MB</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Publishing Section -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">Pengaturan Publikasi</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Status -->
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status <span class="text-red-500">*</span></label>
                    <select name="status" id="status" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                        @foreach($statuses as $key => $label)
                            <option value="{{ $key }}" {{ old('status', $news->status) === $key ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Published At -->
                <div>
                    <label for="published_at" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Publikasi</label>
                    <input type="datetime-local" name="published_at" id="published_at" 
                        value="{{ old('published_at', $news->published_at ? $news->published_at->format('Y-m-d\TH:i') : '') }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                </div>

                <!-- Featured -->
                <div class="md:col-span-2">
                    <label class="flex items-center gap-3">
                        <input type="checkbox" name="is_featured" value="1" {{ old('is_featured', $news->is_featured) ? 'checked' : '' }}
                            class="w-5 h-5 rounded border-gray-300 text-primary-600 focus:ring-primary-500">
                        <div>
                            <span class="text-sm font-medium text-gray-700">Berita Unggulan</span>
                            <p class="text-sm text-gray-500">Tampilkan di bagian utama halaman berita</p>
                        </div>
                    </label>
                </div>
            </div>
        </div>

        <!-- SEO Section -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">SEO & Meta</h2>
            
            <div class="space-y-4">
                <!-- Meta Title -->
                <div>
                    <label for="meta_title" class="block text-sm font-medium text-gray-700 mb-1">Meta Title</label>
                    <input type="text" name="meta_title" id="meta_title" value="{{ old('meta_title', $news->meta_title) }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                </div>

                <!-- Meta Description -->
                <div>
                    <label for="meta_description" class="block text-sm font-medium text-gray-700 mb-1">Meta Description</label>
                    <textarea name="meta_description" id="meta_description" rows="2"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">{{ old('meta_description', $news->meta_description) }}</textarea>
                </div>

                <!-- Meta Keywords -->
                <div>
                    <label for="meta_keywords" class="block text-sm font-medium text-gray-700 mb-1">Meta Keywords</label>
                    <input type="text" name="meta_keywords" id="meta_keywords" value="{{ old('meta_keywords', $news->meta_keywords) }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                </div>
            </div>
        </div>

        <!-- Actions -->
        <div class="flex items-center justify-between">
            <button type="button" onclick="document.getElementById('deleteModal').classList.remove('hidden')" 
                class="px-4 py-2 text-red-600 hover:text-red-800 transition-colors">
                Hapus Berita
            </button>
            <div class="flex items-center gap-3">
                <a href="{{ route('admin.news.index') }}" class="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors">
                    Batal
                </a>
                <button type="submit" class="px-6 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition-colors">
                    Simpan Perubahan
                </button>
            </div>
        </div>
    </form>
</div>

<!-- Delete Modal -->
<div id="deleteModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white rounded-xl shadow-xl max-w-md w-full mx-4 p-6">
        <div class="flex items-center gap-4 mb-4">
            <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center">
                <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                </svg>
            </div>
            <div>
                <h3 class="text-lg font-semibold text-gray-900">Hapus Berita</h3>
                <p class="text-sm text-gray-500">Berita akan dipindahkan ke sampah</p>
            </div>
        </div>
        <p class="text-gray-600 mb-6">Apakah Anda yakin ingin menghapus berita "<strong>{{ $news->title }}</strong>"?</p>
        <div class="flex items-center justify-end gap-3">
            <button type="button" onclick="document.getElementById('deleteModal').classList.add('hidden')" 
                class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors">
                Batal
            </button>
            <form method="POST" action="{{ route('admin.news.destroy', $news) }}" class="inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors">
                    Hapus
                </button>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<!-- TinyMCE 6 CDN -->
<script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
<script>
    // Initialize TinyMCE
    tinymce.init({
        selector: '.tinymce-editor',
        height: 500,
        menubar: true,
        language: 'id',
        plugins: [
            'advlist', 'autolink', 'lists', 'link', 'image', 'charmap', 'preview',
            'anchor', 'searchreplace', 'visualblocks', 'code', 'fullscreen',
            'insertdatetime', 'media', 'table', 'help', 'wordcount', 'emoticons',
            'codesample', 'quickbars', 'pagebreak', 'nonbreaking', 'visualchars'
        ],
        toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | ' +
                 'forecolor backcolor | alignleft aligncenter alignright alignjustify | ' +
                 'bullist numlist outdent indent | link image media table | ' +
                 'emoticons charmap | removeformat | code fullscreen preview | help',
        toolbar_mode: 'sliding',
        quickbars_selection_toolbar: 'bold italic | quicklink h2 h3 blockquote',
        quickbars_insert_toolbar: 'quickimage quicktable',
        contextmenu: 'link image table',
        content_style: `
            body { 
                font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif; 
                font-size: 16px; 
                line-height: 1.6;
                color: #374151;
                max-width: 100%;
                padding: 1rem;
            }
            img { 
                max-width: 100%; 
                height: auto; 
                border-radius: 8px;
                margin: 1rem 0;
            }
            p { margin: 0 0 1rem 0; }
            h1, h2, h3, h4, h5, h6 { 
                margin: 1.5rem 0 0.75rem 0; 
                font-weight: 600;
                line-height: 1.3;
            }
            blockquote {
                border-left: 4px solid #f59e0b;
                margin: 1rem 0;
                padding: 0.5rem 1rem;
                background: #fef3c7;
                border-radius: 0 8px 8px 0;
            }
            table {
                border-collapse: collapse;
                width: 100%;
                margin: 1rem 0;
            }
            table th, table td {
                border: 1px solid #e5e7eb;
                padding: 0.75rem;
                text-align: left;
            }
            table th {
                background: #f9fafb;
                font-weight: 600;
            }
            pre {
                background: #1f2937;
                color: #f9fafb;
                padding: 1rem;
                border-radius: 8px;
                overflow-x: auto;
            }
            a { color: #2563eb; }
            hr { border: none; border-top: 2px solid #e5e7eb; margin: 2rem 0; }
        `,
        images_upload_url: '{{ route("admin.news.upload-image") }}',
        images_upload_handler: function (blobInfo, progress) {
            return new Promise((resolve, reject) => {
                const xhr = new XMLHttpRequest();
                xhr.withCredentials = false;
                xhr.open('POST', '{{ route("admin.news.upload-image") }}');
                xhr.setRequestHeader('X-CSRF-TOKEN', '{{ csrf_token() }}');
                
                xhr.upload.onprogress = function (e) {
                    progress(e.loaded / e.total * 100);
                };
                
                xhr.onload = function() {
                    if (xhr.status < 200 || xhr.status >= 300) {
                        reject('HTTP Error: ' + xhr.status);
                        return;
                    }
                    const json = JSON.parse(xhr.responseText);
                    if (!json || typeof json.location != 'string') {
                        reject('Invalid JSON: ' + xhr.responseText);
                        return;
                    }
                    resolve(json.location);
                };
                
                xhr.onerror = function () {
                    reject('Image upload failed');
                };
                
                const formData = new FormData();
                formData.append('file', blobInfo.blob(), blobInfo.filename());
                xhr.send(formData);
            });
        },
        file_picker_types: 'image media',
        file_picker_callback: function(callback, value, meta) {
            const input = document.createElement('input');
            input.setAttribute('type', 'file');
            if (meta.filetype === 'image') {
                input.setAttribute('accept', 'image/*');
            }
            
            input.onchange = function() {
                const file = this.files[0];
                const formData = new FormData();
                formData.append('file', file);
                
                fetch('{{ route("admin.news.upload-image") }}', {
                    method: 'POST',
                    headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    callback(data.location, { title: file.name });
                })
                .catch(error => {
                    console.error('Upload error:', error);
                    alert('Gagal mengupload file');
                });
            };
            input.click();
        },
        promotion: false,
        branding: false,
        resize: true,
        paste_data_images: true,
        automatic_uploads: true,
        relative_urls: false
    });

    function previewImage(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('previewImg').src = e.target.result;
                document.getElementById('imagePreview').classList.remove('hidden');
            };
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endpush
@endsection
