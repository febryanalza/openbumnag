<?php

namespace App\Filament\Resources\BumnagProfiles\Pages;

use App\Filament\Resources\BumnagProfiles\BumnagProfileResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditBumnagProfile extends EditRecord
{
    protected static string $resource = BumnagProfileResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}

