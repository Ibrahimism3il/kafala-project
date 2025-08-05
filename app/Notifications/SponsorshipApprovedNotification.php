<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Broadcasting\PrivateChannel;

class SponsorshipApprovedNotification extends Notification implements ShouldBroadcast
{
    use Queueable;

    protected $donorName;
    protected $sponsorshipId;
    protected $type;
    protected $notifiableInstance;

    public function __construct($donorName, $sponsorshipId, $type)
    {
        $this->donorName = $donorName;
        $this->sponsorshipId = $sponsorshipId;
        $this->type = $type;
    }

    public function via($notifiable): array
    {
        return ['database', 'broadcast', 'mail'];
    }

    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('تمت الموافقة على الكفالة')
            ->greeting('مرحبًا ' . $notifiable->name)
            ->line('تهانينا! تم قبولك من الكافل: ' . $this->donorName)
            ->line('رقم الكفالة: #' . $this->sponsorshipId)
            ->action('عرض الكفالة', url('/orphan/sponsorships/' . $this->sponsorshipId))
            ->line('نتمنى لك حياة كريمة وآمنة.');
    }

    public function toArray($notifiable)
    {
        return [
            'title' => 'تمت الموافقة على الكفالة',
            'message' => 'تهانينا! تم قبولك من الكافل: ' . $this->donorName,
            'type' => 'موافقة كفالة',
            'sponsorship_id' => $this->sponsorshipId,
            'status' => 'نشطة',
        ];
    }

    public function toBroadcast($notifiable)
    {
        $this->notifiableInstance = $notifiable;

        return new BroadcastMessage([
            'title' => 'تمت الموافقة على الكفالة',
            'message' => 'تهانينا! تم قبولك من الكافل: ' . $this->donorName,
            'type' => 'موافقة كفالة',
            'sponsorship_id' => $this->sponsorshipId,
            'status' => 'نشطة',
        ]);
    }

    public function broadcastOn()
    {
        return new PrivateChannel('App.Models.User.' . $this->notifiableInstance->id);
    }
}
