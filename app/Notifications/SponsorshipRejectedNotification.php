<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Broadcasting\PrivateChannel;

class SponsorshipRejectedNotification extends Notification implements ShouldQueue, ShouldBroadcast
{
    use Queueable;

    protected $notifiableInstance;

    public function __construct()
    {
        //
    }

    public function via($notifiable): array
    {
        return ['database', 'broadcast', 'mail'];
    }

    public function toArray($notifiable): array
    {
        return [
            'title' => 'تم رفض الكفالة',
            'message' => 'نأسف، لم يتم قبول طلب الكفالة الخاص بك.',
            'type' => 'رفض كفالة',
        ];
    }

    public function toBroadcast($notifiable): BroadcastMessage
    {
        $this->notifiableInstance = $notifiable;

        return new BroadcastMessage([
            'title' => 'تم رفض الكفالة',
            'message' => 'نأسف، لم يتم قبول طلب الكفالة الخاص بك.',
            'type' => 'رفض كفالة',
        ]);
    }

    public function broadcastOn(): PrivateChannel
    {
        return new PrivateChannel('App.Models.User.' . $this->notifiableInstance->id);
    }

    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('رفض طلب الكفالة')
            ->greeting('مرحباً ' . $notifiable->name)
            ->line('نأسف لإبلاغك بأنه لم يتم قبول طلب الكفالة الذي تقدمت به.')
            ->line('نقدّر اهتمامك ورغبتك في الكفالة، ونشجعك على التقديم مرة أخرى.')
            ->action('زيارة الموقع', url('/'))
            ->line('شكراً لك على دعمك.');
    }
}
