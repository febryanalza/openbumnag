<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Panel') - BUMNag</title>
    
    <!-- Tailwind CSS CDN (temporary - will be replaced with compiled assets) -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Custom Tailwind Config -->
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            DEFAULT: '#BB3E00',
                            50: '#FFF5F0',
                            100: '#FFE8DC',
                            200: '#FFCBB3',
                            300: '#FFAE8A',
                            400: '#FF8551',
                            500: '#BB3E00',
                            600: '#A03500',
                            700: '#852C00',
                            800: '#6A2300',
                            900: '#4F1A00',
                        },
                        secondary: {
                            DEFAULT: '#F7AD45',
                            50: '#FFF9ED',
                            100: '#FFF2D9',
                            200: '#FFE5B3',
                            300: '#FFD88D',
                            400: '#FFCB67',
                            500: '#F7AD45',
                            600: '#E89A1F',
                            700: '#C27E0A',
                            800: '#8F5C07',
                            900: '#5C3A05',
                        },
                    }
                }
            }
        }
    </script>
    
    <style>
        [x-cloak] { display: none !important; }
    </style>
    
    @stack('styles')
</head>
<body class="bg-gray-100">
    <div class="min-h-screen flex">
        <!-- Sidebar -->
        <aside class="w-64 bg-gray-800 text-white flex flex-col h-screen fixed">
            <div class="p-4 flex-shrink-0">
                <h1 class="text-2xl font-bold text-amber-400">BUMNag Admin</h1>
            </div>
            
            <nav class="flex-1 overflow-y-auto mt-4 pb-4">
                {{-- Dashboard - Available to all authenticated admin users --}}
                <a href="{{ route('admin.dashboard') }}" class="block px-4 py-3 hover:bg-gray-700 {{ request()->routeIs('admin.dashboard') ? 'bg-gray-700 border-l-4 border-amber-400' : '' }}">
                    <span class="flex items-center">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                        </svg>
                        Dashboard
                    </span>
                </a>
                
                @can('news.view-any')
                <a href="{{ route('admin.news.index') }}" class="block px-4 py-3 hover:bg-gray-700 {{ request()->routeIs('admin.news.*') ? 'bg-gray-700 border-l-4 border-amber-400' : '' }}">
                    <span class="flex items-center">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                        </svg>
                        Berita
                    </span>
                </a>
                @endcan
                
                @can('catalog.view-any')
                <a href="{{ route('admin.catalogs.index') }}" class="block px-4 py-3 hover:bg-gray-700 {{ request()->routeIs('admin.catalogs.*') ? 'bg-gray-700 border-l-4 border-amber-400' : '' }}">
                    <span class="flex items-center">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                        Katalog
                    </span>
                </a>
                @endcan
                
                @can('profile.view-any')
                <a href="{{ route('admin.bumnag-profiles.index') }}" class="block px-4 py-3 hover:bg-gray-700 {{ request()->routeIs('admin.bumnag-profiles.*') ? 'bg-gray-700 border-l-4 border-amber-400' : '' }}">
                    <span class="flex items-center">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                        </svg>
                        Profil BUMNag
                    </span>
                </a>
                @endcan
                
                @can('gallery.view-any')
                <a href="{{ route('admin.galleries.index') }}" class="block px-4 py-3 hover:bg-gray-700 {{ request()->routeIs('admin.galleries.*') ? 'bg-gray-700 border-l-4 border-amber-400' : '' }}">
                    <span class="flex items-center">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        Galeri
                    </span>
                </a>
                @endcan
                
                @can('promotion.view-any')
                <a href="{{ route('admin.promotions.index') }}" class="block px-4 py-3 hover:bg-gray-700 {{ request()->routeIs('admin.promotions.*') ? 'bg-gray-700 border-l-4 border-amber-400' : '' }}">
                    <span class="flex items-center">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"></path>
                        </svg>
                        Promosi
                    </span>
                </a>
                @endcan
                
                @can('report.view-any')
                <a href="{{ route('admin.reports.index') }}" class="block px-4 py-3 hover:bg-gray-700 {{ request()->routeIs('admin.reports.*') ? 'bg-gray-700 border-l-4 border-amber-400' : '' }}">
                    <span class="flex items-center">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        Laporan
                    </span>
                </a>
                @endcan
                
                @can('contact.view-any')
                <a href="{{ route('admin.contacts.index') }}" class="block px-4 py-3 hover:bg-gray-700 {{ request()->routeIs('admin.contacts.*') ? 'bg-gray-700 border-l-4 border-amber-400' : '' }}">
                    <span class="flex items-center">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                        Kontak
                    </span>
                </a>
                @endcan
                
                @can('team.view-any')
                <a href="{{ route('admin.team-members.index') }}" class="block px-4 py-3 hover:bg-gray-700 {{ request()->routeIs('admin.team-members.*') ? 'bg-gray-700 border-l-4 border-amber-400' : '' }}">
                    <span class="flex items-center">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                        Tim
                    </span>
                </a>
                @endcan
                
                @can('category.view-any')
                <a href="{{ route('admin.categories.index') }}" class="block px-4 py-3 hover:bg-gray-700 {{ request()->routeIs('admin.categories.*') ? 'bg-gray-700 border-l-4 border-amber-400' : '' }}">
                    <span class="flex items-center">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                        </svg>
                        Kategori
                    </span>
                </a>
                @endcan
                
                @can('user.view-any')
                <a href="{{ route('admin.users.index') }}" class="block px-4 py-3 hover:bg-gray-700 {{ request()->routeIs('admin.users.*') ? 'bg-gray-700 border-l-4 border-amber-400' : '' }}">
                    <span class="flex items-center">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                        </svg>
                        Users
                    </span>
                </a>
                @endcan
                
                @role('super_admin')
                <div class="border-t border-gray-700 my-2"></div>
                <div class="px-4 py-2 text-xs uppercase text-gray-500">Manajemen Akses</div>
                
                <a href="{{ route('admin.roles.index') }}" class="block px-4 py-3 hover:bg-gray-700 {{ request()->routeIs('admin.roles.*') ? 'bg-gray-700 border-l-4 border-amber-400' : '' }}">
                    <span class="flex items-center">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                        </svg>
                        Roles
                    </span>
                </a>
                
                <a href="{{ route('admin.permissions.index') }}" class="block px-4 py-3 hover:bg-gray-700 {{ request()->routeIs('admin.permissions.*') ? 'bg-gray-700 border-l-4 border-amber-400' : '' }}">
                    <span class="flex items-center">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path>
                        </svg>
                        Permissions
                    </span>
                </a>
                
                <a href="{{ route('admin.settings.index') }}" class="block px-4 py-3 hover:bg-gray-700 {{ request()->routeIs('admin.settings.*') ? 'bg-gray-700 border-l-4 border-amber-400' : '' }}">
                    <span class="flex items-center">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        Pengaturan
                    </span>
                </a>
                
                <a href="{{ route('admin.homepage-settings.index') }}" class="block px-4 py-3 hover:bg-gray-700 {{ request()->routeIs('admin.homepage-settings.*') ? 'bg-gray-700 border-l-4 border-amber-400' : '' }}">
                    <span class="flex items-center">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                        </svg>
                        Pengaturan Homepage
                    </span>
                </a>
                @endrole
            </nav>
            
            <div class="flex-shrink-0 p-4 bg-gray-900 border-t border-gray-700">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 rounded-full bg-amber-500 flex items-center justify-center">
                            <span class="text-white font-bold">{{ substr(Auth::user()->name ?? Auth::user()->email, 0, 1) }}</span>
                        </div>
                    </div>
                    <div class="ml-3 flex-1 min-w-0">
                        <p class="text-sm font-medium truncate">{{ Auth::user()->name ?? Auth::user()->email }}</p>
                        <p class="text-xs text-gray-400 truncate">{{ Auth::user()->getRoleNames()->first() ?? 'User' }}</p>
                    </div>
                    <form method="POST" action="{{ route('admin.logout') }}" id="logoutForm">
                        @csrf
                        <button type="submit" class="text-gray-400 hover:text-white flex-shrink-0" title="Logout">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                            </svg>
                        </button>
                    </form>
                </div>
            </div>
        </aside>
        
        <!-- Main Content -->
        <div class="flex-1 flex flex-col ml-64">
            <!-- Header -->
            <header class="bg-white shadow">
                <div class="px-6 py-4">
                    <h2 class="text-2xl font-semibold text-gray-800">
                        @yield('header', 'Dashboard')
                    </h2>
                </div>
            </header>
            
            <!-- Page Content -->
            <main class="flex-1 overflow-y-auto p-6">
                @if(session('success'))
                    <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                        {{ session('success') }}
                    </div>
                @endif
                
                @if(session('error'))
                    <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                        {{ session('error') }}
                    </div>
                @endif
                
                @yield('content')
            </main>
        </div>
    </div>
    
    @stack('scripts')
</body>
</html>
