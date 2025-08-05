<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\BroadcastMessage;

class ManualNotification extends Notification implements ShouldBroadcast
{
    use Queueable;

    protected $title;
    protected $content;
    protected $notifiableInstance;

    public function __construct($title, $content)
    {
        $this->title = $title;
        $this->content = $content;
    }

    public function via($notifiable)
    {
        return ['database', 'broadcast', 'mail'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'title' => $this->title,
            'message' => $this->content,
            'source' => auth()->user()->name ?? 'النظام',
            'type' => 'إشعار يدوي',
        ];
    }

    public function toBroadcast($notifiable)
    {
        // حفظ المستخدم الذي سنبث له في خاصية داخل الكلاس
        $this->notifiableInstance = $notifiable;

        return new BroadcastMessage([
            'title' => $this->title,
            'message' => $this->content,
            'source' => auth()->user()->name ?? 'النظام',
            'type' => 'إشعار يدوي',
        ]);
    }


    public function toMail($notifiable)
    {
        return (new \Illuminate\Notifications\Messages\MailMessage)
            ->subject('إشعار جديد من النظام')
            ->line($this->title)
            ->line($this->content)
            ->salutation('مع تحيات فريق كفالة الأيتام');
    }


    public function broadcastOn()
    {
        return ['App.Models.User.' . $this->notifiableInstance->id];
    }
}
