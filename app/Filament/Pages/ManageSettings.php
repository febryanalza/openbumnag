<?php

namespace App\Filament\Pages;

use App\Helpers\SettingHelper;
use App\Models\Setting;
use BackedEnum;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Exceptions\Halt;
use Filament\Support\Icons\Heroicon;

class ManageSettings extends Page implements HasForms
{
    use InteractsWithForms;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCog6Tooth;

    protected string $view = 'filament.pages.manage-settings';

    protected static ?string $navigationLabel = 'Kelola Pengaturan';

    protected static ?string $title = 'Kelola Pengaturan Website';

    protected static ?int $navigationSort = 100;

    public ?array $data = [];

    public static function canAccess(): bool
    {
        return auth()->user()->can('setting.view-any');
    }

    public function mount(): void
    {
        abort_unless(auth()->user()->can('setting.view-any'), 403);
        
        $this->form->fill($this->getSettingsData());
    }

    protected function getSettingsData(): array
    {
        $settings = Setting::all()->pluck('value', 'key')->toArray();
        
        // Decode JSON for hero_images
        if (isset($settings['hero_images'])) {
            $settings['hero_images'] = json_decode($settings['hero_images'], true) ?? [];
        }
        
        return $settings;
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                // General Settings
                Section::make('Pengaturan Umum')
                    ->description('Pengaturan dasar website')
                    ->schema([
                        TextInput::make('site_name')
                            ->label('Nama Website')
                            ->required()
                            ->maxLength(255)
                            ->helperText('Nama BUMNag yang akan ditampilkan di website'),
                        
                        TextInput::make('site_tagline')
                            ->label('Tagline')
                            ->maxLength(255)
                            ->helperText('Tagline atau slogan website'),
                        
                        Textarea::make('site_description')
                            ->label('Deskripsi Website')
                            ->rows(3)
                            ->maxLength(500)
                            ->helperText('Deskripsi website untuk SEO dan meta description'),
                    ])
                    ->columns(2),
                
                // Hero Section  
                Section::make('Hero Section')
                    ->description('Pengaturan bagian hero/banner utama')
                    ->schema([
                        FileUpload::make('hero_images')
                            ->label('Gambar Hero Slider')
                            ->image()
                            ->multiple()
                            ->maxFiles(10)
                            ->reorderable()
                            ->directory('hero-images')
                            ->disk('public')
                            ->visibility('public')
                            ->helperText('Upload maksimal 10 gambar untuk hero slider. Drag untuk mengurutkan.')
                            ->columnSpanFull(),
                        
                        TextInput::make('hero_title')
                            ->label('Judul Utama')
                            ->required()
                            ->maxLength(255)
                            ->helperText('Judul besar di hero section'),
                        
                        TextInput::make('hero_subtitle')
                            ->label('Sub-judul (Highlight)')
                            ->required()
                            ->maxLength(255)
                            ->helperText('Sub-judul yang akan di-highlight dengan warna'),
                        
                        Textarea::make('hero_description')
                            ->label('Deskripsi')
                            ->required()
                            ->rows(3)
                            ->maxLength(500)
                            ->helperText('Deskripsi di bawah judul hero'),
                        
                        TextInput::make('hero_max_slides')
                            ->label('Maksimal Jumlah Slide Ditampilkan')
                            ->numeric()
                            ->default(5)
                            ->minValue(1)
                            ->maxValue(10)
                            ->helperText('Maksimal gambar yang ditampilkan di slider dari gambar yang di-upload (1-10)'),
                        
                        TextInput::make('hero_autoplay_duration')
                            ->label('Durasi Autoplay (ms)')
                            ->numeric()
                            ->default(5000)
                            ->minValue(1000)
                            ->maxValue(10000)
                            ->suffix('ms')
                            ->helperText('Durasi pergantian slide otomatis (1000ms = 1 detik)'),
                    ])
                    ->columns(2),
                
                // About Section
                Section::make('Unit Usaha')
                    ->description('Pengaturan bagian unit usaha/profil BUMNag')
                    ->schema([
                        TextInput::make('about_title')
                            ->label('Judul Section')
                            ->required()
                            ->maxLength(255)
                            ->default('Unit Usaha Kami'),
                        
                        Textarea::make('about_description')
                            ->label('Deskripsi Section')
                            ->required()
                            ->rows(2)
                            ->maxLength(500)
                            ->default('Berbagai unit usaha yang kami kelola'),
                    ])
                    ->columns(1),
                
                // News Section
                Section::make('Berita')
                    ->description('Pengaturan bagian berita di homepage')
                    ->schema([
                        TextInput::make('news_title')
                            ->label('Judul Section')
                            ->required()
                            ->maxLength(255)
                            ->default('Berita Terbaru'),
                        
                        Textarea::make('news_description')
                            ->label('Deskripsi Section')
                            ->required()
                            ->rows(2)
                            ->maxLength(500)
                            ->default('Informasi dan update terkini'),
                        
                        TextInput::make('news_homepage_limit')
                            ->label('Jumlah Berita di Homepage')
                            ->numeric()
                            ->default(6)
                            ->minValue(3)
                            ->maxValue(12)
                            ->suffix('berita')
                            ->helperText('Jumlah berita yang ditampilkan di homepage (3-12)'),
                    ])
                    ->columns(2),
                
                // Reports Section
                Section::make('Laporan')
                    ->description('Pengaturan bagian laporan di homepage')
                    ->schema([
                        TextInput::make('reports_title')
                            ->label('Judul Section')
                            ->required()
                            ->maxLength(255)
                            ->default('Laporan & Transparansi'),
                        
                        Textarea::make('reports_description')
                            ->label('Deskripsi Section')
                            ->required()
                            ->rows(2)
                            ->maxLength(500)
                            ->default('Laporan keuangan dan kegiatan'),
                        
                        TextInput::make('reports_homepage_limit')
                            ->label('Jumlah Laporan di Homepage')
                            ->numeric()
                            ->default(6)
                            ->minValue(3)
                            ->maxValue(12)
                            ->suffix('laporan')
                            ->helperText('Jumlah laporan yang ditampilkan di homepage (3-12)'),
                    ])
                    ->columns(2),
                
                // CTA Section
                Section::make('Call to Action')
                    ->description('Pengaturan bagian call-to-action di homepage')
                    ->schema([
                        TextInput::make('cta_title')
                            ->label('Judul CTA')
                            ->required()
                            ->maxLength(255)
                            ->default('Mari Berkembang Bersama'),
                        
                        Textarea::make('cta_description')
                            ->label('Deskripsi CTA')
                            ->required()
                            ->rows(2)
                            ->maxLength(500)
                            ->default('Bergabunglah dengan kami dalam membangun ekonomi nagari'),
                    ])
                    ->columns(1),
                
                // Contact Section
                Section::make('Kontak')
                    ->description('Data kontak untuk footer dan halaman kontak')
                    ->schema([
                        Textarea::make('contact_address')
                            ->label('Alamat')
                            ->rows(2)
                            ->maxLength(500)
                            ->columnSpanFull(),
                        
                        TextInput::make('contact_phone')
                            ->label('Telepon')
                            ->tel()
                            ->maxLength(50),
                        
                        TextInput::make('contact_email')
                            ->label('Email')
                            ->email()
                            ->maxLength(255),
                        
                        TextInput::make('contact_whatsapp')
                            ->label('WhatsApp')
                            ->tel()
                            ->maxLength(50)
                            ->helperText('Format: 6281234567890 (dengan kode negara)'),
                    ])
                    ->columns(2),
                
                // Social Media Section
                Section::make('Media Sosial')
                    ->description('URL media sosial untuk footer dan share buttons')
                    ->schema([
                        TextInput::make('social_facebook')
                            ->label('Facebook')
                            ->url()
                            ->maxLength(255)
                            ->placeholder('https://facebook.com/username'),
                        
                        TextInput::make('social_instagram')
                            ->label('Instagram')
                            ->url()
                            ->maxLength(255)
                            ->placeholder('https://instagram.com/username'),
                        
                        TextInput::make('social_twitter')
                            ->label('Twitter/X')
                            ->url()
                            ->maxLength(255)
                            ->placeholder('https://twitter.com/username'),
                        
                        TextInput::make('social_youtube')
                            ->label('YouTube')
                            ->url()
                            ->maxLength(255)
                            ->placeholder('https://youtube.com/@username'),
                    ])
                    ->columns(2),
                
                // Kodai/Catalog Section
                Section::make('Kodai (Katalog Produk)')
                    ->description('Pengaturan bagian katalog produk di homepage')
                    ->schema([
                        TextInput::make('catalog_title')
                            ->label('Judul Section')
                            ->maxLength(255)
                            ->default('Kodai Kami')
                            ->helperText('Judul section katalog di homepage'),
                        
                        Textarea::make('catalog_description')
                            ->label('Deskripsi')
                            ->rows(2)
                            ->maxLength(500)
                            ->default('Produk-produk berkualitas dari unit usaha kami')
                            ->helperText('Deskripsi section katalog'),
                        
                        TextInput::make('catalog_homepage_limit')
                            ->label('Jumlah di Homepage')
                            ->numeric()
                            ->default(6)
                            ->minValue(3)
                            ->maxValue(12)
                            ->helperText('Jumlah katalog yang ditampilkan di homepage (3-12)'),
                    ])
                    ->columns(2),
            ])
            ->statePath('data');
    }

    public function save(): void
    {
        abort_unless(auth()->user()->can('setting.update'), 403);
        
        try {
            $data = $this->form->getState();

            foreach ($data as $key => $value) {
                if ($value !== null) {
                    // Convert array to JSON for hero_images
                    if ($key === 'hero_images' && is_array($value)) {
                        $value = json_encode($value);
                    }
                    
                    Setting::updateOrCreate(
                        ['key' => $key],
                        ['value' => $value]
                    );
                }
            }

            // Clear settings cache
            SettingHelper::clearCache();

            Notification::make()
                ->success()
                ->title('Berhasil')
                ->body('Pengaturan website berhasil disimpan.')
                ->send();
        } catch (Halt $exception) {
            return;
        }
    }
}
