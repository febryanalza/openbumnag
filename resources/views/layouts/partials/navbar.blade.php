<nav x-data="{ mobileMenuOpen: false, scrolled: false }" 
     @scroll.window="scrolled = window.pageYOffset > 50"
     :class="scrolled ? 'bg-white shadow-md' : 'bg-transparent'"
     class="fixed top-0 left-0 right-0 z-50 transition-all duration-300">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-20">
            
            <!-- Logo -->
            <div class="flex-shrink-0 flex items-center">
                <a href="{{ route('home') }}" class="flex items-center space-x-3">
                    @if(!empty($globalSettings['site_logo']))
                        <!-- Logo from settings -->
                        <div class="w-12 h-12 rounded-lg overflow-hidden flex items-center justify-center bg-white/10">
                            <img src="{{ Storage::url($globalSettings['site_logo']) }}" 
                                 alt="{{ $globalSettings['site_name'] ?? 'Logo' }}" 
                                 class="w-full h-full object-contain">
                        </div>
                    @else
                        <!-- Default text logo -->
                        <div class="w-12 h-12 bg-primary rounded-lg flex items-center justify-center">
                            <span class="text-white font-bold text-xl">{{ strtoupper(substr($globalSettings['site_name'] ?? 'LM', 0, 2)) }}</span>
                        </div>
                    @endif
                    <div class="hidden md:block">
                        <h1 class="text-xl font-bold" 
                            :class="scrolled ? 'text-primary' : 'text-white'">
                            {{ $globalSettings['site_name'] ?? 'Lubas Mandiri' }}
                        </h1>
                        <p class="text-xs" 
                           :class="scrolled ? 'text-sage-600' : 'text-white/80'">
                            {{ $globalSettings['site_tagline'] ?? 'BUMNag Nagari Lubuk Basung' }}
                        </p>
                    </div>
                </a>
            </div>
            
            <!-- Desktop Menu -->
            <div class="hidden lg:flex lg:items-center lg:space-x-8">
                <a href="{{ route('home') }}" 
                   class="font-medium transition-colors duration-200 hover:text-primary"
                   :class="scrolled ? 'text-gray-700' : 'text-white'">
                    Beranda
                </a>
                <a href="{{ route('about') }}" 
                   class="font-medium transition-colors duration-200 hover:text-primary"
                   :class="scrolled ? 'text-gray-700' : 'text-white'">
                    Tentang Kami
                </a>
                <a href="{{ route('catalogs.index') }}" 
                   class="font-medium transition-colors duration-200 hover:text-primary"
                   :class="scrolled ? 'text-gray-700' : 'text-white'">
                    Kadai
                </a>
                <a href="{{ route('promotions.index') }}" 
                   class="font-medium transition-colors duration-200 hover:text-primary"
                   :class="scrolled ? 'text-gray-700' : 'text-white'">
                    Promo
                </a>
                <a href="{{ route('news.index') }}" 
                   class="font-medium transition-colors duration-200 hover:text-primary"
                   :class="scrolled ? 'text-gray-700' : 'text-white'">
                    Berita
                </a>
                <a href="{{ route('reports.index') }}" 
                   class="font-medium transition-colors duration-200 hover:text-primary"
                   :class="scrolled ? 'text-gray-700' : 'text-white'">
                    Laporan
                </a>
                <a href="{{ route('gallery') }}" 
                   class="font-medium transition-colors duration-200 hover:text-primary"
                   :class="scrolled ? 'text-gray-700' : 'text-white'">
                    Galeri
                </a>
                <a href="{{ route('home') }}#kontak" 
                   class="inline-flex items-center px-6 py-2.5 bg-primary text-white font-medium rounded-full hover:bg-primary-600 transition-all duration-200 shadow-lg hover:shadow-xl">
                    Hubungi Kami
                </a>
            </div>
            
            <!-- Mobile Menu Button -->
            <div class="flex lg:hidden">
                <button @click="mobileMenuOpen = !mobileMenuOpen" 
                        type="button" 
                        class="inline-flex items-center justify-center p-2 rounded-md transition-colors duration-200"
                        :class="scrolled ? 'text-gray-700 hover:bg-gray-100' : 'text-white hover:bg-white/10'">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path x-show="!mobileMenuOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path x-show="mobileMenuOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
    
    <!-- Mobile Menu -->
    <div x-show="mobileMenuOpen" 
         x-cloak
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 -translate-y-1"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 -translate-y-1"
         class="lg:hidden bg-white shadow-lg">
        <div class="px-4 pt-2 pb-3 space-y-1">
            <a href="{{ route('home') }}" 
               class="block px-4 py-3 rounded-lg text-gray-700 font-medium hover:bg-primary-50 hover:text-primary transition-colors duration-200">
                Beranda
            </a>
            <a href="{{ route('about') }}" 
               class="block px-4 py-3 rounded-lg text-gray-700 font-medium hover:bg-primary-50 hover:text-primary transition-colors duration-200">
                Tentang Kami
            </a>
            <a href="{{ route('catalogs.index') }}" 
               class="block px-4 py-3 rounded-lg text-gray-700 font-medium hover:bg-primary-50 hover:text-primary transition-colors duration-200">
                Kadai
            </a>
            <a href="{{ route('promotions.index') }}" 
               class="block px-4 py-3 rounded-lg text-gray-700 font-medium hover:bg-primary-50 hover:text-primary transition-colors duration-200">
                Promo
            </a>
            <a href="{{ route('news.index') }}" 
               class="block px-4 py-3 rounded-lg text-gray-700 font-medium hover:bg-primary-50 hover:text-primary transition-colors duration-200">
                Berita
            </a>
            <a href="{{ route('reports.index') }}" 
               class="block px-4 py-3 rounded-lg text-gray-700 font-medium hover:bg-primary-50 hover:text-primary transition-colors duration-200">
                Laporan
            </a>
            <a href="{{ route('gallery') }}" 
               class="block px-4 py-3 rounded-lg text-gray-700 font-medium hover:bg-primary-50 hover:text-primary transition-colors duration-200">
                Galeri
            </a>
            <a href="{{ route('home') }}#kontak" 
               class="block px-4 py-3 mt-2 bg-primary text-white text-center font-medium rounded-lg hover:bg-primary-600 transition-colors duration-200">
                Hubungi Kami
            </a>
        </div>
    </div>
</nav>
