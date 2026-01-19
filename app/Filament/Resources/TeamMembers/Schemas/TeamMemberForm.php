<?php

namespace App\Filament\Resources\TeamMembers\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\FileUpload;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class TeamMemberForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Anggota Tim')
                    ->schema([
                        TextInput::make('name')
                            ->label('Nama Lengkap')
                            ->required()
                            ->maxLength(255),
                        
                        TextInput::make('position')
                            ->label('Jabatan')
                            ->required()
                            ->maxLength(255),
                        
                        TextInput::make('division')
                            ->label('Divisi')
                            ->maxLength(255),
                        
                        Textarea::make('bio')
                            ->label('Biografi')
                            ->rows(4)
                            ->maxLength(1000)
                            ->columnSpanFull(),
                    ])
                    ->columns(2),
                
                Section::make('Foto Profil')
                    ->schema([
                        FileUpload::make('photo')
                            ->label('Foto')
                            ->image()
                            ->disk('public')
                            ->directory('team-members')
                            ->visibility('public')
                            ->imageEditor()
                            ->imageEditorAspectRatios([
                                '1:1',
                                '4:3',
                            ])
                            ->maxSize(2048)
                            ->helperText('Upload foto profil (max 2MB, format: JPG, PNG)')
                            ->columnSpanFull(),
                    ]),
                
                Section::make('Kontak & Media Sosial')
                    ->schema([
                        TextInput::make('email')
                            ->label('Email')
                            ->email()
                            ->maxLength(255),
                        
                        TextInput::make('phone')
                            ->label('Telepon')
                            ->tel()
                            ->maxLength(20),
                        
                        TextInput::make('facebook')
                            ->label('Facebook URL')
                            ->url()
                            ->maxLength(255)
                            ->prefix('https://'),
                        
                        TextInput::make('instagram')
                            ->label('Instagram URL')
                            ->url()
                            ->maxLength(255)
                            ->prefix('https://'),
                        
                        TextInput::make('twitter')
                            ->label('Twitter URL')
                            ->url()
                            ->maxLength(255)
                            ->prefix('https://'),
                        
                        TextInput::make('linkedin')
                            ->label('LinkedIn URL')
                            ->url()
                            ->maxLength(255)
                            ->prefix('https://'),
                    ])
                    ->columns(2),
                
                Section::make('Pengaturan')
                    ->schema([
                        TextInput::make('order')
                            ->label('Urutan Tampil')
                            ->required()
                            ->numeric()
                            ->default(0)
                            ->minValue(0)
                            ->helperText('Semakin kecil angka, semakin awal ditampilkan'),
                        
                        Toggle::make('is_active')
                            ->label('Aktif')
                            ->required()
                            ->default(true),
                    ])
                    ->columns(2),
            ]);
    }
}
