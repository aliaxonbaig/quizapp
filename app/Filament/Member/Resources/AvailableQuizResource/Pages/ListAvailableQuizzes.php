<?php

namespace App\Filament\Member\Resources\AvailableQuizResource\Pages;

use App\Filament\Member\Resources\AvailableQuizResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAvailableQuizzes extends ListRecords
{
    protected static string $resource = AvailableQuizResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
