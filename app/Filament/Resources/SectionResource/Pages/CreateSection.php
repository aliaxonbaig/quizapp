<?php

namespace App\Filament\Resources\SectionResource\Pages;

use App\Filament\Resources\SectionResource;
use App\Models\User;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use Filament\Notifications\Actions\Action;

class CreateSection extends CreateRecord
{
    protected static string $resource = SectionResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = auth()->id();
        return $data;
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    // protected function getCreatedNotification(): ?Notification
    // {

    //     // $recipients = User::where('is_admin',true)->get();
    //     // $section = $this->getRecord();
    //     // return Notification::make()
    //     //     ->success()
    //     //     ->title('New Section created')
    //     //     ->body('A new section with name: **'. $section->name .'** has been created by User: '. auth()->user()->name .'.')
    //     //     ->actions([
    //     //         Action::make('view')
    //     //             ->label('View Section')
    //     //             ->button()
    //     //             ->url(route('filament.admin.resources.sections.edit', $this->getRecord()), shouldOpenInNewTab: true),
    //     //     ])
    //     //     ->sendToDatabase($recipients);
    // }

}
