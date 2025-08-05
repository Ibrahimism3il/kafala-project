<?php

namespace App\Http\Controllers;

use App\Notifications\PaymentNotification;
use App\Models\Payment;
use App\Models\User;
use App\Models\Sponsorship;
use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Checkout\Session as StripeSession;

class PaymentController extends Controller
{

    // تعرض صفحة إدارة المدفوعات في لوحة تحكم المدير
    // تجلب جميع المدفوعات مع بيانات المستخدم والكفالة واليتيم المرتبط بالكفالة
    // (ملاحظة: تم جلب $candidates لكن لم يتم استخدامه في الـ view)
    public function index()
    {
        $candidates = \App\Models\CandidateSponsorship::with(['donor', 'orphan'])
            ->where('status', 'قيد الانتظار') // ✅ فقط "قيد الانتظار"
            ->get();
        $payments = Payment::with(['user', 'sponsorship.orphan'])->get();
        return view('admin.paymentsManagement', compact('payments'));
    }


    // تعتمد لقبول عملية دفع معينة عبر ID
    // تقوم بتحديث حالة الدفع إلى "مكتمل"
    // ترسل إشعار للمستخدم مرة واحدة فقط إذا لم يكن قد أُرسل مسبقًا
    public function accept($id)
    {
        $payment = Payment::findOrFail($id);
        $payment->update(['status' => 'مكتمل']);

        // إرسال إشعار إذا لم يكن قد أرسل من قبل
        if ($payment->user && !$payment->notified) {
            $payment->user->notify(new PaymentNotification($payment));
            $payment->update(['notified' => true]);
        }

        return back()->with('success', 'تم قبول الدفع.');
    }


    // تُستخدم لرفض دفعة محددة من خلال رقم المعرف (ID)
    // تقوم بتحديث حالة الدفع إلى "غير مستوفي"
    // ثم تعود للصفحة السابقة برسالة نجاح
    public function reject($id)
    {
        $payment = Payment::findOrFail($id);
        $payment->update(['status' => 'غير مستوفي']);
        return back()->with('success', 'تم رفض الدفع.');
    }


    // تُستخدم لإرسال إشعار يدوي إلى الكافل المرتبط بعملية الدفع المحددة
    // تتحقق أولًا من أن الإشعار لم يُرسل من قبل، ثم تُرسله وتحدث الحقل 'notified' ليصبح true
    public function notify($id)
    {
        $payment = Payment::with('user')->findOrFail($id);
        $donor = $payment->user;

        if ($donor && !$payment->notified) {
            $donor->notify(new PaymentNotification($payment));
            $payment->update(['notified' => true]);
        }

        return back()->with('success', 'تم إرسال الإشعار للكافل بنجاح.');
    }


    // تُستخدم لإنشاء جلسة دفع باستخدام Stripe لعملية دفع كفالة محددة
    // تعتمد على Stripe Checkout وتُرسل المستخدم إلى صفحة الدفع الآمنة الخاصة بـ Stripe
    // بعد الدفع، يتم توجيه المستخدم إلى رابط النجاح أو الإلغاء حسب الحالة

    public function createStripeSession(Request $request)
    {
        $payment = Payment::findOrFail($request->payment_id);
        $user = $payment->user;

        Stripe::setApiKey(env('STRIPE_SECRET'));

        $session = StripeSession::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'usd',
                    'unit_amount' => $payment->amount * 100,
                    'product_data' => [
                        'name' => 'Sponsorship Payment',
                    ],
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => route('payment.success', ['payment_id' => $payment->id]),
            'cancel_url' => route('payment.cancel', ['payment_id' => $payment->id]),
        ]);

        return response()->json(['id' => $session->id]);
    }


    // تعالج هذه الدالة عملية النجاح بعد الدفع عبر Stripe
    // تُحدث حالة الدفع، تنشئ الكفالة، ترسل إشعارات للكافل والمدير، وتحدث حالة اليتيم
    public function stripeSuccess(Request $request)
    {
        $payment = Payment::findOrFail($request->payment_id);

        // تحديث حالة الدفع
        $payment->update([
            'status' => 'مكتمل',
            'payment_date' => now(),
        ]);

        // إشعار الكافل
        if ($payment->user && !$payment->notified) {
            $payment->user->notify(new PaymentNotification($payment));
            $payment->update(['notified' => true]);
        }

        // إشعار المدير
        $admin = User::where('email', 'admin@example.com')->first();
        if ($admin) {
            $admin->notify(new \App\Notifications\PaymentConfirmedNotification(
                $payment->user->name,
                $payment->amount,
                $payment->payment_date
            ));
        }

        // جلب الترشيح المقبول
        $candidate = \App\Models\CandidateSponsorship::where('donor_id', $payment->user_id)
            ->where('status', 'مقبول')
            ->latest()
            ->first();

        if ($candidate) {
            // إنشاء الكفالة وربطها بالدفع
            $sponsorship = Sponsorship::create([
                'kafel_id' => $candidate->donor_id,
                'orphan_id' => $candidate->orphan_id,
                'type' => 'مالية',
                'amount' => $payment->amount,
                'start_date' => now(),
                'status' => 'نشطة'
            ]);

            // ربط الدفع بالكفالة الجديدة
            $payment->update([
                'sponsorship_id' => $sponsorship->id
            ]);

            // تحديث حالة اليتيم في جدول orphans
            \App\Models\Orphan::where('id', $candidate->orphan_id)
                ->update(['sponsorship_status' => 'مكفول']);

            // تحديث حالة المستخدم (اليتيم) في جدول users
            $orphan = \App\Models\Orphan::find($candidate->orphan_id);
            if ($orphan && $orphan->user_id) {
                \App\Models\User::where('id', $orphan->user_id)
                    ->update(['sponsorship_status' => 'مكفول']);
            }

            // حذف الترشيح من جدول candidate_sponsorships
            $candidate->delete();
        }

        return redirect()->route('kafel.dashboard')->with('success', 'تم الدفع بنجاح وتم إنشاء الكفالة.');
    }




    // تُستخدم هذه الدالة لمعالجة حالتين:
    // 1. إلغاء الدفع عبر Stripe (stripeCancel)
    // 2. عرض صفحة الدفع للكافل (checkoutPage)

    public function stripeCancel(Request $request)
    {
        return redirect()->route('kafel.dashboard')->with('success', 'تم الدفع بنجاح.');
    }

    public function checkoutPage($paymentId)
    {
        $payment = Payment::findOrFail($paymentId);
        return view('kafel.payment-checkout', compact('payment'));
    }


    // تُستخدم هذه الدالة لمعالجة صفحة النجاح بعد الدفع عبر Stripe (في حال استخدام session_id للتحقق)
    public function success(Request $request)
    {
        $sessionId = $request->get('session_id');
        $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));
        $session = $stripe->checkout->sessions->retrieve($sessionId);

        // استرجع معرف الدفع (لو خزّنت الـ session_id في قاعدة البيانات يمكنك تحديث الدفع بناءً عليه)
        $payment = Payment::where('id', $session->metadata->payment_id)->first();

        if ($payment) {
            $payment->status = 'مكتمل';
            $payment->payment_date = now();
            $payment->save();

            // يمكنك إرسال إشعار هنا إذا أردت
        }

        return view('payment.success'); // صفحة نجاح مخصصة
    }


    // هذه الدالة تُستخدم لعرض صفحة إدخال مبلغ الدفع لكفالة مرشح تم قبوله مسبقًا
    public function create(Request $request)
    {
        $candidateId = $request->candidate_id;
        $candidate = \App\Models\CandidateSponsorship::with('orphan')->findOrFail($candidateId);

        if ($candidate->status !== 'مقبول') {
            return redirect()->back()->with('error', 'لا يمكن الدفع إلا للمرشحين المقبولين فقط.');
        }

        return view('kafel.enter-amount', compact('candidate'));
    }


    // هذه الدالة تُستخدم لإنشاء سجل دفع جديد بناءً على ترشيح مقبول، ثم توجيه المستخدم لصفحة الدفع (Checkout)
    public function prepare(Request $request)
    {
        $request->validate([
            'candidate_id' => 'required|exists:candidate_sponsorships,id', // يجب أن يكون الترشيح موجودًا
            'amount' => 'required|numeric|min:1',                         // المبلغ يجب أن يكون رقمي وأكبر من 1
            'method' => 'required|string'                                 // وسيلة الدفع مطلوبة
        ]);

        $candidate = \App\Models\CandidateSponsorship::findOrFail($request->candidate_id);

        $payment = \App\Models\Payment::create([
            'user_id' => auth()->id(),
            'amount' => $request->amount,
            'method' => $request->method,
            'status' => 'قيد الانتظار',   // إلى حين الدفع أو التحقق اليدوي
            'candidate_id' => $candidate->id, // إذا عندك هذا الحقل في جدول payments
            'payment_date' => now(),
            'notified' => false,
        ]);

        return redirect()->route('payment.checkoutPage', ['payment' => $payment->id]);
    }
}
