<?php

namespace App\Filament\Member\Resources\SubscriptionsResource\Pages;

use App\Filament\Member\Resources\SubscriptionsResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;

class ListSubscriptions extends ListRecords
{
    protected static string $resource = SubscriptionsResource::class;


    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
