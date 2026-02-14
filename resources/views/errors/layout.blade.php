<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'Error') - {{ config('app.name', 'Lubas Mandiri') }}</title>
    
    <!-- Tailwind CSS CDN -->
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
                        sage: {
                            DEFAULT: '#657C6A',
                            50: '#F5F7F6',
                            100: '#E5EBE7',
                            200: '#CBD7CF',
                            300: '#B1C3B7',
                            400: '#97AF9F',
                            500: '#657C6A',
                            600: '#526353',
                            700: '#3F4A3F',
                            800: '#2C312B',
                            900: '#191817',
                        },
                    }
                }
            }
        }
    </script>
    
    <style>
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .fade-in {
            animation: fadeIn 0.6s ease-out forwards;
        }
    </style>
</head>
<body class="bg-gradient-to-br from-gray-50 via-white to-sage-50 min-h-screen flex items-center justify-center px-4">
    <div class="max-w-4xl w-full text-center fade-in">
        @yield('content')

        <!-- Default Footer -->
        @hasSection('footer')
            @yield('footer')
        @else
        <div class="mt-8 sm:mt-12">
            <p class="text-xs sm:text-sm text-gray-500">
                Jika masalah berlanjut, silakan hubungi administrator kami.
            </p>
        </div>
        @endif
    </div>
</body>
</html>
