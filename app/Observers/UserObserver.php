<?php

namespace App\Observers;

use App\Models\User;
use App\Notifications\UserCreated;
use App\Notifications\UserDeleted;
use Filament\Notifications\Actions\Action;
use Filament\Notifications\Notification;

class UserObserver
{

    public $admins;
    public $user;
    /**
     * Handle events after all transactions are committed.
     *
     * @var bool
     */
    public $afterCommit = true;

    /**
     * Handle the User "created" event.
     */
    public function created(User $user): void
    {
        $this->user = $user;

        $this->admins = User::where('is_admin',true)
                              ->where('is_active',true)
                              ->get();
        if($this->admins->isNotEmpty())
        {
            foreach ($this->admins as $admin){
                $admin->notify(new UserCreated($user, $admin));

                Notification::make()
                ->success()
                ->title('New User created!')
                ->body('A new user named: '. $user->name .' has been created by '. auth()?->user()?->name .'.')
                ->actions([
                    Action::make('view')
                        ->label('View User')
                        ->button()
                        ->url(route('filament.admin.resources.users.edit', $this->user->id), shouldOpenInNewTab: true),
                ])
                ->sendToDatabase($admin);

            }
        }
    }

    /**
     * Handle the User "updated" event.
     */
    public function updated(User $user): void
    {
        //
    }

    /**
     * Handle the User "deleted" event.
     */
    public function deleted(User $user): void
    {
        $this->user = $user;

        $this->admins = User::where('is_admin',true)
                              ->where('is_active',true)
                              ->get();

        foreach ($this->admins as $admin){
            $admin->notify(new UserDeleted($user, $admin));

            Notification::make()
            ->success()
            ->title('A User deleted!')
            ->body('A user named: '. $user->name .' has been deleted by '. auth()->user()->name .'.')
            ->actions([
                Action::make('view')
                    ->label('View Users')
                    ->button()
                    ->url(route('filament.admin.resources.users.index'), shouldOpenInNewTab: true),
            ])
            ->sendToDatabase($admin);

        }
    }

    /**
     * Handle the User "restored" event.
     */
    public function restored(User $user): void
    {
        //
    }

    /**
     * Handle the User "force deleted" event.
     */
    public function forceDeleted(User $user): void
    {
        //
    }
}
