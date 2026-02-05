<footer class="bg-sage-800 text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            
            <!-- About Section -->
            <div>
                <div class="flex items-center space-x-3 mb-4">
                    @if(!empty($globalSettings['site_logo']))
                        <!-- Logo from settings -->
                        <div class="w-12 h-12 rounded-lg overflow-hidden flex items-center justify-center bg-white/10">
                            @if(!empty($globalSettings['site_logo_white']))
                                <img src="{{ Storage::url($globalSettings['site_logo_white']) }}" 
                                     alt="{{ $globalSettings['site_name'] ?? 'Logo' }}" 
                                     class="w-full h-full object-contain">
                            @else
                                <img src="{{ Storage::url($globalSettings['site_logo']) }}" 
                                     alt="{{ $globalSettings['site_name'] ?? 'Logo' }}" 
                                     class="w-full h-full object-contain">
                            @endif
                        </div>
                    @else
                        <!-- Default text logo -->
                        <div class="w-12 h-12 bg-primary rounded-lg flex items-center justify-center">
                            <span class="text-white font-bold text-xl">{{ strtoupper(substr($globalSettings['site_name'] ?? 'LM', 0, 2)) }}</span>
                        </div>
                    @endif
                    <div>
                        <h3 class="text-lg font-bold">{{ $globalSettings['site_name'] ?? 'Lubas Mandiri' }}</h3>
                        <p class="text-sm text-mint-200">{{ $globalSettings['site_tagline'] ?? 'BUMNag Desa Lubas' }}</p>
                    </div>
                </div>
                <p class="text-sm text-mint-200 leading-relaxed">
                    {{ $globalSettings['site_description'] ?? 'Badan Usaha Milik Nagari yang berkomitmen untuk meningkatkan kesejahteraan masyarakat Desa Lubas melalui berbagai unit usaha yang berkelanjutan.' }}
                </p>
            </div>
            
            <!-- Quick Links -->
            <div>
                <h4 class="text-lg font-semibold mb-4">Menu Utama</h4>
                <ul class="space-y-2">
                    <li>
                        <a href="{{ route('home') }}" class="text-mint-200 hover:text-secondary transition-colors duration-200">
                            Beranda
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('about') }}" class="text-mint-200 hover:text-secondary transition-colors duration-200">
                            Tentang Kami
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('catalogs.index') }}" class="text-mint-200 hover:text-secondary transition-colors duration-200">
                            Kadai
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('promotions.index') }}" class="text-mint-200 hover:text-secondary transition-colors duration-200">
                            Promo
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('news.index') }}" class="text-mint-200 hover:text-secondary transition-colors duration-200">
                            Berita
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('reports.index') }}" class="text-mint-200 hover:text-secondary transition-colors duration-200">
                            Laporan
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('gallery') }}" class="text-mint-200 hover:text-secondary transition-colors duration-200">
                            Galeri
                        </a>
                    </li>
                </ul>
            </div>
            
            <!-- Contact Info -->
            <div>
                <h4 class="text-lg font-semibold mb-4">Kontak Kami</h4>
                <ul class="space-y-3">
                    @if($globalSettings['contact_address'])
                    <li class="flex items-start space-x-3">
                        <svg class="w-5 h-5 text-secondary mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        <span class="text-sm text-mint-200">
                            {{ $globalSettings['contact_address'] }}
                        </span>
                    </li>
                    @endif
                    @if($globalSettings['contact_email'])
                    <li class="flex items-center space-x-3">
                        <svg class="w-5 h-5 text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                        <a href="mailto:{{ $globalSettings['contact_email'] }}" class="text-sm text-mint-200 hover:text-secondary transition-colors">
                            {{ $globalSettings['contact_email'] }}
                        </a>
                    </li>
                    @endif
                    @if($globalSettings['contact_phone'])
                    <li class="flex items-center space-x-3">
                        <svg class="w-5 h-5 text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                        </svg>
                        <a href="tel:{{ $globalSettings['contact_phone'] }}" class="text-sm text-mint-200 hover:text-secondary transition-colors">
                            {{ $globalSettings['contact_phone'] }}
                        </a>
                    </li>
                    @endif
                </ul>
            </div>
            
            <!-- Social Media -->
            <div>
                <h4 class="text-lg font-semibold mb-4">Ikuti Kami</h4>
                <div class="flex space-x-3">
                    @if($globalSettings['social_facebook'] && $globalSettings['social_facebook'] !== '#')
                    <a href="{{ $globalSettings['social_facebook'] }}" target="_blank" rel="noopener noreferrer" class="w-10 h-10 bg-sage-700 rounded-full flex items-center justify-center hover:bg-primary transition-colors duration-200">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                        </svg>
                    </a>
                    @endif
                    @if($globalSettings['social_instagram'] && $globalSettings['social_instagram'] !== '#')
                    <a href="{{ $globalSettings['social_instagram'] }}" target="_blank" rel="noopener noreferrer" class="w-10 h-10 bg-sage-700 rounded-full flex items-center justify-center hover:bg-primary transition-colors duration-200">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                        </svg>
                    </a>
                    @endif
                    @if($globalSettings['contact_whatsapp'] && $globalSettings['contact_whatsapp'] !== '#')
                    <a href="https://wa.me/{{ $globalSettings['contact_whatsapp'] }}" target="_blank" rel="noopener noreferrer" class="w-10 h-10 bg-sage-700 rounded-full flex items-center justify-center hover:bg-primary transition-colors duration-200">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/>
                        </svg>
                    </a>
                    @endif
                    @if($globalSettings['social_twitter'] && $globalSettings['social_twitter'] !== '#')
                    <a href="{{ $globalSettings['social_twitter'] }}" target="_blank" rel="noopener noreferrer" class="w-10 h-10 bg-sage-700 rounded-full flex items-center justify-center hover:bg-primary transition-colors duration-200">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/>
                        </svg>
                    </a>
                    @endif
                    @if($globalSettings['social_youtube'] && $globalSettings['social_youtube'] !== '#')
                    <a href="{{ $globalSettings['social_youtube'] }}" target="_blank" rel="noopener noreferrer" class="w-10 h-10 bg-sage-700 rounded-full flex items-center justify-center hover:bg-primary transition-colors duration-200">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/>
                        </svg>
                    </a>
                    @endif
                </div>
                
                <div class="mt-6">
                    <p class="text-sm text-mint-200 mb-2">Jam Operasional:</p>
                    <p class="text-sm font-medium">Senin - Jumat</p>
                    <p class="text-sm text-mint-200">08:00 - 16:00 WIB</p>
                </div>
            </div>
        </div>
        
        <!-- Copyright -->
        <div class="border-t border-sage-700 mt-8 pt-8">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <p class="text-sm text-mint-200">
                    &copy; {{ date('Y') }} {{ $globalSettings['site_name'] ?? 'Lubas Mandiri' }}. All rights reserved.
                </p>
                <div class="flex space-x-6 mt-4 md:mt-0">
                    <a href="#" class="text-sm text-mint-200 hover:text-secondary transition-colors duration-200">
                        Kebijakan Privasi
                    </a>
                    <a href="#" class="text-sm text-mint-200 hover:text-secondary transition-colors duration-200">
                        Syarat & Ketentuan
                    </a>
                </div>
            </div>
        </div>
    </div>
</footer>
