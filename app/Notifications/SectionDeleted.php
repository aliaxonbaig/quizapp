<?php

namespace App\Notifications;

use App\Filament\Resources\SectionResource;
use App\Models\Section;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SectionDeleted extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(public Section $section,)
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
        $url = SectionResource::getUrl();
        return (new MailMessage)
                    ->subject('An existing section deleted!')
                    ->greeting('Good Day!')
                    ->line('An existing section named **'.$this->section->name.'** has been deleted')
                    ->action('Review Sections', $url)
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
