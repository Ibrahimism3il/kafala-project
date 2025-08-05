<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Broadcasting\PrivateChannel;

class PaymentConfirmedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $donorName;
    protected $amount;
    protected $paymentDate;

    public function __construct($donorName, $amount, $paymentDate)
    {
        $this->donorName = $donorName;
        $this->amount = $amount;
        $this->paymentDate = $paymentDate;
    }

 public function via($notifiable)
{
    return ['database', 'broadcast', 'mail'];
}

    public function toArray($notifiable)
    {
        return [
            'title' => 'تم تأكيد الدفع من الكافل',
            'message' => "الكافل {$this->donorName} دفع مبلغ {$this->amount} بتاريخ {$this->paymentDate->format('Y-m-d')}.",
            'type' => 'دفع كفالة',
            'source' => 'نظام',
        ];
    }

    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage([
            'title' => 'تم تأكيد الدفع من الكافل',
            'message' => "الكافل {$this->donorName} دفع مبلغ {$this->amount} بتاريخ {$this->paymentDate->format('Y-m-d')}.",
            'type' => 'دفع كفالة',
            'source' => 'نظام',
        ]);
    }

    public function toMail($notifiable)
{
    return (new \Illuminate\Notifications\Messages\MailMessage)
        ->subject('تأكيد الدفع من الكافل')
        ->line("الكافل {$this->donorName} دفع مبلغ {$this->amount} بتاريخ {$this->paymentDate->format('Y-m-d')}.")
        ->action('عرض تفاصيل الدفع', url('/admin/payments')) // أو أي رابط مناسب
        ->salutation('مع تحيات فريق كفالة الأيتام');
}

    public function broadcastOn()
    {
        return new PrivateChannel('App.Models.User.' . $this->resolveAdminId());
    }

    protected function resolveAdminId()
    {
        // إذا عندك مدير ثابت:
        return 1;

        // أو استرجاع أول مدير من الـ users مثلاً:
        // return \App\Models\User::where('role', 'admin')->first()?->id ?? 1;
    }
}

