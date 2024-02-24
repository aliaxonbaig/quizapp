<?php

namespace App\Notifications;

use App\Filament\Resources\UserResource;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class BirthDayWish extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(public User $user,)
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
                    ->subject('Birthday wishes from Us!')
                    ->greeting('Happy Birthday!')
                    ->line('Dear **'.$this->user->name.'**')
                    ->line('Wish you a very happy birthday, many many more!')
                    ->action('Visit Us', $url)
                    ->line('Thank you and have a great day!');
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
