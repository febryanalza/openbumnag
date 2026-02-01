@extends('admin.layouts.app')

@section('title', 'Detail User')
@section('header', 'Detail User')

@section('content')
<div class="max-w-4xl">
    {{-- Breadcrumb --}}
    <nav class="flex mb-6" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
            <li class="inline-flex items-center">
                <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center text-sm font-medium text-gray-500 hover:text-amber-600">
                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path>
                    </svg>
                    Dashboard
                </a>
            </li>
            <li>
                <div class="flex items-center">
                    <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                    </svg>
                    <a href="{{ route('admin.users.index') }}" class="ml-1 text-sm font-medium text-gray-500 hover:text-amber-600 md:ml-2">Users</a>
                </div>
            </li>
            <li aria-current="page">
                <div class="flex items-center">
                    <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                    </svg>
                    <span class="ml-1 text-sm font-medium text-gray-900 md:ml-2">{{ $user->name }}</span>
                </div>
            </li>
        </ol>
    </nav>

    {{-- User Profile Card --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden mb-6">
        <div class="bg-gradient-to-r from-amber-500 to-amber-600 px-6 py-8">
            <div class="flex flex-col md:flex-row items-center gap-6">
                <div class="w-24 h-24 rounded-full bg-white/20 backdrop-blur-sm flex items-center justify-center text-white font-bold text-4xl flex-shrink-0 border-4 border-white/30">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                </div>
                <div class="text-center md:text-left flex-1">
                    <h2 class="text-2xl font-bold text-white">{{ $user->name }}</h2>
                    <p class="text-amber-100 mt-1">{{ $user->email }}</p>
                    <div class="flex flex-wrap justify-center md:justify-start gap-2 mt-3">
                        @foreach($user->roles as $role)
                            @php
                                $colors = [
                                    'super_admin' => 'bg-red-500/20 text-white border-red-300/30',
                                    'admin' => 'bg-purple-500/20 text-white border-purple-300/30',
                                    'editor' => 'bg-blue-500/20 text-white border-blue-300/30',
                                    'content_manager' => 'bg-green-500/20 text-white border-green-300/30',
                                    'viewer' => 'bg-gray-500/20 text-white border-gray-300/30',
                                ];
                                $color = $colors[$role->name] ?? 'bg-white/20 text-white border-white/30';
                            @endphp
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium border {{ $color }}">
                                {{ ucfirst(str_replace('_', ' ', $role->name)) }}
                            </span>
                        @endforeach
                    </div>
                </div>
                <div class="flex gap-2">
                    @if($user->trashed())
                        <form action="{{ route('admin.users.restore', $user->id) }}" method="POST" class="inline">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="inline-flex items-center gap-2 px-4 py-2 bg-white/20 hover:bg-white/30 text-white font-medium text-sm rounded-lg transition-colors border border-white/30">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                </svg>
                                Pulihkan
                            </button>
                        </form>
                    @else
                        <a href="{{ route('admin.users.edit', $user) }}" class="inline-flex items-center gap-2 px-4 py-2 bg-white text-amber-600 font-medium text-sm rounded-lg hover:bg-amber-50 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                            Edit
                        </a>
                    @endif
                </div>
            </div>
        </div>

        {{-- Trashed Alert --}}
        @if($user->trashed())
            <div class="bg-red-50 border-l-4 border-red-400 p-4">
                <div class="flex items-center">
                    <svg class="w-5 h-5 text-red-400 mr-3" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                    </svg>
                    <div>
                        <p class="text-sm font-medium text-red-800">User ini berada di Trash</p>
                        <p class="text-xs text-red-600 mt-1">Dihapus pada {{ $user->deleted_at->format('d M Y H:i') }}</p>
                    </div>
                </div>
            </div>
        @endif

        {{-- User Info --}}
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="bg-gray-50 rounded-lg p-4">
                    <div class="flex items-center gap-3">
                        <div class="flex-shrink-0 w-10 h-10 bg-amber-100 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 uppercase tracking-wide">ID User</p>
                            <p class="text-lg font-bold text-gray-900">#{{ $user->id }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-gray-50 rounded-lg p-4">
                    <div class="flex items-center gap-3">
                        <div class="flex-shrink-0 w-10 h-10 {{ $user->email_verified_at ? 'bg-green-100' : 'bg-yellow-100' }} rounded-lg flex items-center justify-center">
                            @if($user->email_verified_at)
                                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            @else
                                <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            @endif
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 uppercase tracking-wide">Status Email</p>
                            <p class="text-lg font-bold {{ $user->email_verified_at ? 'text-green-600' : 'text-yellow-600' }}">
                                {{ $user->email_verified_at ? 'Terverifikasi' : 'Belum Verifikasi' }}
                            </p>
                        </div>
                    </div>
                </div>

                <div class="bg-gray-50 rounded-lg p-4">
                    <div class="flex items-center gap-3">
                        <div class="flex-shrink-0 w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 uppercase tracking-wide">Jumlah Role</p>
                            <p class="text-lg font-bold text-gray-900">{{ $user->roles->count() }} Role</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
        {{-- Roles Card --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                <h3 class="text-lg font-semibold text-gray-900 flex items-center gap-2">
                    <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                    </svg>
                    Roles
                </h3>
            </div>
            <div class="p-6">
                @if($user->roles->count() > 0)
                    <div class="space-y-3">
                        @foreach($user->roles as $role)
                            @php
                                $colors = [
                                    'super_admin' => 'bg-red-100 text-red-800 border-red-200',
                                    'admin' => 'bg-purple-100 text-purple-800 border-purple-200',
                                    'editor' => 'bg-blue-100 text-blue-800 border-blue-200',
                                    'content_manager' => 'bg-green-100 text-green-800 border-green-200',
                                    'viewer' => 'bg-gray-100 text-gray-800 border-gray-200',
                                ];
                                $color = $colors[$role->name] ?? 'bg-gray-100 text-gray-800 border-gray-200';
                            @endphp
                            <div class="flex items-center justify-between p-3 rounded-lg border {{ $color }}">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full bg-white flex items-center justify-center">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                        </svg>
                                    </div>
                                    <span class="font-medium">{{ ucfirst(str_replace('_', ' ', $role->name)) }}</span>
                                </div>
                                <span class="text-xs opacity-75">{{ $role->permissions->count() }} permissions</span>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500 text-sm text-center py-4">Tidak ada role yang diberikan</p>
                @endif
            </div>
        </div>

        {{-- Timeline Card --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                <h3 class="text-lg font-semibold text-gray-900 flex items-center gap-2">
                    <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Timeline
                </h3>
            </div>
            <div class="p-6">
                <ol class="relative border-l border-gray-200 ml-3">
                    <li class="mb-6 ml-6">
                        <span class="absolute flex items-center justify-center w-6 h-6 bg-green-100 rounded-full -left-3 ring-8 ring-white">
                            <svg class="w-3 h-3 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                        </span>
                        <h3 class="text-sm font-semibold text-gray-900">Akun Dibuat</h3>
                        <time class="text-xs text-gray-500">{{ $user->created_at->format('d M Y H:i') }}</time>
                        <p class="text-xs text-gray-400 mt-1">{{ $user->created_at->diffForHumans() }}</p>
                    </li>
                    
                    @if($user->email_verified_at)
                        <li class="mb-6 ml-6">
                            <span class="absolute flex items-center justify-center w-6 h-6 bg-blue-100 rounded-full -left-3 ring-8 ring-white">
                                <svg class="w-3 h-3 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                            </span>
                            <h3 class="text-sm font-semibold text-gray-900">Email Terverifikasi</h3>
                            <time class="text-xs text-gray-500">{{ $user->email_verified_at->format('d M Y H:i') }}</time>
                            <p class="text-xs text-gray-400 mt-1">{{ $user->email_verified_at->diffForHumans() }}</p>
                        </li>
                    @endif
                    
                    <li class="mb-6 ml-6">
                        <span class="absolute flex items-center justify-center w-6 h-6 bg-amber-100 rounded-full -left-3 ring-8 ring-white">
                            <svg class="w-3 h-3 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                        </span>
                        <h3 class="text-sm font-semibold text-gray-900">Terakhir Diperbarui</h3>
                        <time class="text-xs text-gray-500">{{ $user->updated_at->format('d M Y H:i') }}</time>
                        <p class="text-xs text-gray-400 mt-1">{{ $user->updated_at->diffForHumans() }}</p>
                    </li>

                    @if($user->trashed())
                        <li class="ml-6">
                            <span class="absolute flex items-center justify-center w-6 h-6 bg-red-100 rounded-full -left-3 ring-8 ring-white">
                                <svg class="w-3 h-3 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                </svg>
                            </span>
                            <h3 class="text-sm font-semibold text-gray-900">Dihapus</h3>
                            <time class="text-xs text-gray-500">{{ $user->deleted_at->format('d M Y H:i') }}</time>
                            <p class="text-xs text-gray-400 mt-1">{{ $user->deleted_at->diffForHumans() }}</p>
                        </li>
                    @endif
                </ol>
            </div>
        </div>
    </div>

    {{-- Permissions Card --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden mb-6">
        <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
            <h3 class="text-lg font-semibold text-gray-900 flex items-center gap-2">
                <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path>
                </svg>
                Semua Permissions
                <span class="ml-auto text-sm font-normal text-gray-500">{{ $user->getAllPermissions()->count() }} permissions</span>
            </h3>
        </div>
        <div class="p-6">
            @php
                $permissions = $user->getAllPermissions()->groupBy(function($permission) {
                    $parts = explode('_', $permission->name);
                    return ucfirst(end($parts));
                });
            @endphp
            
            @if($permissions->count() > 0)
                <div class="space-y-4">
                    @foreach($permissions as $group => $perms)
                        <div>
                            <h4 class="text-sm font-medium text-gray-700 mb-2">{{ $group }}</h4>
                            <div class="flex flex-wrap gap-2">
                                @foreach($perms as $permission)
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-medium bg-gray-100 text-gray-700">
                                        <svg class="w-3 h-3 mr-1 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                        </svg>
                                        {{ str_replace('_', ' ', $permission->name) }}
                                    </span>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-500 text-sm text-center py-4">Tidak ada permission yang diberikan</p>
            @endif
        </div>
    </div>

    {{-- Action Buttons --}}
    <div class="flex items-center justify-between">
        <a href="{{ route('admin.users.index') }}" class="inline-flex items-center gap-2 text-gray-500 hover:text-gray-700 text-sm font-medium">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Kembali ke Daftar
        </a>
        
        @if(!$user->trashed() && auth()->id() !== $user->id)
            <div class="flex items-center gap-3">
                <a href="{{ route('admin.users.edit', $user) }}" class="inline-flex items-center gap-2 px-4 py-2 bg-amber-500 hover:bg-amber-600 text-white font-medium text-sm rounded-lg transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                    Edit User
                </a>
            </div>
        @endif
    </div>
</div>
@endsection
