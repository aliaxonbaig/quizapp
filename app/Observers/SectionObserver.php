<?php

namespace App\Observers;

use App\Filament\Resources\SectionResource;
use App\Models\Section;
use App\Models\User;
use App\Notifications\SectionCreated;
use App\Notifications\SectionDeleted;
use Filament\Notifications\Actions\Action;
use Filament\Notifications\Notification;

class SectionObserver
{
    public $admins;
    public $section;
    /**
     * Handle the Section "created" event.
     */
    public function created(Section $section): void
    {
        $this->section = $section;

        $this->admins = User::where('is_admin',true)
                              ->where('is_active',true)
                              ->get();

        foreach ($this->admins as $admin){
            $admin->notify(new SectionCreated($section));

            Notification::make()
            ->success()
            ->title('New section created!')
            ->body('A new section named: '. $section->name .' has been created by '. auth()->user()->name .'.')
            ->actions([
                Action::make('view')
                    ->label('View section')
                    ->button()
                    ->url(SectionResource::getUrl('edit', ['record' => $this->section->id]), shouldOpenInNewTab: true),
            ])
            ->sendToDatabase($admin);

        }
    }

    /**
     * Handle the Section "updated" event.
     */
    public function updated(Section $section): void
    {
        //
    }

    /**
     * Handle the Section "deleted" event.
     */
    public function deleted(Section $section): void
    {
        $this->section = $section;

        $this->admins = User::where('is_admin',true)
                              ->where('is_active',true)
                              ->get();

        foreach ($this->admins as $admin){
            $admin->notify(new SectionDeleted($section));

            Notification::make()
            ->success()
            ->title('A section deleted!')
            ->body('A section named: '. $this->section->name .' has been deleted by '. auth()->user()->name .'.')
            ->actions([
                Action::make('view')
                    ->label('View sections')
                    ->button()
                    ->url(SectionResource::getUrl(), shouldOpenInNewTab: true),
            ])
            ->sendToDatabase($admin);

        }
    }

    /**
     * Handle the Section "restored" event.
     */
    public function restored(Section $section): void
    {
        //
    }

    /**
     * Handle the Section "force deleted" event.
     */
    public function forceDeleted(Section $section): void
    {
        //
    }
}
