<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Broadcasting\PrivateChannel;

class PaymentNotification extends Notification implements ShouldBroadcast
{
    use Queueable;

    public $payment;
    protected $notifiableInstance;

    public function __construct($payment)
    {
        $this->payment = $payment;
    }

    public function via($notifiable)
    {
        return ['database', 'mail', 'broadcast'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->greeting('مرحبًا ' . $notifiable->name)
            ->line('تم تسجيل دفعتك بنجاح.')
            ->line('رقم المعاملة: #' . $this->payment->id)
            ->line('المبلغ: $' . $this->payment->amount)
            ->line('شكراً لك على دعمك.')
            ->action('عرض التفاصيل', url('/kafel/dashboard'));
    }

    public function toArray($notifiable)
    {
        return [
            'title' => 'تم تسجيل دفعة جديدة',
            'message' => 'تم تسجيل دفعة جديدة بقيمة $' . $this->payment->amount,
            'source' => 'النظام',
            'type' => 'دفعة',
        ];
    }

    public function toBroadcast($notifiable)
    {
        $this->notifiableInstance = $notifiable;

        return new BroadcastMessage([
            'title' => 'تم تسجيل دفعة جديدة',
            'message' => 'تم تسجيل دفعة جديدة بقيمة $' . $this->payment->amount,
            'source' => 'النظام',
            'type' => 'دفعة',
        ]);
    }

    public function broadcastOn()
    {
        return new PrivateChannel('App.Models.User.' . $this->notifiableInstance->id);
    }
}
