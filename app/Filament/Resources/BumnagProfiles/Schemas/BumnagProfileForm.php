<?php

namespace App\Filament\Resources\BumnagProfiles\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\FileUpload;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Repeater;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class BumnagProfileForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Dasar')
                    ->schema([
                        TextInput::make('name')
                            ->label('Nama BUMNag')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn ($state, callable $set) => $set('slug', Str::slug($state))),
                        
                        TextInput::make('nagari_name')
                            ->label('Nama Nagari')
                            ->required()
                            ->maxLength(255),
                        
                        TextInput::make('slug')
                            ->label('Slug URL')
                            ->maxLength(255)
                            ->unique(ignoreRecord: true)
                            ->helperText('URL otomatis dibuat dari nama BUMNag')
                            ->disabled()
                            ->dehydrated()
                            ->columnSpanFull(),
                        
                        Textarea::make('tagline')
                            ->label('Tagline / Slogan')
                            ->rows(2)
                            ->maxLength(255)
                            ->placeholder('Contoh: Membangun Ekonomi Nagari Bersama')
                            ->columnSpanFull(),
                    ])
                    ->columns(2),
                
                Section::make('Logo & Banner')
                    ->schema([
                        FileUpload::make('logo')
                            ->label('Logo BUMNag')
                            ->image()
                            ->disk('public')
                            ->directory('bumnag/logos')
                            ->visibility('public')
                            ->imageEditor()
                            ->imageEditorAspectRatios(['1:1'])
                            ->maxSize(2048)
                            ->helperText('Upload logo (format: PNG dengan background transparan, max 2MB)'),
                        
                        FileUpload::make('banner')
                            ->label('Banner / Cover')
                            ->image()
                            ->disk('public')
                            ->directory('bumnag/banners')
                            ->visibility('public')
                            ->imageEditor()
                            ->imageEditorAspectRatios(['16:9', '21:9'])
                            ->maxSize(5120)
                            ->helperText('Upload banner untuk header website (max 5MB)'),
                    ])
                    ->columns(2),
                
                Section::make('Galeri Foto')
                    ->schema([
                        FileUpload::make('images')
                            ->label('Foto Galeri')
                            ->image()
                            ->multiple()
                            ->disk('public')
                            ->directory('bumnag/gallery')
                            ->visibility('public')
                            ->imageEditor()
                            ->reorderable()
                            ->maxFiles(10)
                            ->maxSize(3072)
                            ->helperText('Upload hingga 10 foto untuk galeri (max 3MB per foto)')
                            ->columnSpanFull(),
                    ]),
                
                Section::make('Profil Lengkap')
                    ->schema([
                        RichEditor::make('about')
                            ->label('Tentang Kami')
                            ->toolbarButtons(['bold', 'italic', 'bulletList', 'orderedList', 'link'])
                            ->columnSpanFull(),
                        
                        Textarea::make('vision')
                            ->label('Visi')
                            ->rows(3)
                            ->columnSpanFull(),
                        
                        Textarea::make('mission')
                            ->label('Misi')
                            ->rows(5)
                            ->helperText('Tulis setiap poin misi dalam baris baru')
                            ->columnSpanFull(),
                        
                        Textarea::make('values')
                            ->label('Nilai-Nilai (Values)')
                            ->rows(4)
                            ->columnSpanFull(),
                        
                        RichEditor::make('history')
                            ->label('Sejarah')
                            ->toolbarButtons(['bold', 'italic', 'bulletList', 'orderedList', 'link'])
                            ->columnSpanFull(),
                    ])
                    ->collapsed(),
                
                Section::make('Legalitas')
                    ->schema([
                        TextInput::make('legal_entity_number')
                            ->label('Nomor Badan Hukum')
                            ->maxLength(255),
                        
                        DatePicker::make('established_date')
                            ->label('Tanggal Berdiri')
                            ->native(false),
                        
                        TextInput::make('notary_name')
                            ->label('Nama Notaris')
                            ->maxLength(255),
                        
                        TextInput::make('deed_number')
                            ->label('Nomor Akta')
                            ->maxLength(255),
                    ])
                    ->columns(2)
                    ->collapsed(),
                
                Section::make('Alamat & Kontak')
                    ->schema([
                        Textarea::make('address')
                            ->label('Alamat Lengkap')
                            ->rows(3)
                            ->columnSpanFull(),
                        
                        TextInput::make('postal_code')
                            ->label('Kode Pos')
                            ->maxLength(10),
                        
                        TextInput::make('phone')
                            ->label('Telepon')
                            ->tel()
                            ->maxLength(20),
                        
                        TextInput::make('fax')
                            ->label('Fax')
                            ->tel()
                            ->maxLength(20),
                        
                        TextInput::make('email')
                            ->label('Email')
                            ->email()
                            ->maxLength(255),
                        
                        TextInput::make('website')
                            ->label('Website')
                            ->url()
                            ->maxLength(255)
                            ->prefix('https://'),
                    ])
                    ->columns(3),
                
                Section::make('Media Sosial')
                    ->schema([
                        TextInput::make('facebook')
                            ->label('Facebook')
                            ->url()
                            ->maxLength(255)
                            ->prefix('https://'),
                        
                        TextInput::make('instagram')
                            ->label('Instagram')
                            ->url()
                            ->maxLength(255)
                            ->prefix('https://'),
                        
                        TextInput::make('twitter')
                            ->label('Twitter / X')
                            ->url()
                            ->maxLength(255)
                            ->prefix('https://'),
                        
                        TextInput::make('youtube')
                            ->label('YouTube')
                            ->url()
                            ->maxLength(255)
                            ->prefix('https://'),
                        
                        TextInput::make('tiktok')
                            ->label('TikTok')
                            ->url()
                            ->maxLength(255)
                            ->prefix('https://'),
                        
                        TextInput::make('whatsapp')
                            ->label('WhatsApp')
                            ->tel()
                            ->maxLength(20)
                            ->placeholder('628123456789'),
                    ])
                    ->columns(3)
                    ->collapsed(),
                
                Section::make('Lokasi Maps')
                    ->schema([
                        TextInput::make('latitude')
                            ->label('Latitude')
                            ->numeric()
                            ->step(0.0000001)
                            ->placeholder('-0.123456'),
                        
                        TextInput::make('longitude')
                            ->label('Longitude')
                            ->numeric()
                            ->step(0.0000001)
                            ->placeholder('100.123456'),
                        
                        TextInput::make('operating_hours')
                            ->label('Jam Operasional')
                            ->maxLength(255)
                            ->placeholder('Senin-Jumat: 08:00-16:00')
                            ->helperText('Format: Senin-Jumat: 08:00-16:00'),
                    ])
                    ->columns(3)
                    ->collapsed(),
                
                Section::make('Status')
                    ->schema([
                        Toggle::make('is_active')
                            ->label('Profil Aktif')
                            ->required()
                            ->default(true)
                            ->helperText('Centang untuk menampilkan profil di website'),
                    ]),
            ]);
    }
}
