<?php

namespace App\Notifications;

use App\Filament\Resources\CertificationResource;
use App\Models\Certification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CertificationCreated extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(public Certification $certification,)
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
        $url = CertificationResource::getUrl('edit', ['record' => $this->certification->id]);
        return (new MailMessage)
                    ->subject('An new certification created!')
                    ->greeting('Good Day!')
                    ->line('An new certification named **'.$this->certification->name.'** has been created')
                    ->action('Review Certification', $url)
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
