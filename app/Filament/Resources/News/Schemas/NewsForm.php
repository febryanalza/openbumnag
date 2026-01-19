<?php

namespace App\Filament\Resources\News\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\RichEditor;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Fieldset;
use Filament\Schemas\Components\Grid;
use Filament\Forms\Components\Hidden;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class NewsForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Utama')
                    ->description('Isi informasi dasar berita')
                    ->schema([
                        Select::make('category_id')
                            ->label('Kategori')
                            ->relationship('category', 'name', fn ($query) => $query->where('type', 'news'))
                            ->searchable()
                            ->preload()
                            ->createOptionForm([
                                TextInput::make('name')
                                    ->label('Nama Kategori')
                                    ->required()
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(fn ($state, callable $set) => $set('slug', Str::slug($state))),
                                TextInput::make('slug')
                                    ->label('Slug')
                                    ->required()
                                    ->unique(ignoreRecord: true),
                                Select::make('type')
                                    ->label('Tipe')
                                    ->options([
                                        'general' => 'Umum',
                                        'news' => 'Berita',
                                    ])
                                    ->default('news'),
                            ]),
                        
                        TextInput::make('title')
                            ->label('Judul Berita')
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
                            ->helperText('URL-friendly versi dari judul')
                            ->columnSpanFull(),
                        
                        Textarea::make('excerpt')
                            ->label('Ringkasan')
                            ->rows(3)
                            ->maxLength(500)
                            ->helperText('Ringkasan singkat berita (maks. 500 karakter)')
                            ->columnSpanFull(),
                    ])
                    ->columns(2),
                
                Section::make('Konten Berita')
                    ->description('Tulis konten berita lengkap dengan gambar')
                    ->schema([
                        RichEditor::make('content')
                            ->label('Konten')
                            ->required()
                            ->toolbarButtons([
                                'attachFiles',
                                'blockquote',
                                'bold',
                                'bulletList',
                                'codeBlock',
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
                            ->fileAttachmentsDirectory('news/attachments')
                            ->fileAttachmentsVisibility('public')
                            ->helperText('Anda dapat menambahkan gambar dengan mengklik tombol attachment. Gambar dapat ditempatkan di mana saja dalam konten.')
                            ->columnSpanFull(),
                    ]),
                
                Section::make('Media')
                    ->description('Upload gambar utama dan gambar tambahan')
                    ->schema([
                        FileUpload::make('featured_image')
                            ->label('Gambar Utama')
                            ->image()
                            ->disk('public')
                            ->directory('news/featured')
                            ->imageEditor()
                            ->imageEditorAspectRatios([
                                '16:9',
                                '4:3',
                                '1:1',
                            ])
                            ->maxSize(2048)
                            ->helperText('Gambar utama yang akan ditampilkan di halaman utama (maks. 2MB)')
                            ->columnSpanFull(),
                        
                        FileUpload::make('images')
                            ->label('Galeri Gambar')
                            ->image()
                            ->multiple()
                            ->disk('public')
                            ->directory('news/gallery')
                            ->reorderable()
                            ->imageEditor()
                            ->maxSize(2048)
                            ->maxFiles(10)
                            ->helperText('Upload hingga 10 gambar tambahan untuk galeri')
                            ->columnSpanFull(),
                    ]),
                
                Section::make('Publikasi')
                    ->description('Atur status dan waktu publikasi')
                    ->schema([
                        Select::make('status')
                            ->label('Status')
                            ->required()
                            ->options([
                                'draft' => 'Draft',
                                'published' => 'Terbit',
                                'archived' => 'Arsip',
                            ])
                            ->default('draft')
                            ->native(false),
                        
                        DateTimePicker::make('published_at')
                            ->label('Waktu Publikasi')
                            ->helperText('Kosongkan untuk publikasi langsung')
                            ->native(false),
                        
                        Toggle::make('is_featured')
                            ->label('Tampilkan di Beranda')
                            ->helperText('Berita akan ditampilkan di slider beranda')
                            ->default(false),
                        
                        Hidden::make('user_id')
                            ->default(fn () => auth()->id()),
                        
                        Hidden::make('views')
                            ->default(0),
                    ])
                    ->columns(2),
                
                Section::make('SEO')
                    ->description('Optimasi untuk mesin pencari')
                    ->schema([
                        TextInput::make('meta_title')
                            ->label('Meta Title')
                            ->maxLength(60)
                            ->helperText('Judul untuk SEO (maks. 60 karakter)')
                            ->columnSpanFull(),
                        
                        Textarea::make('meta_description')
                            ->label('Meta Description')
                            ->rows(3)
                            ->maxLength(160)
                            ->helperText('Deskripsi untuk SEO (maks. 160 karakter)')
                            ->columnSpanFull(),
                        
                        Textarea::make('meta_keywords')
                            ->label('Meta Keywords')
                            ->rows(2)
                            ->helperText('Kata kunci dipisahkan dengan koma')
                            ->columnSpanFull(),
                    ])
                    ->collapsible()
                    ->collapsed(),
            ]);
    }
}

