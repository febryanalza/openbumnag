<?php

namespace App\Filament\Resources\Galleries\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\FileUpload;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Hidden;
use Filament\Schemas\Schema;

class GalleryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Galeri')
                    ->schema([
                        TextInput::make('title')
                            ->label('Judul')
                            ->required()
                            ->maxLength(255)
                            ->columnSpanFull(),
                        
                        Textarea::make('description')
                            ->label('Deskripsi')
                            ->rows(3)
                            ->maxLength(500)
                            ->columnSpanFull(),
                    ]),
                
                Section::make('Upload Media')
                    ->schema([
                        FileUpload::make('file_path')
                            ->label('File')
                            ->required()
                            ->disk('public')
                            ->directory('galleries')
                            ->visibility('public')
                            ->acceptedFileTypes(['image/*', 'video/*'])
                            ->maxSize(10240)
                            ->image()
                            ->imageEditor()
                            ->imageEditorAspectRatios([
                                '16:9',
                                '4:3',
                                '1:1',
                            ])
                            ->helperText('Upload gambar/video (max 10MB)')
                            ->columnSpanFull(),
                        
                        Hidden::make('mime_type'),
                        Hidden::make('file_size'),
                        Hidden::make('user_id')
                            ->default(fn () => auth()->id()),
                    ]),
                
                Section::make('Kategori & Album')
                    ->schema([
                        Select::make('file_type')
                            ->label('Tipe File')
                            ->required()
                            ->options([
                                'image' => 'Gambar',
                                'video' => 'Video',
                            ])
                            ->default('image')
                            ->native(false),
                        
                        Select::make('type')
                            ->label('Kategori')
                            ->required()
                            ->options([
                                'gallery' => 'Galeri Umum',
                                'event' => 'Event',
                                'activity' => 'Kegiatan',
                                'product' => 'Produk',
                            ])
                            ->default('gallery')
                            ->native(false),
                        
                        TextInput::make('album')
                            ->label('Album')
                            ->maxLength(255)
                            ->placeholder('Nama album/koleksi'),
                    ])
                    ->columns(3),
                
                Section::make('Detail Tambahan')
                    ->schema([
                        DatePicker::make('taken_date')
                            ->label('Tanggal Pengambilan')
                            ->native(false),
                        
                        TextInput::make('photographer')
                            ->label('Fotografer')
                            ->maxLength(255),
                        
                        TextInput::make('location')
                            ->label('Lokasi')
                            ->maxLength(255),
                    ])
                    ->columns(3)
                    ->collapsed(),
                
                Section::make('Pengaturan')
                    ->schema([
                        Toggle::make('is_featured')
                            ->label('Tampilkan di Beranda')
                            ->default(false)
                            ->helperText('Centang untuk menampilkan di galeri utama'),
                        
                        TextInput::make('order')
                            ->label('Urutan Tampil')
                            ->numeric()
                            ->default(0)
                            ->minValue(0),
                        
                        Hidden::make('views')
                            ->default(0),
                    ])
                    ->columns(2),
            ]);
    }
}
