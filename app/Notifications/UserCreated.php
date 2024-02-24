<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Filament\Resources\UserResource;

class UserCreated extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(public User $user, public User $admin,)
    {
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $url = route('filament.admin.resources.users.edit', $this->user->id);

        return (new MailMessage)
                    ->subject('An new user **'.$this->user->name.'** has been created!')
                    ->greeting('Good Day ' .$this->admin->name.'!')
                    ->line('A new user with name **'.$this->user->name.'** has been created')
                    ->action('Review User', $url)
                    ->line('Thank you and have a great day');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
