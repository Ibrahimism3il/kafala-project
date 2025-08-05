<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Broadcasting\PrivateChannel;

class SponsorshipRenewalReminder extends Notification implements ShouldQueue, ShouldBroadcast
{
    use Queueable;

    protected $sponsorshipId;
    protected $expiresAt;
    protected $notifiableInstance;

    public function __construct($sponsorshipId, $expiresAt)
    {
        $this->sponsorshipId = $sponsorshipId;
        $this->expiresAt = $expiresAt;
    }

    public function via(object $notifiable): array
    {
        return ['mail', 'database', 'broadcast'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->greeting('مرحباً ' . $notifiable->name)
            ->line('نذكرك بتجديد كفالتك التي ستنتهي بتاريخ: ' . $this->expiresAt)
            ->action('تجديد الكفالة', url('/kafel/sponsorships/' . $this->sponsorshipId))
            ->line('شكراً لدعمك المستمر.');
    }

    public function toArray(object $notifiable): array
    {
        return [
            'title' => 'تذكير بتجديد الكفالة',
            'message' => 'ستنتهي كفالتك قريباً بتاريخ: ' . $this->expiresAt,
            'type' => 'تجديد كفالة',
            'sponsorship_id' => $this->sponsorshipId,
        ];
    }

    public function toBroadcast($notifiable)
    {
        $this->notifiableInstance = $notifiable;

        return new BroadcastMessage([
            'title' => 'تذكير بتجديد الكفالة',
            'message' => 'ستنتهي كفالتك قريباً بتاريخ: ' . $this->expiresAt,
            'type' => 'تجديد كفالة',
            'sponsorship_id' => $this->sponsorshipId,
        ]);
    }

    public function broadcastOn()
    {
        return new PrivateChannel('App.Models.User.' . $this->notifiableInstance->id);
    }
}
