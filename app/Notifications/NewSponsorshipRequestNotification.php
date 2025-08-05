<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\DatabaseMessage;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Broadcasting\PrivateChannel;

class NewSponsorshipRequestNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $donorName;
    protected $orphanName;
    protected $sponsorshipId;

    public function __construct($donorName, $orphanName, $sponsorshipId)
    {
        $this->donorName = $donorName;
        $this->orphanName = $orphanName;
        $this->sponsorshipId = $sponsorshipId;
    }

    public function via($notifiable)
    {
        return ['database', 'broadcast', 'mail'];
    }


    public function toDatabase($notifiable)
    {
        return [
            'title' => 'طلب كفالة جديد',
            'message' => 'الكافل ' . $this->donorName . ' طلب كفالة اليتيم ' . $this->orphanName,
            'type' => 'طلب كفالة',
            'source' => 'كافل',
            'sponsorship' => [
                'id' => $this->sponsorshipId,
                'orphan' => $this->orphanName,
                'type' => 'جديدة'
            ],
        ];
    }

    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage([
            'title' => 'طلب كفالة جديد',
            'message' => 'الكافل ' . $this->donorName . ' طلب كفالة اليتيم ' . $this->orphanName,
            'type' => 'طلب كفالة',
            'source' => 'كافل',
            'sponsorship' => [
                'id' => $this->sponsorshipId,
                'orphan' => $this->orphanName,
                'type' => 'جديدة'
            ],
        ]);
    }

    public function toMail($notifiable)
    {
        return (new \Illuminate\Notifications\Messages\MailMessage)
            ->subject('طلب كفالة جديد')
            ->line('الكافل ' . $this->donorName . ' طلب كفالة اليتيم ' . $this->orphanName)
            ->action('عرض الطلب', url('/admin/sponsorships/' . $this->sponsorshipId))
            ->salutation('مع تحيات فريق كفالة الأيتام');
    }


    public function broadcastOn()
    {
        return new PrivateChannel('App.Models.User.' . 1); // بدّل 1 بـ ID المدير الحقيقي إن أردت
    }
}
