<?php

namespace App\Filament\Resources\Reports\Pages;

use App\Filament\Resources\Reports\ReportResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\Action;
use Filament\Resources\Pages\EditRecord;

class EditReport extends EditRecord
{
    protected static string $resource = ReportResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
            Action::make('preview')
                ->label('Preview')
                ->icon('heroicon-o-eye')
                ->color('gray')
                ->url(fn () => route('reports.show', ['slug' => $this->record->slug]))
                ->openUrlInNewTab(),
        ];
    }

    protected function getFormActions(): array
    {
        return [
            ...parent::getFormActions(),
            Action::make('preview')
                ->label('Preview')
                ->icon('heroicon-o-eye')
                ->color('gray')
                ->action(function () {
                    // Use $this->data instead of $this->form->getState() to avoid validation
                    $data = $this->data;
                    $url = route('reports.preview', ['slug' => $this->record->slug, 'data' => base64_encode(json_encode($data))]);
                    
                    // Open in new tab using JavaScript
                    $this->js("window.open('$url', '_blank')");
                })
                ->requiresConfirmation(false),
        ];
    }
}

