<?php

namespace App\Filament\Resources\BumnagProfiles;

use App\Filament\Resources\BumnagProfiles\Pages\CreateBumnagProfile;
use App\Filament\Resources\BumnagProfiles\Pages\EditBumnagProfile;
use App\Filament\Resources\BumnagProfiles\Pages\ListBumnagProfiles;
use App\Filament\Resources\BumnagProfiles\Schemas\BumnagProfileForm;
use App\Filament\Resources\BumnagProfiles\Tables\BumnagProfilesTable;
use App\Models\BumnagProfile;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class BumnagProfileResource extends Resource
{
    protected static ?string $model = BumnagProfile::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBuildingOffice2;

    protected static ?string $navigationLabel = 'Profil BUMNag';

    protected static ?string $modelLabel = 'Profil BUMNag';

    protected static ?string $pluralModelLabel = 'Profil BUMNag';

    protected static ?int $navigationSort = 1;

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return BumnagProfileForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return BumnagProfilesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListBumnagProfiles::route('/'),
            'create' => CreateBumnagProfile::route('/create'),
            'edit' => EditBumnagProfile::route('/{record}/edit'),
        ];
    }
}

