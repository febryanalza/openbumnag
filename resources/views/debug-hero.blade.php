<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Debug Hero Images</title>
    <style>
        body { font-family: sans-serif; padding: 20px; background: #f5f5f5; }
        .container { max-width: 1200px; margin: 0 auto; background: white; padding: 30px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        h1 { color: #333; border-bottom: 3px solid #4CAF50; padding-bottom: 10px; }
        h2 { color: #666; margin-top: 30px; }
        .info { background: #e3f2fd; padding: 15px; border-radius: 5px; margin: 10px 0; }
        .warning { background: #fff3cd; padding: 15px; border-radius: 5px; margin: 10px 0; border-left: 4px solid #ffc107; }
        .success { background: #d4edda; padding: 15px; border-radius: 5px; margin: 10px 0; border-left: 4px solid #28a745; }
        .error { background: #f8d7da; padding: 15px; border-radius: 5px; margin: 10px 0; border-left: 4px solid #dc3545; }
        .image-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 20px; margin-top: 20px; }
        .image-card { border: 1px solid #ddd; border-radius: 8px; overflow: hidden; }
        .image-card img { width: 100%; height: 200px; object-fit: cover; }
        .image-info { padding: 15px; background: #f9f9f9; }
        .code { background: #272822; color: #f8f8f2; padding: 15px; border-radius: 5px; overflow-x: auto; font-family: 'Courier New', monospace; margin: 10px 0; }
        .check { color: #28a745; font-weight: bold; }
        .cross { color: #dc3545; font-weight: bold; }
        pre { margin: 0; white-space: pre-wrap; word-wrap: break-word; }
    </style>
</head>
<body>
    <div class="container">
        <h1>🔍 Debug Hero Images</h1>
        
        <div class="info">
            <strong>📅 Timestamp:</strong> {{ now()->format('Y-m-d H:i:s') }}
        </div>

        <h2>1️⃣ Database Setting</h2>
        @php
            $setting = \App\Models\Setting::where('key', 'hero_images')->first();
        @endphp
        
        @if($setting)
            <div class="success">
                <strong class="check">✓</strong> Setting 'hero_images' ditemukan di database
            </div>
            <div class="code">
                <pre>{{ json_encode(json_decode($setting->value, true), JSON_PRETTY_PRINT) }}</pre>
            </div>
        @else
            <div class="error">
                <strong class="cross">✗</strong> Setting 'hero_images' TIDAK ditemukan di database
            </div>
        @endif

        <h2>2️⃣ Parsed Data dari Controller</h2>
        <div class="info">
            <strong>Jumlah gambar:</strong> {{ count($heroImages) }}
        </div>
        
        @if(count($heroImages) > 0)
            <div class="success">
                <strong class="check">✓</strong> Gambar ditemukan
            </div>
            <div class="code">
                <pre>{{ json_encode($heroImages->toArray(), JSON_PRETTY_PRINT) }}</pre>
            </div>
        @else
            <div class="warning">
                <strong>⚠</strong> Tidak ada gambar yang ditemukan
            </div>
        @endif

        <h2>3️⃣ Preview Gambar</h2>
        @if(count($heroImages) > 0)
            <div class="image-grid">
                @foreach($heroImages as $index => $image)
                    @php
                        $fullPath = storage_path('app/public/' . $image->file_path);
                        $publicPath = public_path('storage/' . $image->file_path);
                        $url = \Storage::url($image->file_path);
                    @endphp
                    <div class="image-card">
                        <img src="{{ $url }}" 
                             alt="{{ $image->title }}"
                             onerror="this.style.display='none'; this.nextElementSibling.style.display='block';">
                        <div style="display:none; padding: 20px; text-align: center; background: #f8d7da; color: #721c24;">
                            <strong>⚠ Gambar Gagal Dimuat</strong>
                        </div>
                        <div class="image-info">
                            <strong>Index:</strong> {{ $index }}<br>
                            <strong>Title:</strong> {{ $image->title }}<br>
                            <strong>Path:</strong> <code>{{ $image->file_path }}</code><br>
                            <strong>URL:</strong> <code>{{ $url }}</code><br>
                            <br>
                            <strong>File Exists in Storage?</strong>
                            @if(file_exists($fullPath))
                                <span class="check">✓ YES</span><br>
                                <small>{{ $fullPath }}</small>
                            @else
                                <span class="cross">✗ NO</span><br>
                                <small style="color: #dc3545;">{{ $fullPath }}</small>
                            @endif
                            <br><br>
                            <strong>File Exists in Public?</strong>
                            @if(file_exists($publicPath))
                                <span class="check">✓ YES</span><br>
                                <small>{{ $publicPath }}</small>
                            @else
                                <span class="cross">✗ NO</span><br>
                                <small style="color: #dc3545;">{{ $publicPath }}</small>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="warning">
                Tidak ada gambar untuk ditampilkan
            </div>
        @endif

        <h2>4️⃣ Storage Configuration</h2>
        <div class="code">
            <pre>Storage Disk: {{ config('filesystems.default') }}
Storage Path: {{ storage_path('app/public') }}
Public Path: {{ public_path('storage') }}
Symbolic Link Exists: {{ is_link(public_path('storage')) ? '✓ YES' : '✗ NO' }}</pre>
        </div>

        <h2>5️⃣ Settings Cache</h2>
        <div class="info">
            <strong>Cache Driver:</strong> {{ config('cache.default') }}
        </div>

        <div style="margin-top: 30px; padding: 20px; background: #e3f2fd; border-radius: 5px;">
            <strong>🔗 Quick Links:</strong><br>
            <a href="/" style="color: #1976d2; text-decoration: none;">← Kembali ke Homepage</a> |
            <a href="/admin/manage-settings" style="color: #1976d2; text-decoration: none;">Manage Settings</a> |
            <a href="/admin" style="color: #1976d2; text-decoration: none;">Admin Panel</a>
        </div>
    </div>
</body>
</html>
