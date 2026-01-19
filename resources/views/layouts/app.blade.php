<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
                    }
                }
            }
        }
    </script>
    
    <!-- Custom Styles -->
    <style>
        [x-cloak] { display: none !important; }
    </style>
    
    @stack('styles')
</head>
<body class="bg-gray-50 text-gray-900 antialiased">
    
    <!-- Navigation -->
    @include('layouts.partials.navbar')
    
    <!-- Main Content -->
    <main>
        @yield('content')
    </main>
    
    <!-- Footer -->
    @include('layouts.partials.footer')
    
    @stack('scripts')
</body>
</html>
