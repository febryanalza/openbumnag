<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>503 - Layanan Tidak Tersedia | {{ config('app.name', 'Lubas Mandiri') }}</title>
    
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
        @keyframes rotate {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }
        .rotate-animation {
            animation: rotate 2s linear infinite;
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
<body class="bg-gradient-to-br from-blue-50 via-white to-sage-50 min-h-screen flex items-center justify-center px-4">
    <div class="max-w-4xl w-full text-center fade-in">
        <!-- Illustration -->
        <div class="mb-8 sm:mb-12">
            <div class="inline-block">
                <svg class="w-48 h-48 sm:w-64 sm:h-64 mx-auto text-blue-200" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                </svg>
                <div class="flex justify-center mt-4">
                    <svg class="w-12 h-12 text-primary rotate-animation" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Error Code -->
        <div class="mb-6">
            <h1 class="text-8xl sm:text-9xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-blue-600 via-sage to-primary">
                503
            </h1>
        </div>

        <!-- Error Message -->
        <div class="mb-8 sm:mb-12">
            <h2 class="text-2xl sm:text-3xl lg:text-4xl font-bold text-gray-900 mb-3 sm:mb-4">
                Layanan Sedang Dalam Pemeliharaan
            </h2>
            <p class="text-base sm:text-lg text-gray-600 max-w-2xl mx-auto mb-2">
                Website sedang dalam proses pemeliharaan untuk meningkatkan layanan kami.
            </p>
            <p class="text-sm sm:text-base text-gray-500">
                Kami akan kembali online secepatnya. Terima kasih atas kesabaran Anda.
            </p>
        </div>

        <!-- Action Buttons -->
        <div class="flex flex-col xs:flex-row gap-3 sm:gap-4 justify-center items-center mb-12">
            <button onclick="location.reload()" 
                    class="inline-flex items-center px-6 sm:px-8 py-3 sm:py-3.5 bg-gradient-to-r from-primary to-primary-700 text-white font-semibold rounded-lg hover:from-primary-600 hover:to-primary-800 transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                </svg>
                Coba Lagi
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
                        Sedang Apa yang Kami Lakukan?
                    </h3>
                    <p class="text-gray-600 text-sm mb-3">
                        Tim kami sedang melakukan:
                    </p>
                    <ul class="text-gray-600 text-sm space-y-1">
                        <li class="flex items-start gap-2">
                            <svg class="w-5 h-5 text-primary mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                            <span>Pembaruan sistem untuk performa lebih baik</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <svg class="w-5 h-5 text-primary mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                            <span>Peningkatan fitur dan keamanan</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <svg class="w-5 h-5 text-primary mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                            <span>Pemeliharaan rutin database dan server</span>
                        </li>
                    </ul>
                    <p class="text-gray-600 text-sm mt-4">
                        Estimasi waktu pemeliharaan biasanya <strong>tidak lebih dari 30 menit</strong>.
                    </p>
                </div>
            </div>
        </div>

        <!-- Footer Note -->
        <div class="mt-8 sm:mt-12">
            <p class="text-xs sm:text-sm text-gray-500">
                Terima kasih atas pengertian Anda. Kami berkomitmen memberikan layanan terbaik.
            </p>
        </div>
    </div>
</body>
</html>
