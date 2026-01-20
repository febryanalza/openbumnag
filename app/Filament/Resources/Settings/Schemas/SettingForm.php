<?php

namespace App\Filament\Resources\Settings\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Hidden;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class SettingForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Setting')
                    ->description('Konfigurasi setting website')
                    ->schema([
                        TextInput::make('key')
                            ->label('Key/Kunci')
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true)
                            ->helperText('Format: snake_case (contoh: site_name, hero_title)')
                            ->disabled(fn ($record) => $record !== null),
                        
                        Select::make('group')
                            ->label('Grup')
                            ->required()
                            ->options([
                                'general' => 'Umum',
                                'hero' => 'Hero Section',
                                'about' => 'Tentang Kami',
                                'news' => 'Berita',
                                'reports' => 'Laporan',
                                'contact' => 'Kontak',
                                'social' => 'Media Sosial',
                                'seo' => 'SEO',
                            ])
                            ->default('general')
                            ->searchable(),
                        
                        Select::make('type')
                            ->label('Tipe Data')
                            ->required()
                            ->options([
                                'text' => 'Text',
                                'textarea' => 'Textarea',
                                'number' => 'Number',
                                'boolean' => 'Boolean',
                                'json' => 'JSON',
                            ])
                            ->default('text')
                            ->reactive(),
                        
                        TextInput::make('order')
                            ->label('Urutan')
                            ->numeric()
                            ->default(0)
                            ->helperText('Urutan tampilan (semakin kecil semakin atas)'),
                    ])
                    ->columns(2),
                
                Section::make('Nilai Setting')
                    ->description('Masukkan nilai untuk setting ini')
                    ->schema([
                        Textarea::make('value')
                            ->label('Nilai')
                            ->required()
                            ->rows(5)
                            ->columnSpanFull()
                            ->helperText(fn ($get) => match ($get('type')) {
                                'boolean' => 'Masukkan: true atau false',
                                'number' => 'Masukkan angka',
                                'json' => 'Masukkan format JSON yang valid',
                                default => 'Masukkan teks',
                            }),
                        
                        Textarea::make('description')
                            ->label('Deskripsi')
                            ->rows(2)
                            ->maxLength(500)
                            ->helperText('Deskripsi singkat tentang setting ini')
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}

