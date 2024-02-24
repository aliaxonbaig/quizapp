<?php

namespace App\Filament\Resources\DomainResource\Pages;

use App\Filament\Resources\DomainResource;
use App\Models\User;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;

class CreateDomain extends CreateRecord
{
    protected static string $resource = DomainResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = auth()->id();
        return $data;
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getCreatedNotification(): ?Notification
    {

        $recipients = User::where('is_admin',true)->get();

        return Notification::make()
            ->success()
            ->title('Domain created')
            ->body('The new domain '. $this->getRecord('name').' has been created successfully.')
            ->actions([
                Action::make('view')
                    ->button()
                    ->url(route('filament.admin.resources.domains.edit', $this->getRecord()), shouldOpenInNewTab: true),
            ])
            ->sendToDatabase($recipients);
    }
}
