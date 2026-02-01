@extends('admin.layouts.app')

@section('title', $title)
@section('header', $title)

@section('content')
<div class="bg-white rounded-lg shadow p-8 text-center">
    <div class="mb-6">
        <svg class="mx-auto h-24 w-24 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path>
        </svg>
    </div>
    
    <h2 class="text-2xl font-bold text-gray-900 mb-4">{{ $title }}</h2>
    
    <p class="text-gray-600 mb-6">
        Halaman ini sedang dalam pengembangan. Resource management akan ditambahkan segera.
    </p>
    
    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 text-left max-w-2xl mx-auto">
        <h3 class="font-semibold text-yellow-900 mb-2">💡 Untuk Developer:</h3>
        <p class="text-yellow-700 text-sm">
            Untuk menambahkan CRUD functionality, Anda bisa:
        </p>
        <ol class="list-decimal list-inside text-yellow-700 text-sm mt-2 space-y-1">
            <li>Create controller: <code class="bg-yellow-100 px-1">php artisan make:controller Admin/NamaController --resource</code></li>
            <li>Add routes di <code class="bg-yellow-100 px-1">routes/admin.php</code></li>
            <li>Create views di <code class="bg-yellow-100 px-1">resources/views/admin/nama/</code></li>
            <li>Atau gunakan resource generator package seperti Laravel CRUD Generator</li>
        </ol>
    </div>
    
    <div class="mt-6">
        <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center px-4 py-2 bg-amber-600 text-white rounded-lg hover:bg-amber-700">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Kembali ke Dashboard
        </a>
    </div>
</div>
@endsection
