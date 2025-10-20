<?php

namespace App\Filament\Resources\QuizApprovalRequestResource\Pages;

use App\Filament\Resources\QuizApprovalRequestResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditQuizApprovalRequest extends EditRecord
{
    protected static string $resource = QuizApprovalRequestResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
