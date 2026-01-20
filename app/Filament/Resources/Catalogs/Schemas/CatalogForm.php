<?php

namespace App\Filament\Resources\Catalogs\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\KeyValue;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Grid;
use Filament\Forms\Components\Hidden;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class CatalogForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Produk')
                    ->description('Isi informasi dasar produk katalog')
                    ->schema([
                        Select::make('bumnag_profile_id')
                            ->label('Unit Usaha')
                            ->relationship('bumnagProfile', 'name')
                            ->required()
                            ->searchable()
                            ->preload()
                            ->helperText('Pilih unit usaha yang menjual produk ini'),
                        
                        TextInput::make('name')
                            ->label('Nama Produk')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn ($state, callable $set) => $set('slug', Str::slug($state))),
                        
                        TextInput::make('slug')
                            ->label('Slug URL')
                            ->maxLength(255)
                            ->unique(ignoreRecord: true)
                            ->helperText('URL otomatis dibuat dari nama produk')
                            ->disabled()
                            ->dehydrated(),
                        
                        TextInput::make('sku')
                            ->label('SKU')
                            ->maxLength(255)
                            ->helperText('Stock Keeping Unit (kode produk)')
                            ->unique(ignoreRecord: true),
                        
                        Select::make('category')
                            ->label('Kategori')
                            ->options([
                                'Makanan & Minuman' => 'Makanan & Minuman',
                                'Pertanian' => 'Pertanian',
                                'Perikanan' => 'Perikanan',
                                'Peternakan' => 'Peternakan',
                                'Kerajinan' => 'Kerajinan',
                                'Jasa' => 'Jasa',
                                'Lainnya' => 'Lainnya',
                            ])
                            ->searchable()
                            ->native(false)
                            ->helperText('Pilih kategori produk'),
                        
                        Textarea::make('description')
                            ->label('Deskripsi Singkat')
                            ->rows(3)
                            ->maxLength(500)
                            ->helperText('Deskripsi singkat produk (maks. 500 karakter)')
                            ->columnSpanFull(),
                    ])
                    ->columns(2),
                
                Section::make('Harga & Stok')
                    ->description('Atur harga dan ketersediaan produk')
                    ->schema([
                        TextInput::make('price')
                            ->label('Harga')
                            ->numeric()
                            ->prefix('Rp')
                            ->maxValue(999999999999)
                            ->helperText('Kosongkan jika harga hubungi kami'),
                        
                        TextInput::make('unit')
                            ->label('Satuan')
                            ->maxLength(50)
                            ->helperText('Contoh: kg, pcs, liter, dus, dll')
                            ->placeholder('kg'),
                        
                        TextInput::make('stock')
                            ->label('Stok')
                            ->numeric()
                            ->default(0)
                            ->minValue(0)
                            ->required()
                            ->helperText('Jumlah stok tersedia'),
                        
                        Toggle::make('is_available')
                            ->label('Tersedia')
                            ->helperText('Status ketersediaan produk')
                            ->default(true),
                        
                        Toggle::make('is_featured')
                            ->label('Produk Unggulan')
                            ->helperText('Tampilkan di halaman utama')
                            ->default(false),
                    ])
                    ->columns(2),
                
                Section::make('Detail Produk')
                    ->description('Informasi detail dan spesifikasi produk')
                    ->schema([
                        RichEditor::make('description')
                            ->label('Deskripsi Lengkap')
                            ->toolbarButtons([
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
                            ->helperText('Deskripsi lengkap tentang produk')
                            ->columnSpanFull(),
                        
                        KeyValue::make('specifications')
                            ->label('Spesifikasi')
                            ->keyLabel('Nama Spesifikasi')
                            ->valueLabel('Nilai')
                            ->reorderable()
                            ->addActionLabel('Tambah Spesifikasi')
                            ->helperText('Contoh: Berat - 1kg, Ukuran - 10x20cm, dll')
                            ->columnSpanFull(),
                    ]),
                
                Section::make('Media')
                    ->description('Upload gambar produk')
                    ->schema([
                        FileUpload::make('featured_image')
                            ->label('Gambar Utama')
                            ->image()
                            ->disk('public')
                            ->directory('catalogs/featured')
                            ->visibility('public')
                            ->imageEditor()
                            ->imageEditorAspectRatios([
                                '1:1',
                                '4:3',
                                '16:9',
                            ])
                            ->maxSize(2048)
                            ->helperText('Gambar utama produk (maks. 2MB)')
                            ->columnSpanFull(),
                        
                        FileUpload::make('images')
                            ->label('Galeri Gambar')
                            ->image()
                            ->multiple()
                            ->disk('public')
                            ->directory('catalogs/gallery')
                            ->visibility('public')
                            ->reorderable()
                            ->imageEditor()
                            ->maxSize(2048)
                            ->maxFiles(10)
                            ->helperText('Upload hingga 10 gambar untuk galeri produk')
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}
