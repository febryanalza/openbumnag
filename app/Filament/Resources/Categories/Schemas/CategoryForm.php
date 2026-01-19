<?php

namespace App\Filament\Resources\Categories\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\ColorPicker;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class CategoryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                // Informasi Kategori
                TextInput::make('name')
                            ->label('Nama Kategori')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn ($state, callable $set) => $set('slug', Str::slug($state))),
                        
                        TextInput::make('slug')
                            ->label('Slug URL')
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true),
                        
                        Select::make('type')
                            ->label('Tipe Kategori')
                            ->required()
                            ->options([
                                'general' => 'Umum',
                                'news' => 'Berita',
                                'report' => 'Laporan',
                                'promotion' => 'Promosi',
                            ])
                            ->default('general')
                            ->native(false),
                        
                        Textarea::make('description')
                            ->label('Deskripsi')
                            ->rows(3)
                            ->maxLength(500)
                            ->columnSpanFull(),
                                    // Tampilan
                TextInput::make('icon')
                            ->label('Icon')
                            ->helperText('Nama icon Heroicon (contoh: heroicon-o-folder)'),
                        
                        ColorPicker::make('color')
                            ->label('Warna'),
                        
                        TextInput::make('order')
                            ->label('Urutan')
                            ->required()
                            ->numeric()
                            ->default(0)
                            ->minValue(0),
                        
                        Toggle::make('is_active')
                            ->label('Aktif')
                            ->default(true),
                                ]);
    }
}

