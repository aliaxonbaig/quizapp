<?php

namespace App\Filament\Member\Resources\MyQuizzesResource\Pages;

use App\Filament\Member\Resources\MyQuizzesResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditMyQuizzes extends EditRecord
{
    protected static string $resource = MyQuizzesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
