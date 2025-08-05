<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\Payment;
use App\Models\User;
use App\Notifications\SponsorshipApprovedNotification;
use App\Notifications\SponsorshipRequestNotification;
use App\Notifications\SponsorshipAcceptedNotification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $notifications = $user->notifications;

        return view('notifications.index', compact('notifications'));
    }

    public function __construct()
    {
        // تأكد من أن المستخدم مسجل دخول
        $this->middleware('auth');
    }

    /**
     * تحديد الإشعار كمقروء
     */
    public function markAsRead($id)
    {
        $notification = auth()->user()->notifications()->findOrFail($id);
        $notification->markAsRead();

        return redirect()->back()->with('success', 'تم تحديد الإشعار كمقروء.');
    }

    /**
     * حذف الإشعار
     */
    public function destroy($id)
    {
        $notification = auth()->user()->notifications()->findOrFail($id);
        $notification->delete();

        return redirect()->back()->with('success', 'تم حذف الإشعار.');
    }

    /**
     * إرسال إشعار للكافل بأن الكفالة تمت الموافقة عليها
     */
    public function notifyKafel($paymentId)
    {
        $payment = Payment::findOrFail($paymentId);
        $donor = $payment->donor;
        $sponsorship = $payment->sponsorship;
        $orphan = $sponsorship->orphan;

        // إشعار الكافل
        $donor->notify(new SponsorshipApprovedNotification(
            $orphan->name,
            $payment->id,
            $sponsorship->type,
            $sponsorship->id
        ));

        // إشعار اليتيم
        if ($orphan->user) {
            $orphan->user->notify(new SponsorshipAcceptedNotification(
                $orphan->name,
                $sponsorship->id,
                $sponsorship->type
            ));
        }

        // إشعار المدير
        $admin = User::where('role', 'admin')->first();
        if ($admin) {
            $admin->notify(new SponsorshipRequestNotification($donor, $orphan, $sponsorship));
        }

        return redirect()->back()->with('success', 'تم إرسال الإشعارات بنجاح');
    }


    // تعرض جميع الإشعارات الخاصة بالكافل الحالي من جدول notifications
    // بعد تصفيتها حسب معرفه ونوعه، مع ترتيبها من الأحدث إلى الأقدم.

    public function notifications()
    {
        $notifications = Notification::where('receiver_id', auth()->id())
            ->where('receiver_type', 'kafel') // أو 'orphan'
            ->latest()->get();
        return view('kafel.notifications', compact('notifications'));
    }


    // تعلم كل الإشعارات غير المقروءة للمستخدم الحالي بأنها مقروءة دفعة واحدة.
    public function markAllAsRead()
    {
        auth()->user()->unreadNotifications->markAsRead();
        return redirect()->back()->with('success', 'تم تعليم جميع الإشعارات كمقروءة.');
    }
}
