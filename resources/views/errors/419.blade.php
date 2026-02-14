<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>419 - Sesi Telah Berakhir | {{ config('app.name', 'Lubas Mandiri') }}</title>
    
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
        @keyframes clockTick {
            0%, 100% { transform: rotate(0deg); }
            50% { transform: rotate(10deg); }
        }
        .clock-animation {
            animation: clockTick 1s ease-in-out infinite;
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
<body class="bg-gradient-to-br from-orange-50 via-white to-sage-50 min-h-screen flex items-center justify-center px-4">
    <div class="max-w-4xl w-full text-center fade-in">
        <!-- Illustration -->
        <div class="mb-8 sm:mb-12">
            <div class="inline-block clock-animation">
                <svg class="w-48 h-48 sm:w-64 sm:h-64 mx-auto text-orange-200" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
        </div>

        <!-- Error Code -->
        <div class="mb-6">
            <h1 class="text-8xl sm:text-9xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-orange-600 via-primary to-sage">
                419
            </h1>
        </div>

        <!-- Error Message -->
        <div class="mb-8 sm:mb-12">
            <h2 class="text-2xl sm:text-3xl lg:text-4xl font-bold text-gray-900 mb-3 sm:mb-4">
                Sesi Anda Telah Berakhir
            </h2>
            <p class="text-base sm:text-lg text-gray-600 max-w-2xl mx-auto mb-2">
                Halaman ini telah terlalu lama tidak aktif dan sesi keamanan Anda telah berakhir.
            </p>
            <p class="text-sm sm:text-base text-gray-500">
                Silakan muat ulang halaman ini dan coba lagi.
            </p>
        </div>

        <!-- Action Buttons -->
        <div class="flex flex-col xs:flex-row gap-3 sm:gap-4 justify-center items-center mb-12">
            <button onclick="location.reload()" 
                    class="inline-flex items-center px-6 sm:px-8 py-3 sm:py-3.5 bg-gradient-to-r from-primary to-primary-700 text-white font-semibold rounded-lg hover:from-primary-600 hover:to-primary-800 transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                </svg>
                Muat Ulang Halaman
            </button>
            
            <a href="{{ url('/') }}" 
               class="inline-flex items-center px-6 sm:px-8 py-3 sm:py-3.5 bg-white text-gray-700 font-semibold rounded-lg border-2 border-gray-300 hover:border-primary hover:text-primary transition-all duration-200 shadow-md hover:shadow-lg">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                </svg>
                Kembali ke Beranda
            </a>
        </div>

        <!-- Info Box -->
        <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-lg p-6 sm:p-8 border border-gray-200">
            <div class="flex items-start gap-4 text-left max-w-2xl mx-auto">
                <div class="flex-shrink-0">
                    <div class="w-12 h-12 rounded-full bg-blue-100 flex items-center justify-center">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
                <div class="flex-1">
                    <h3 class="text-lg font-bold text-gray-900 mb-2">
                        Mengapa Ini Terjadi?
                    </h3>
                    <p class="text-gray-600 text-sm mb-3">
                        Ini adalah mekanisme keamanan normal untuk melindungi data Anda. Kemungkinan penyebab:
                    </p>
                    <ul class="text-gray-600 text-sm space-y-1">
                        <li class="flex items-start gap-2">
                            <svg class="w-5 h-5 text-primary mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                            <span>Halaman dibiarkan terbuka terlalu lama (lebih dari 2 jam)</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <svg class="w-5 h-5 text-primary mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                            <span>Browser cache atau cookies telah dihapus</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <svg class="w-5 h-5 text-primary mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                            <span>Menggunakan tombol back/forward browser setelah submit form</span>
                        </li>
                    </ul>
                    <p class="text-gray-600 text-sm mt-4">
                        <strong>Solusi:</strong> Cukup muat ulang halaman ini untuk mendapatkan sesi baru yang segar.
                    </p>
                </div>
            </div>
        </div>

        <!-- Footer Note -->
        <div class="mt-8 sm:mt-12">
            <p class="text-xs sm:text-sm text-gray-500">
                Fitur keamanan ini melindungi Anda dari serangan CSRF (Cross-Site Request Forgery).
            </p>
        </div>
    </div>
</body>
</html>
