<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Broadcasting\PrivateChannel;

class SponsorshipRequestNotification extends Notification implements ShouldBroadcast
{
    use Queueable;

    protected $donor;
    protected $orphan;
    protected $sponsorship;
    protected $notifiableInstance;

    public function __construct($donor, $orphan, $sponsorship)
    {
        $this->donor = $donor;
        $this->orphan = $orphan;
        $this->sponsorship = $sponsorship;
    }

    public function via($notifiable)
    {
        return ['database', 'broadcast', 'mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('طلب كفالة جديد')
            ->greeting("السيد/ة {$notifiable->name}")
            ->line("تم تقديم طلب كفالة جديد لليتيم: {$this->orphan->name}")
            ->line("الكافل: {$this->donor->name}")
            ->action('عرض الطلب', url('/admin/sponsorships/' . $this->sponsorship->id))
            ->line('يرجى مراجعة الطلب واتخاذ الإجراء المناسب.');
    }

    public function toArray($notifiable)
    {
        return [
            'title' => 'طلب كفالة جديد',
            'message' => "السيد/ المدير، تم تقديم طلب كفالة جديد لليتيم {$this->orphan->name} من قِبل الكافل {$this->donor->name}.",
            'type' => 'طلب كفالة',
            'source' => 'نظام',
            'sponsorship' => [
                'id' => $this->sponsorship->id,
                'orphan' => $this->orphan->name,
                'type' => $this->sponsorship->type,
            ],
        ];
    }

    public function toBroadcast($notifiable)
    {
        $this->notifiableInstance = $notifiable;

        return new BroadcastMessage([
            'title' => 'طلب كفالة جديد',
            'message' => "السيد/ المدير، تم تقديم طلب كفالة جديد لليتيم {$this->orphan->name} من قِبل الكافل {$this->donor->name}.",
            'type' => 'طلب كفالة',
            'source' => 'نظام',
            'sponsorship' => [
                'id' => $this->sponsorship->id,
                'orphan' => $this->orphan->name,
                'type' => $this->sponsorship->type,
            ],
        ]);
    }

    public function broadcastOn()
    {
        return new PrivateChannel('App.Models.User.' . $this->notifiableInstance->id);
    }
}
