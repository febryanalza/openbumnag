@extends('admin.layouts.app')

@section('title', 'Tambah Berita')
@section('page-title', 'Tambah Berita')

@section('content')
<div class="max-w-5xl mx-auto">
    <!-- Breadcrumb -->
    <nav class="mb-6">
        <ol class="flex items-center space-x-2 text-sm text-gray-500">
            <li><a href="{{ route('admin.dashboard') }}" class="hover:text-primary-600">Dashboard</a></li>
            <li><span class="mx-2">/</span></li>
            <li><a href="{{ route('admin.news.index') }}" class="hover:text-primary-600">Berita</a></li>
            <li><span class="mx-2">/</span></li>
            <li class="text-gray-900 font-medium">Tambah</li>
        </ol>
    </nav>

    <form method="POST" action="{{ route('admin.news.store') }}" enctype="multipart/form-data" class="space-y-6">
        @csrf

        <!-- Main Content Section -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">Konten Berita</h2>
            
            <div class="space-y-4">
                <!-- Title -->
                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Judul <span class="text-red-500">*</span></label>
                    <input type="text" name="title" id="title" value="{{ old('title') }}" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('title') border-red-500 @enderror"
                        placeholder="Masukkan judul berita">
                    @error('title')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Slug -->
                <div>
                    <label for="slug" class="block text-sm font-medium text-gray-700 mb-1">Slug</label>
                    <input type="text" name="slug" id="slug" value="{{ old('slug') }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('slug') border-red-500 @enderror"
                        placeholder="auto-generated-from-title">
                    <p class="mt-1 text-sm text-gray-500">Biarkan kosong untuk generate otomatis dari judul</p>
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
                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Excerpt -->
                <div>
                    <label for="excerpt" class="block text-sm font-medium text-gray-700 mb-1">Ringkasan</label>
                    <textarea name="excerpt" id="excerpt" rows="2"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('excerpt') border-red-500 @enderror"
                        placeholder="Ringkasan singkat berita (maks. 500 karakter)">{{ old('excerpt') }}</textarea>
                    @error('excerpt')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Content -->
                <div>
                    <label for="content" class="block text-sm font-medium text-gray-700 mb-1">Konten <span class="text-red-500">*</span></label>
                    <textarea name="content" id="content" rows="12" required
                        class="tinymce-editor w-full @error('content') border-red-500 @enderror">{{ old('content') }}</textarea>
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
                <label for="featured_image" class="block text-sm font-medium text-gray-700 mb-1">Gambar Utama</label>
                <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg hover:border-primary-500 transition-colors">
                    <div class="space-y-1 text-center">
                        <div id="imagePreview" class="hidden mb-4">
                            <img id="previewImg" src="" alt="Preview" class="mx-auto h-48 object-cover rounded-lg">
                        </div>
                        <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                            <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        <div class="flex text-sm text-gray-600 justify-center">
                            <label for="featured_image" class="relative cursor-pointer bg-white rounded-md font-medium text-primary-600 hover:text-primary-500 focus-within:outline-none">
                                <span>Upload gambar</span>
                                <input id="featured_image" name="featured_image" type="file" class="sr-only" accept="image/*" onchange="previewImage(this)">
                            </label>
                            <p class="pl-1">atau drag and drop</p>
                        </div>
                        <p class="text-xs text-gray-500">PNG, JPG, GIF, WebP maks. 2MB</p>
                    </div>
                </div>
                @error('featured_image')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
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
                            <option value="{{ $key }}" {{ old('status', 'draft') === $key ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                    @error('status')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Published At -->
                <div>
                    <label for="published_at" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Publikasi</label>
                    <input type="datetime-local" name="published_at" id="published_at" value="{{ old('published_at') }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                    <p class="mt-1 text-sm text-gray-500">Kosongkan untuk publikasi langsung</p>
                    @error('published_at')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Featured -->
                <div class="md:col-span-2">
                    <label class="flex items-center gap-3">
                        <input type="checkbox" name="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }}
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
                    <input type="text" name="meta_title" id="meta_title" value="{{ old('meta_title') }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                        placeholder="Judul untuk mesin pencari">
                    <p class="mt-1 text-sm text-gray-500">Kosongkan untuk menggunakan judul berita</p>
                </div>

                <!-- Meta Description -->
                <div>
                    <label for="meta_description" class="block text-sm font-medium text-gray-700 mb-1">Meta Description</label>
                    <textarea name="meta_description" id="meta_description" rows="2"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                        placeholder="Deskripsi untuk mesin pencari">{{ old('meta_description') }}</textarea>
                </div>

                <!-- Meta Keywords -->
                <div>
                    <label for="meta_keywords" class="block text-sm font-medium text-gray-700 mb-1">Meta Keywords</label>
                    <input type="text" name="meta_keywords" id="meta_keywords" value="{{ old('meta_keywords') }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                        placeholder="kata kunci, dipisah, koma">
                </div>
            </div>
        </div>

        <!-- Actions -->
        <div class="flex items-center justify-end gap-3">
            <a href="{{ route('admin.news.index') }}" class="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors">
                Batal
            </a>
            <button type="submit" name="action" value="draft" class="px-6 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors">
                Simpan Draft
            </button>
            <button type="submit" class="px-6 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition-colors">
                Simpan Berita
            </button>
        </div>
    </form>
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
            h1 { font-size: 2rem; }
            h2 { font-size: 1.5rem; }
            h3 { font-size: 1.25rem; }
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
        // Image upload configuration
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
                    if (xhr.status === 403) {
                        reject({ message: 'HTTP Error: ' + xhr.status, remove: true });
                        return;
                    }
                    
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
                    reject('Image upload failed due to a XHR Transport error. Code: ' + xhr.status);
                };
                
                const formData = new FormData();
                formData.append('file', blobInfo.blob(), blobInfo.filename());
                
                xhr.send(formData);
            });
        },
        // File picker for browsing images
        file_picker_types: 'image media',
        file_picker_callback: function(callback, value, meta) {
            const input = document.createElement('input');
            input.setAttribute('type', 'file');
            
            if (meta.filetype === 'image') {
                input.setAttribute('accept', 'image/*');
            } else if (meta.filetype === 'media') {
                input.setAttribute('accept', 'video/*,audio/*');
            }
            
            input.onchange = function() {
                const file = this.files[0];
                const reader = new FileReader();
                
                reader.onload = function() {
                    // Upload the file
                    const formData = new FormData();
                    formData.append('file', file);
                    
                    fetch('{{ route("admin.news.upload-image") }}', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
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
                reader.readAsDataURL(file);
            };
            
            input.click();
        },
        // Templates for common content patterns
        templates: [
            {
                title: 'Dua Kolom Teks-Gambar',
                description: 'Layout dengan teks di kiri dan gambar di kanan',
                content: '<div style="display: flex; gap: 1rem;"><div style="flex: 1;"><p>Tulis konten di sini...</p></div><div style="flex: 1;"><img src="https://via.placeholder.com/400x300" alt="Gambar" /></div></div>'
            },
            {
                title: 'Gambar dengan Caption',
                description: 'Gambar dengan keterangan di bawahnya',
                content: '<figure style="text-align: center;"><img src="https://via.placeholder.com/600x400" alt="Gambar" style="max-width: 100%;" /><figcaption style="color: #6b7280; font-size: 0.875rem; margin-top: 0.5rem;"><em>Keterangan gambar</em></figcaption></figure>'
            },
            {
                title: 'Kutipan/Quote',
                description: 'Blok kutipan untuk highlight',
                content: '<blockquote><p>"Tulis kutipan penting di sini"</p><cite>— Nama Sumber</cite></blockquote>'
            }
        ],
        // Auto-save
        autosave_interval: '30s',
        autosave_prefix: 'tinymce-autosave-news-{path}{query}',
        autosave_restore_when_empty: true,
        // Other settings
        promotion: false,
        branding: false,
        resize: true,
        elementpath: true,
        statusbar: true,
        paste_data_images: true,
        automatic_uploads: true,
        relative_urls: false,
        remove_script_host: false,
        convert_urls: true,
        setup: function(editor) {
            // Custom button for inserting image gallery
            editor.ui.registry.addButton('imagegallery', {
                icon: 'gallery',
                tooltip: 'Sisipkan Galeri Gambar',
                onAction: function() {
                    editor.insertContent('<div class="image-gallery" style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 1rem; margin: 1rem 0;"><img src="https://via.placeholder.com/300x200" alt="Gambar 1" /><img src="https://via.placeholder.com/300x200" alt="Gambar 2" /><img src="https://via.placeholder.com/300x200" alt="Gambar 3" /></div>');
                }
            });
            
            // Word count update
            editor.on('keyup', function() {
                const wordCount = editor.plugins.wordcount.getCount();
                console.log('Word count:', wordCount);
            });
        }
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
