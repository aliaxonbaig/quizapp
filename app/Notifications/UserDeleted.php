<?php

namespace App\Notifications;

use App\Filament\Resources\UserResource;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class UserDeleted extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(public User $user, public User $admin,)
    {
        //
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
        $url = UserResource::getUrl();
        return (new MailMessage)
                    ->subject('An existing user **'.$this->user->name.'** deleted!')
                    ->greeting('Good Day ' .$this->admin->name.'!')
                    ->line('An existing user named **'.$this->user->name.'** has been deleted')
                    ->action('Review Users', $url)
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
