<?php

namespace App\Filament\Member\Resources\QuizHeaderResource\Pages;

use App\Filament\Member\Resources\QuizHeaderResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditQuizHeader extends EditRecord
{
    protected static string $resource = QuizHeaderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
