<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>404 - Halaman Tidak Ditemukan | {{ config('app.name', 'Lubas Mandiri') }}</title>
    
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
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }
        .float-animation {
            animation: float 3s ease-in-out infinite;
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
<body class="bg-gradient-to-br from-sage-50 via-white to-primary-50 min-h-screen flex items-center justify-center px-4">
    <div class="max-w-4xl w-full text-center fade-in">
        <!-- Illustration -->
        <div class="mb-8 sm:mb-12">
            <div class="inline-block float-animation">
                <svg class="w-48 h-48 sm:w-64 sm:h-64 mx-auto text-primary-200" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
        </div>

        <!-- Error Code -->
        <div class="mb-6">
            <h1 class="text-8xl sm:text-9xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-primary via-secondary to-sage">
                404
            </h1>
        </div>

        <!-- Error Message -->
        <div class="mb-8 sm:mb-12">
            <h2 class="text-2xl sm:text-3xl lg:text-4xl font-bold text-gray-900 mb-3 sm:mb-4">
                Oops! Halaman Tidak Ditemukan
            </h2>
            <p class="text-base sm:text-lg text-gray-600 max-w-2xl mx-auto mb-2">
                Maaf, halaman yang Anda cari tidak dapat ditemukan atau mungkin telah dipindahkan.
            </p>
            <p class="text-sm sm:text-base text-gray-500">
                Pastikan URL yang Anda masukkan sudah benar atau coba kembali ke beranda.
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
            
            <button onclick="window.history.back()" 
                    class="inline-flex items-center px-6 sm:px-8 py-3 sm:py-3.5 bg-white text-gray-700 font-semibold rounded-lg border-2 border-gray-300 hover:border-primary hover:text-primary transition-all duration-200 shadow-md hover:shadow-lg">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Halaman Sebelumnya
            </button>
        </div>

        <!-- Quick Links -->
        <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-lg p-6 sm:p-8 border border-gray-200">
            <h3 class="text-lg sm:text-xl font-bold text-gray-900 mb-4 sm:mb-6">
                Mungkin Anda Mencari:
            </h3>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-3 sm:gap-4">
                <a href="{{ route('home') }}" 
                   class="group p-4 rounded-xl bg-gradient-to-br from-sage-50 to-sage-100 hover:from-sage-100 hover:to-sage-200 transition-all duration-200 hover:shadow-md">
                    <div class="flex flex-col items-center text-center">
                        <div class="w-10 h-10 sm:w-12 sm:h-12 mb-2 rounded-full bg-sage text-white flex items-center justify-center group-hover:scale-110 transition-transform">
                            <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                            </svg>
                        </div>
                        <span class="text-sm font-semibold text-gray-700 group-hover:text-sage-700">Beranda</span>
                    </div>
                </a>

                <a href="{{ route('catalogs.index') }}" 
                   class="group p-4 rounded-xl bg-gradient-to-br from-primary-50 to-primary-100 hover:from-primary-100 hover:to-primary-200 transition-all duration-200 hover:shadow-md">
                    <div class="flex flex-col items-center text-center">
                        <div class="w-10 h-10 sm:w-12 sm:h-12 mb-2 rounded-full bg-primary text-white flex items-center justify-center group-hover:scale-110 transition-transform">
                            <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                            </svg>
                        </div>
                        <span class="text-sm font-semibold text-gray-700 group-hover:text-primary-700">Katalog</span>
                    </div>
                </a>

                <a href="{{ route('news.index') }}" 
                   class="group p-4 rounded-xl bg-gradient-to-br from-secondary-50 to-secondary-100 hover:from-secondary-100 hover:to-secondary-200 transition-all duration-200 hover:shadow-md">
                    <div class="flex flex-col items-center text-center">
                        <div class="w-10 h-10 sm:w-12 sm:h-12 mb-2 rounded-full bg-secondary text-white flex items-center justify-center group-hover:scale-110 transition-transform">
                            <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                            </svg>
                        </div>
                        <span class="text-sm font-semibold text-gray-700 group-hover:text-secondary-700">Berita</span>
                    </div>
                </a>

                <a href="{{ route('contact') }}" 
                   class="group p-4 rounded-xl bg-gradient-to-br from-blue-50 to-blue-100 hover:from-blue-100 hover:to-blue-200 transition-all duration-200 hover:shadow-md">
                    <div class="flex flex-col items-center text-center">
                        <div class="w-10 h-10 sm:w-12 sm:h-12 mb-2 rounded-full bg-blue-600 text-white flex items-center justify-center group-hover:scale-110 transition-transform">
                            <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <span class="text-sm font-semibold text-gray-700 group-hover:text-blue-700">Kontak</span>
                    </div>
                </a>
            </div>
        </div>

        <!-- Footer Note -->
        <div class="mt-8 sm:mt-12">
            <p class="text-xs sm:text-sm text-gray-500">
                Jika masalah berlanjut, silakan hubungi administrator kami.
            </p>
        </div>
    </div>
</body>
</html>
