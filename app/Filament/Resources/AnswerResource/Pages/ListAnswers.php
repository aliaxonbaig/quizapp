<?php

namespace App\Filament\Resources\AnswerResource\Pages;

use App\Filament\Resources\AnswerResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAnswers extends ListRecords
{
    protected static string $resource = AnswerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
