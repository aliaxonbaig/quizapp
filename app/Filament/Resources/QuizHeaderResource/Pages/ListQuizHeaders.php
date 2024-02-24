<?php

namespace App\Filament\Resources\QuizHeaderResource\Pages;

use App\Filament\Resources\QuizHeaderResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListQuizHeaders extends ListRecords
{
    protected static string $resource = QuizHeaderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
