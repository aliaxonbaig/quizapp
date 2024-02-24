<?php

namespace App\Filament\Resources\CertificationResource\Pages;

use App\Filament\Resources\CertificationResource;
use App\Models\User;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use Filament\Notifications\Actions\Action;

class CreateCertification extends CreateRecord
{
    protected static string $resource = CertificationResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = auth()->id();
        return $data;
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
