<?php

namespace App\Filament\Resources\Reports\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Select;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Hidden;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class ReportForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                // Informasi Laporan
                Select::make('category_id')
                            ->label('Kategori')
                            ->relationship('category', 'name', fn ($query) => $query->where('type', 'report'))
                            ->searchable()
                            ->preload(),
                        
                        TextInput::make('title')
                            ->label('Judul Laporan')
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
                        
                        Textarea::make('description')
                            ->label('Deskripsi')
                            ->rows(3)
                            ->maxLength(500)
                            ->columnSpanFull(),
                                    // Periode Laporan
                Select::make('type')
                            ->label('Tipe Laporan')
                            ->required()
                            ->options([
                                'financial' => 'Keuangan',
                                'activity' => 'Kegiatan',
                                'annual' => 'Tahunan',
                                'monthly' => 'Bulanan',
                                'quarterly' => 'Triwulan',
                            ])
                            ->default('financial')
                            ->native(false)
                            ->live(),
                        
                        TextInput::make('year')
                            ->label('Tahun')
                            ->required()
                            ->numeric()
                            ->minValue(2000)
                            ->maxValue(2100)
                            ->default(date('Y')),
                        
                        Select::make('month')
                            ->label('Bulan')
                            ->options([
                                1 => 'Januari', 2 => 'Februari', 3 => 'Maret',
                                4 => 'April', 5 => 'Mei', 6 => 'Juni',
                                7 => 'Juli', 8 => 'Agustus', 9 => 'September',
                                10 => 'Oktober', 11 => 'November', 12 => 'Desember',
                            ])
                            ->native(false)
                            ->visible(fn ($get) => in_array($get('type'), ['monthly'])),
                        
                        Select::make('quarter')
                            ->label('Triwulan')
                            ->options([
                                1 => 'Triwulan 1 (Jan-Mar)',
                                2 => 'Triwulan 2 (Apr-Jun)',
                                3 => 'Triwulan 3 (Jul-Sep)',
                                4 => 'Triwulan 4 (Okt-Des)',
                            ])
                            ->native(false)
                            ->visible(fn ($get) => in_array($get('type'), ['quarterly'])),
                        
                        TextInput::make('period')
                            ->label('Periode')
                            ->required()
                            ->helperText('Contoh: 2024, Q1-2024, Jan-2024')
                            ->columnSpanFull(),
                                    // File Laporan
                FileUpload::make('file_path')
                            ->label('File Laporan')
                            ->disk('public')
                            ->directory('reports/files')
                            ->acceptedFileTypes(['application/pdf', 'application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'])
                            ->maxSize(10240)
                            ->helperText('Upload file PDF, Excel, atau Word (maks. 10MB)')
                            ->columnSpanFull(),
                        
                        FileUpload::make('cover_image')
                            ->label('Gambar Cover')
                            ->image()
                            ->disk('public')
                            ->directory('reports/covers')
                            ->imageEditor()
                            ->maxSize(2048)
                            ->columnSpanFull(),
                    
                // Konten Laporan
                RichEditor::make('content')
                            ->label('Konten')
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
                                'table',
                                'undo',
                            ])
                            ->fileAttachmentsDisk('public')
                            ->fileAttachmentsDirectory('reports/attachments')
                            ->columnSpanFull(),
                    
                // Publikasi
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
                            ->label('Tanggal Publikasi')
                            ->native(false),
                        
                        Hidden::make('user_id')
                            ->default(auth()->id()),
                        
                        Hidden::make('downloads')
                            ->default(0),
                                ]);
    }
}

