<?php

namespace App\Filament\Member\Resources\SubscriptionsResource\Pages;

use App\Filament\Member\Resources\SubscriptionsResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSubscriptions extends EditRecord
{
    protected static string $resource = SubscriptionsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
