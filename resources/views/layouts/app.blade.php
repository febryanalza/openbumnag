<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'Beranda') - {{ $siteName ?? 'Lubas Mandiri' }}</title>
    <meta name="description" content="@yield('description', 'BUMNag Lubas Mandiri - Badan Usaha Milik Nagari Desa Lubas')">
    
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Alpine.js for interactivity -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
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
                        sage: {
                            DEFAULT: '#657C6A',
                            50: '#F5F7F6',
                            100: '#E8ECEB',
                            200: '#D1DAD6',
                            300: '#BAC7C1',
                            400: '#A3B5AC',
                            500: '#657C6A',
                            600: '#516756',
                            700: '#3D5241',
                            800: '#293D2C',
                            900: '#152817',
                        },
                        mint: {
                            DEFAULT: '#A2B9A7',
                            50: '#F7F9F8',
                            100: '#EFF3F0',
                            200: '#DFE7E1',
                            300: '#CFDBD2',
                            400: '#BFCFC3',
                            500: '#A2B9A7',
                            600: '#82A088',
                            700: '#627F68',
                            800: '#425E48',
                            900: '#223D28',
                        },
                    },
                    screens: {
                        'xs': '475px',
                    }
                }
            }
        }
    </script>
    
    <!-- Custom Styles -->
    <style>
        [x-cloak] { display: none !important; }
        
        /* Smooth scroll */
        html { scroll-behavior: smooth; }
        
        /* Better text rendering */
        body {
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }
        
        /* Hide scrollbar but allow scrolling */
        .scrollbar-hide::-webkit-scrollbar { display: none; }
        .scrollbar-hide { -ms-overflow-style: none; scrollbar-width: none; }
        
        /* Line clamp utilities */
        .line-clamp-1 { display: -webkit-box; -webkit-line-clamp: 1; -webkit-box-orient: vertical; overflow: hidden; }
        .line-clamp-2 { display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
        .line-clamp-3 { display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden; }
        .line-clamp-4 { display: -webkit-box; -webkit-line-clamp: 4; -webkit-box-orient: vertical; overflow: hidden; }
        
        /* Aspect ratio utilities for older browsers */
        .aspect-video { aspect-ratio: 16 / 9; }
        .aspect-square { aspect-ratio: 1 / 1; }
        .aspect-4-3 { aspect-ratio: 4 / 3; }
        
        /* Touch-friendly tap targets */
        @media (pointer: coarse) {
            .touch-target { min-height: 44px; min-width: 44px; }
        }
        
        /* Safe area for notched devices */
        .safe-area-inset {
            padding-left: env(safe-area-inset-left);
            padding-right: env(safe-area-inset-right);
        }
        
        /* Prevent horizontal overflow */
        .overflow-x-safe { overflow-x: clip; }
        
        /* Better image loading */
        img { content-visibility: auto; }
        
        /* Custom focus styles for accessibility */
        .focus-ring:focus {
            outline: none;
            ring: 2px;
            ring-offset: 2px;
            ring-color: #BB3E00;
        }
    </style>
    
    @stack('styles')
</head>
<body class="bg-gray-50 text-gray-900 antialiased overflow-x-hidden">
    
    <!-- Navigation -->
    @include('layouts.partials.navbar')
    
    <!-- Main Content -->
    <main class="min-h-screen">
        @yield('content')
    </main>
    
    <!-- Footer -->
    @include('layouts.partials.footer')
    
    <!-- Back to Top Button -->
    <button 
        x-data="{ show: false }"
        @scroll.window="show = window.pageYOffset > 500"
        x-show="show"
        x-cloak
        @click="window.scrollTo({ top: 0, behavior: 'smooth' })"
        class="fixed bottom-6 right-6 z-40 w-12 h-12 bg-primary text-white rounded-full shadow-lg hover:bg-primary-600 transition-all duration-300 flex items-center justify-center hover:scale-110 active:scale-95"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 translate-y-4"
        x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 translate-y-4"
    >
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path>
        </svg>
    </button>
    
    @stack('scripts')
</body>
</html>
