<?php

namespace App\Filament\Resources\Promotions\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\RichEditor;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\Hidden;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class PromotionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Promosi')
                    ->schema([
                        Select::make('category_id')
                            ->label('Kategori')
                            ->relationship('category', 'name', fn ($query) => $query->where('type', 'promotion'))
                            ->searchable()
                            ->preload(),
                        
                        Select::make('promotion_type')
                            ->label('Tipe Promosi')
                            ->required()
                            ->options([
                                'product' => 'Produk',
                                'service' => 'Layanan',
                                'event' => 'Event',
                                'package' => 'Paket',
                            ])
                            ->default('product')
                            ->native(false),
                        
                        TextInput::make('title')
                            ->label('Judul Promosi')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn ($state, callable $set) => $set('slug', Str::slug($state)))
                            ->columnSpanFull(),
                        
                        TextInput::make('slug')
                            ->label('Slug URL')
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true)
                            ->columnSpanFull(),
                        
                        Textarea::make('excerpt')
                            ->label('Ringkasan')
                            ->rows(3)
                            ->maxLength(500)
                            ->columnSpanFull(),
                    ])
                    ->columns(2),
                
                Section::make('Deskripsi Promosi')
                    ->schema([
                        RichEditor::make('description')
                            ->label('Deskripsi Lengkap')
                            ->required()
                            ->toolbarButtons([
                                'attachFiles',
                                'blockquote',
                                'bold',
                                'bulletList',
                                'h2',
                                'h3',
                                'italic',
                                'link',
                                'orderedList',
                                'redo',
                                'strike',
                                'underline',
                                'undo',
                            ])
                            ->fileAttachmentsDisk('public')
                            ->fileAttachmentsDirectory('promotions/attachments')
                            ->columnSpanFull(),
                    ]),
                
                Section::make('Harga & Diskon')
                    ->schema([
                        TextInput::make('original_price')
                            ->label('Harga Normal')
                            ->numeric()
                            ->prefix('Rp')
                            ->live(onBlur: true)
                            ->afterStateUpdated(function ($state, $get, $set) {
                                $discountPrice = $get('discount_price');
                                if ($state && $discountPrice) {
                                    $percentage = (($state - $discountPrice) / $state) * 100;
                                    $set('discount_percentage', round($percentage));
                                }
                            }),
                        
                        TextInput::make('discount_price')
                            ->label('Harga Diskon')
                            ->numeric()
                            ->prefix('Rp')
                            ->live(onBlur: true)
                            ->afterStateUpdated(function ($state, $get, $set) {
                                $originalPrice = $get('original_price');
                                if ($state && $originalPrice) {
                                    $percentage = (($originalPrice - $state) / $originalPrice) * 100;
                                    $set('discount_percentage', round($percentage));
                                }
                            }),
                        
                        TextInput::make('discount_percentage')
                            ->label('Persentase Diskon')
                            ->numeric()
                            ->suffix('%')
                            ->readOnly(),
                    ])
                    ->columns(3),
                
                Section::make('Media')
                    ->schema([
                        FileUpload::make('featured_image')
                            ->label('Gambar Utama')
                            ->image()
                            ->disk('public')
                            ->directory('promotions/featured')
                            ->imageEditor()
                            ->maxSize(2048)
                            ->columnSpanFull(),
                        
                        FileUpload::make('images')
                            ->label('Galeri Gambar')
                            ->image()
                            ->multiple()
                            ->disk('public')
                            ->directory('promotions/gallery')
                            ->reorderable()
                            ->maxSize(2048)
                            ->maxFiles(10)
                            ->columnSpanFull(),
                    ]),
                
                Section::make('Informasi Kontak')
                    ->schema([
                        TextInput::make('contact_person')
                            ->label('Nama Kontak')
                            ->maxLength(255),
                        
                        TextInput::make('contact_phone')
                            ->label('Telepon')
                            ->tel()
                            ->maxLength(20),
                        
                        TextInput::make('contact_email')
                            ->label('Email')
                            ->email()
                            ->maxLength(255),
                        
                        TextInput::make('location')
                            ->label('Lokasi')
                            ->maxLength(255),
                    ])
                    ->columns(2),
                
                Section::make('Periode Promosi')
                    ->schema([
                        DateTimePicker::make('start_date')
                            ->label('Tanggal Mulai')
                            ->native(false),
                        
                        DateTimePicker::make('end_date')
                            ->label('Tanggal Berakhir')
                            ->native(false)
                            ->after('start_date'),
                        
                        Textarea::make('terms_conditions')
                            ->label('Syarat & Ketentuan')
                            ->rows(4)
                            ->columnSpanFull(),
                    ])
                    ->columns(2),
                
                Section::make('Publikasi')
                    ->schema([
                        Select::make('status')
                            ->label('Status')
                            ->required()
                            ->options([
                                'draft' => 'Draft',
                                'active' => 'Aktif',
                                'expired' => 'Kadaluarsa',
                                'archived' => 'Arsip',
                            ])
                            ->default('draft')
                            ->native(false),
                        
                        Toggle::make('is_featured')
                            ->label('Tampilkan di Beranda')
                            ->default(false),
                        
                        Hidden::make('user_id')
                            ->default(auth()->id()),
                        
                        Hidden::make('views')
                            ->default(0),
                    ])
                    ->columns(2),
            ]);
    }
}
