<?php

namespace App\Observers;

use App\Filament\Resources\CertificationResource;
use App\Models\Certification;
use App\Models\User;
use App\Notifications\CertificationCreated;
use Filament\Notifications\Actions\Action;
use Filament\Notifications\Notification;

class CertificationObserver
{
    public $admins;
    public $certification;
    /**
     * Handle the Certification "created" event.
     */
    public function created(Certification $certification): void
    {
        $this->certification = $certification;

        $this->admins = User::where('is_admin',true)
                              ->where('is_active',true)
                              ->get();

        foreach ($this->admins as $admin){
            $admin->notify(new CertificationCreated($certification));

            Notification::make()
            ->success()
            ->title('New certification created!')
            ->body('A new certification named: '. $this->certification->name .' has been created by '. auth()->user()->name .'.')
            ->actions([
                Action::make('view')
                    ->label('View certification')
                    ->button()
                    ->url(CertificationResource::getUrl('edit', ['record' => $this->certification->id]), shouldOpenInNewTab: true),
            ])
            ->sendToDatabase($admin);
            }
    }

    /**
     * Handle the Certification "updated" event.
     */

    public function updated(Certification $certification): void
    {
        //
    }

    /**
     * Handle the Certification "deleted" event.
     */
    public function deleted(Certification $certification): void
    {
        $this->certification = $certification;

        $this->admins = User::where('is_admin',true)
                              ->where('is_active',true)
                              ->get();

        foreach ($this->admins as $admin){
            $admin->notify(new CertificationCreated($certification));

            Notification::make()
            ->success()
            ->title('A certification deleted!')
            ->body('A certification named: '. $this->certification->name .' has been deleted by '. auth()->user()->name .'.')
            ->actions([
                Action::make('view')
                    ->label('View certifications')
                    ->button()
                    ->url(CertificationResource::getUrl(), shouldOpenInNewTab: true),
            ])
            ->sendToDatabase($admin);
            }
    }

    /**
     * Handle the Certification "restored" event.
     */
    public function restored(Certification $certification): void
    {
        //
    }

    /**
     * Handle the Certification "force deleted" event.
     */
    public function forceDeleted(Certification $certification): void
    {
        //
    }
}
