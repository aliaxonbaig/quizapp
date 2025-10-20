<?php

namespace App\Filament\Member\Resources\CertificationResource\Pages;

use App\Filament\Member\Resources\CertificationResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCertifications extends ListRecords
{
    protected static string $resource = CertificationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
