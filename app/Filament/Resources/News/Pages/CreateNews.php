<?php

namespace App\Filament\Resources\News\Pages;

use App\Filament\Resources\News\NewsResource;
use Filament\Actions\Action;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Str;

class CreateNews extends CreateRecord
{
    protected static string $resource = NewsResource::class;

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
                    $slug = !empty($data['slug']) ? $data['slug'] : Str::slug($data['title'] ?? 'preview');
                    $url = route('news.preview', ['slug' => $slug, 'data' => base64_encode(json_encode($data))]);
                    
                    // Open in new tab using JavaScript
                    $this->js("window.open('$url', '_blank')");
                })
                ->requiresConfirmation(false),
        ];
    }
}

