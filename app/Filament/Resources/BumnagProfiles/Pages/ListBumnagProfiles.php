<?php

namespace App\Filament\Resources\BumnagProfiles\Pages;

use App\Filament\Resources\BumnagProfiles\BumnagProfileResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListBumnagProfiles extends ListRecords
{
    protected static string $resource = BumnagProfileResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}

