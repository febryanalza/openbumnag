<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>403 - Akses Ditolak | {{ config('app.name', 'Lubas Mandiri') }}</title>
    
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
        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            10%, 30%, 50%, 70%, 90% { transform: translateX(-5px); }
            20%, 40%, 60%, 80% { transform: translateX(5px); }
        }
        .shake-animation {
            animation: shake 0.5s ease-in-out;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .fade-in {
            animation: fadeIn 0.6s ease-out forwards;
        }
    </style>
</head>
<body class="bg-gradient-to-br from-amber-50 via-white to-red-50 min-h-screen flex items-center justify-center px-4">
    <div class="max-w-4xl w-full text-center fade-in">
        <!-- Illustration -->
        <div class="mb-8 sm:mb-12">
            <div class="inline-block shake-animation">
                <svg class="w-48 h-48 sm:w-64 sm:h-64 mx-auto text-amber-200" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                </svg>
            </div>
        </div>

        <!-- Error Code -->
        <div class="mb-6">
            <h1 class="text-8xl sm:text-9xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-amber-600 via-red-600 to-primary">
                403
            </h1>
        </div>

        <!-- Error Message -->
        <div class="mb-8 sm:mb-12">
            <h2 class="text-2xl sm:text-3xl lg:text-4xl font-bold text-gray-900 mb-3 sm:mb-4">
                Akses Ditolak
            </h2>
            <p class="text-base sm:text-lg text-gray-600 max-w-2xl mx-auto mb-2">
                Maaf, Anda tidak memiliki izin untuk mengakses halaman ini.
            </p>
            <p class="text-sm sm:text-base text-gray-500">
                Pastikan Anda sudah login dengan akun yang memiliki hak akses yang sesuai.
            </p>
        </div>

        <!-- Action Buttons -->
        <div class="flex flex-col xs:flex-row gap-3 sm:gap-4 justify-center items-center mb-12">
            <a href="{{ url('/') }}" 
               class="inline-flex items-center px-6 sm:px-8 py-3 sm:py-3.5 bg-gradient-to-r from-primary to-primary-700 text-white font-semibold rounded-lg hover:from-primary-600 hover:to-primary-800 transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                </svg>
                Kembali ke Beranda
            </a>
            
            @guest
            <a href="{{ route('login') }}" 
               class="inline-flex items-center px-6 sm:px-8 py-3 sm:py-3.5 bg-white text-gray-700 font-semibold rounded-lg border-2 border-gray-300 hover:border-primary hover:text-primary transition-all duration-200 shadow-md hover:shadow-lg">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                </svg>
                Login
            </a>
            @else
            <button onclick="window.history.back()" 
                    class="inline-flex items-center px-6 sm:px-8 py-3 sm:py-3.5 bg-white text-gray-700 font-semibold rounded-lg border-2 border-gray-300 hover:border-primary hover:text-primary transition-all duration-200 shadow-md hover:shadow-lg">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Halaman Sebelumnya
            </button>
            @endguest
        </div>

        <!-- Info Box -->
        <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-lg p-6 sm:p-8 border border-gray-200">
            <div class="flex items-start gap-4 text-left max-w-2xl mx-auto">
                <div class="flex-shrink-0">
                    <div class="w-12 h-12 rounded-full bg-amber-100 flex items-center justify-center">
                        <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
                <div class="flex-1">
                    <h3 class="text-lg font-bold text-gray-900 mb-2">
                        Mengapa Akses Ditolak?
                    </h3>
                    <p class="text-gray-600 text-sm mb-3">
                        Halaman ini dibatasi untuk pengguna tertentu. Kemungkinan penyebabnya:
                    </p>
                    <ul class="text-gray-600 text-sm space-y-1">
                        <li class="flex items-start gap-2">
                            <svg class="w-5 h-5 text-primary mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                            <span>Anda belum login ke sistem</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <svg class="w-5 h-5 text-primary mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                            <span>Akun Anda tidak memiliki permission yang diperlukan</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <svg class="w-5 h-5 text-primary mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                            <span>Halaman ini hanya untuk administrator atau role tertentu</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <svg class="w-5 h-5 text-primary mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                            <span>URL yang Anda akses salah atau sudah diubah</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Footer Note -->
        <div class="mt-8 sm:mt-12">
            <p class="text-xs sm:text-sm text-gray-500">
                Jika Anda yakin seharusnya memiliki akses, hubungi administrator untuk bantuan lebih lanjut.
            </p>
        </div>
    </div>
</body>
</html>
