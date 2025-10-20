<?php

namespace App\Filament\Member\Resources\AvailableQuizResource\Pages;

use App\Filament\Member\Resources\AvailableQuizResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAvailableQuiz extends EditRecord
{
    protected static string $resource = AvailableQuizResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
