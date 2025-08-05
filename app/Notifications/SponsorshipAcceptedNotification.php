<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Broadcasting\PrivateChannel;

class SponsorshipAcceptedNotification extends Notification implements ShouldQueue, ShouldBroadcast
{
    use Queueable;

    protected $orphanName, $sponsorshipId, $type;
    protected $notifiableUser;

    public function __construct($orphanName, $sponsorshipId, $type)
    {
        $this->orphanName = $orphanName;
        $this->sponsorshipId = $sponsorshipId;
        $this->type = $type;
    }

    public function via($notifiable)
    {
        return ['database', 'broadcast', 'mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('تمت الموافقة على الكفالة')
            ->greeting('مرحبًا ' . $notifiable->name)
            ->line("تمت الموافقة على كفالتك لليتيم {$this->orphanName}.")
            ->line("رقم الكفالة: #{$this->sponsorshipId}")
            ->line('شكراً لك على دعمك.')
            ->action('عرض الكفالة', url('/kafel/sponsorships/' . $this->sponsorshipId));
    }

    public function toArray($notifiable)
    {
        return [
            'title' => 'تمت الموافقة على الكفالة',
            'message' => 'تمت الموافقة على كفالة اليتيم: ' . $this->orphanName,
            'type' => 'موافقة كفالة',
            'sponsorship_id' => $this->sponsorshipId,
            'status' => 'نشطة',
        ];
    }

    public function toBroadcast($notifiable)
    {
        $this->notifiableUser = $notifiable;

        return new BroadcastMessage([
            'title' => 'تمت الموافقة على الكفالة',
            'message' => 'تمت الموافقة على كفالة اليتيم: ' . $this->orphanName,
            'type' => 'موافقة كفالة',
            'sponsorship_id' => $this->sponsorshipId,
            'status' => 'نشطة',
        ]);
    }

    public function broadcastOn()
    {
        return new PrivateChannel('App.Models.User.' . $this->notifiableUser->id);
    }
}
