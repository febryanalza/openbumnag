@extends('layouts.app')

@section('title', $settings['about_page_title'] ?? 'Tentang Kami')
@section('description', $settings['about_page_description'] ?? 'Mengenal BUMNag Lubas Mandiri')

@section('content')
<!-- Hero Section -->
<section class="relative py-20 bg-gradient-to-br from-primary via-sage to-mint overflow-hidden">
    <div class="absolute inset-0 bg-black/10"></div>
    <div class="absolute inset-0" style="background-image: url('data:image/svg+xml,%3Csvg width=&quot;60&quot; height=&quot;60&quot; viewBox=&quot;0 0 60 60&quot; xmlns=&quot;http://www.w3.org/2000/svg&quot;%3E%3Cg fill=&quot;none&quot; fill-rule=&quot;evenodd&quot;%3E%3Cg fill=&quot;%23ffffff&quot; fill-opacity=&quot;0.05&quot;%3E%3Cpath d=&quot;M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z&quot;/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>
    
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center">
            <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-white mb-4" data-aos="fade-up">
                {{ $settings['about_page_title'] ?? 'Tentang Kami' }}
            </h1>
            <p class="text-xl md:text-2xl text-white/90 max-w-3xl mx-auto" data-aos="fade-up" data-aos-delay="100">
                {{ $settings['about_page_subtitle'] ?? 'Mengenal BUMNag Lubas Mandiri' }}
            </p>
        </div>
    </div>
</section>

<!-- About Description -->
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-4xl mx-auto text-center">
            <p class="text-lg md:text-xl text-gray-700 leading-relaxed" data-aos="fade-up">
                {{ $settings['about_page_description'] ?? 'BUMNag Lubas Mandiri adalah Badan Usaha Milik Nagari yang berkomitmen untuk meningkatkan kesejahteraan masyarakat.' }}
            </p>
        </div>
    </div>
</section>

<!-- Vision, Mission, Values -->
<section class="py-20 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid md:grid-cols-3 gap-8">
            <!-- Vision -->
            <div class="bg-white rounded-2xl shadow-lg p-8 hover:shadow-xl transition-shadow duration-300" data-aos="fade-up">
                <div class="w-16 h-16 bg-primary/10 rounded-full flex items-center justify-center mb-6">
                    <svg class="w-8 h-8 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-4">
                    {{ $settings['about_vision_title'] ?? 'Visi Kami' }}
                </h3>
                <p class="text-gray-600 leading-relaxed">
                    {{ $settings['about_vision_content'] ?? 'Menjadi BUMNag terdepan yang mandiri, profesional, dan berkelanjutan.' }}
                </p>
            </div>

            <!-- Mission -->
            <div class="bg-white rounded-2xl shadow-lg p-8 hover:shadow-xl transition-shadow duration-300" data-aos="fade-up" data-aos-delay="100">
                <div class="w-16 h-16 bg-sage/10 rounded-full flex items-center justify-center mb-6">
                    <svg class="w-8 h-8 text-sage" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-4">
                    {{ $settings['about_mission_title'] ?? 'Misi Kami' }}
                </h3>
                <div class="text-gray-600 leading-relaxed whitespace-pre-line">
                    {{ $settings['about_mission_content'] ?? "1. Mengembangkan unit usaha yang produktif\n2. Meningkatkan kualitas SDM\n3. Menciptakan lapangan kerja" }}
                </div>
            </div>

            <!-- Values -->
            <div class="bg-white rounded-2xl shadow-lg p-8 hover:shadow-xl transition-shadow duration-300" data-aos="fade-up" data-aos-delay="200">
                <div class="w-16 h-16 bg-secondary/10 rounded-full flex items-center justify-center mb-6">
                    <svg class="w-8 h-8 text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path>
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-4">
                    {{ $settings['about_values_title'] ?? 'Nilai-Nilai Kami' }}
                </h3>
                <p class="text-gray-600 leading-relaxed">
                    {{ $settings['about_values_content'] ?? 'Integritas • Transparansi • Profesionalisme • Inovasi' }}
                </p>
            </div>
        </div>
    </div>
</section>

<!-- BUMNag Profiles -->
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4" data-aos="fade-up">
                {{ $settings['about_title'] ?? 'Unit Usaha Kami' }}
            </h2>
            <p class="text-lg text-gray-600 max-w-2xl mx-auto" data-aos="fade-up" data-aos-delay="100">
                {{ $settings['about_description'] ?? 'Berbagai unit usaha yang kami kelola untuk kesejahteraan masyarakat' }}
            </p>
        </div>

        @if($bumnagProfiles->count() > 0)
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($bumnagProfiles as $index => $profile)
            <div class="group bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2" data-aos="fade-up" data-aos-delay="{{ $index * 100 }}">
                @if($profile->banner)
                <div class="relative h-48 overflow-hidden">
                    <img src="{{ Storage::url($profile->banner) }}" 
                         alt="{{ $profile->name }}"
                         class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                </div>
                @endif
                
                <div class="p-6">
                    @if($profile->logo)
                    <div class="w-16 h-16 mb-4 rounded-full overflow-hidden border-4 border-white shadow-lg -mt-14 relative z-10">
                        <img src="{{ Storage::url($profile->logo) }}" 
                             alt="{{ $profile->name }}" 
                             class="w-full h-full object-cover">
                    </div>
                    @endif
                    
                    <h3 class="text-xl font-bold text-gray-900 mb-2">{{ $profile->name }}</h3>
                    
                    @if($profile->tagline)
                    <p class="text-sm text-primary font-semibold mb-3">{{ $profile->tagline }}</p>
                    @endif
                    
                    @if($profile->about)
                    <p class="text-gray-600 mb-4 line-clamp-3">{{ Str::limit($profile->about, 120) }}</p>
                    @endif
                    
                    <a href="{{ route('bumnag.show', $profile->slug) }}" 
                       class="inline-flex items-center text-primary font-semibold hover:text-primary-600 transition-colors">
                        Selengkapnya
                        <svg class="w-4 h-4 ml-2 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </a>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <div class="text-center py-12">
            <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                </svg>
            </div>
            <p class="text-gray-500 text-lg">Belum ada unit usaha yang terdaftar</p>
        </div>
        @endif
    </div>
</section>

<!-- Team/Developer Section -->
<section class="py-20 bg-gradient-to-br from-gray-50 to-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4" data-aos="fade-up">
                {{ $settings['about_team_title'] ?? 'Tim Pengembang Website' }}
            </h2>
            <p class="text-lg text-gray-600 max-w-3xl mx-auto" data-aos="fade-up" data-aos-delay="100">
                {{ $settings['about_team_description'] ?? 'Website ini dikembangkan melalui kolaborasi berbagai pihak.' }}
            </p>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-4 gap-8 max-w-5xl mx-auto">
            @for($i = 1; $i <= 4; $i++)
                @php
                    $logoKey = 'about_team_logo_' . $i;
                    $nameKey = 'about_team_name_' . $i;
                    $logo = $settings[$logoKey] ?? '';
                    $name = $settings[$nameKey] ?? 'Tim ' . $i;
                @endphp
                
                <div class="group" data-aos="fade-up" data-aos-delay="{{ ($i - 1) * 100 }}">
                    <div class="bg-white rounded-2xl shadow-lg p-8 hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
                        @if($logo)
                        <div class="w-24 h-24 mx-auto mb-4 flex items-center justify-center">
                            <img src="{{ Storage::url($logo) }}" 
                                 alt="{{ $name }}"
                                 class="max-w-full max-h-full object-contain group-hover:scale-110 transition-transform duration-300">
                        </div>
                        @else
                        <div class="w-24 h-24 mx-auto mb-4 bg-gradient-to-br from-primary to-sage rounded-full flex items-center justify-center">
                            <span class="text-2xl font-bold text-white">{{ substr($name, 0, 2) }}</span>
                        </div>
                        @endif
                        
                        <h3 class="text-center text-sm md:text-base font-semibold text-gray-900">
                            {{ $name }}
                        </h3>
                    </div>
                </div>
            @endfor
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="py-20 bg-gradient-to-r from-primary via-sage to-mint relative overflow-hidden">
    <div class="absolute inset-0 bg-black/10"></div>
    <div class="absolute inset-0" style="background-image: url('data:image/svg+xml,%3Csvg width=&quot;60&quot; height=&quot;60&quot; viewBox=&quot;0 0 60 60&quot; xmlns=&quot;http://www.w3.org/2000/svg&quot;%3E%3Cg fill=&quot;none&quot; fill-rule=&quot;evenodd&quot;%3E%3Cg fill=&quot;%23ffffff&quot; fill-opacity=&quot;0.05&quot;%3E%3Cpath d=&quot;M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z&quot;/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>
    
    <div class="relative max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-3xl md:text-4xl font-bold text-white mb-4" data-aos="fade-up">
            Tertarik Bekerja Sama?
        </h2>
        <p class="text-xl text-white/90 mb-8" data-aos="fade-up" data-aos-delay="100">
            Mari bersama membangun ekonomi nagari yang lebih baik
        </p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center" data-aos="fade-up" data-aos-delay="200">
            <a href="https://wa.me/{{ $globalSettings['contact_whatsapp'] ?? '6281234567890' }}" 
               target="_blank"
               rel="noopener noreferrer"
               class="inline-flex items-center justify-center px-8 py-4 bg-white text-primary font-semibold rounded-full hover:bg-gray-50 transition-all duration-200 shadow-xl hover:shadow-2xl hover:-translate-y-1">
                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/>
                </svg>
                Hubungi Kami
                <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                </svg>
            </a>
            <a href="{{ route('catalogs.index') }}" 
               class="inline-flex items-center justify-center px-8 py-4 bg-transparent border-2 border-white text-white font-semibold rounded-full hover:bg-white hover:text-primary transition-all duration-200 shadow-xl hover:shadow-2xl hover:-translate-y-1">
                Lihat Produk Kami
            </a>
        </div>
    </div>
</section>
@endsection
