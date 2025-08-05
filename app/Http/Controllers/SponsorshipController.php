<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Sponsorship;
use App\Models\User;
use App\Models\Orphan;
use Illuminate\Http\Request;
use App\Notifications\SponsorshipRequestNotification;
use App\Notifications\SponsorshipAcceptedNotification;
use App\Notifications\NewSponsorshipRequestNotification;
use App\Models\CandidateSponsorship;

class SponsorshipController extends Controller
{

    // هذه الدالة تُستخدم لعرض جميع الكفالات الحالية وجميع طلبات الترشيح (سواء كانت قيد الانتظار أو مقبولة)
    // تُعرض في صفحة إدارة الكفالات ضمن لوحة تحكم المدير
    public function index()
    {
        // جلب جميع الكفالات مع معلومات الكافل واليتيم المرتبطين بها
        $sponsorships = Sponsorship::with(['donor', 'orphan'])->get();

        // جلب جميع الترشيحات التي حالتها "قيد الانتظار" أو "مقبول" مع الكافل واليتيم
        $candidates = \App\Models\CandidateSponsorship::with(['donor', 'orphan'])
            ->whereIn('status', ['قيد الانتظار', 'مقبول'])
            ->get();

        return view('admin.GuaranteeManagement', compact('sponsorships', 'candidates'));
    }


    public function edit($id)
    {
        $sponsorship = Sponsorship::with(['donor', 'orphan'])->findOrFail($id);
        return view('admin.editSponsorship', compact('sponsorship'));
    }

    // تقوم هذه الدالة بتحديث بيانات كفالة معينة في لوحة تحكم المدير
    public function update(Request $request, $id)
    {

        // التحقق من صحة البيانات المُدخلة
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'nullable|date',
            'type' => 'nullable|string',
            'amount' => 'nullable|numeric',
            'status' => 'required|string',
        ]);

        // جلب الكفالة بناءً على معرفها
        $sponsorship = Sponsorship::findOrFail($id);

        // تحديث بيانات الكفالة بالحقول المسموح تعديلها9
        $sponsorship->update($request->only('start_date', 'end_date', 'type', 'amount', 'status'));

        // إعادة التوجيه مع رسالة نجاح
        return redirect()->route('admin.sponsorships.index')->with('success', 'تم تحديث بيانات الكفالة.');
    }

    public function destroy($id)
    {
        $sponsorship = Sponsorship::findOrFail($id);
        $orphan = Orphan::find($sponsorship->orphan_id);

        $sponsorship->delete();

        if ($orphan) {
            Sponsorship::updateOrphanSponsorshipStatus($orphan->user_id);
        }

        return redirect()->back()->with('success', 'تم حذف الكفالة');
    }


    // تقوم هذه الدالة بقبول طلب كفالة معين (ترشيح) وتحديث حالته إلى "مقبول"
    // كما ترسل إشعارات إلى كل من الكافل واليتيم لإبلاغهم بقبول الطلب
    public function accept($id)
    {

        // جلب الترشيح بناءً على معرفه
        $candidate = CandidateSponsorship::findOrFail($id);

        // تحديث حالة الترشيح إلى "مقبول"
        $candidate->update(['status' => 'مقبول']);

        $donor = $candidate->donor;     // الكافل المرتبط بالترشيح
        $orphanUser = $candidate->orphan->user;      // المستخدم المرتبط باليتيم

        // إشعار الكافل
        if ($donor) {
            $donor->notify(new \App\Notifications\SponsorshipAcceptedNotification(
                $candidate->orphan->name,
                $candidate->id,
                'مرشح للكفالة'
            ));
        }

        // إشعار اليتيم
        if ($orphanUser) {
            $orphanUser->notify(new \App\Notifications\SponsorshipApprovedNotification(
                $candidate->donor->name,
                $candidate->orphan->name,
                $candidate->id
            ));
        }

        return redirect()->back()->with('success', 'تم قبول طلب الكفالة. في انتظار الدفع.');
    }


    // تقوم هذه الدالة برفض كفالة محددة عن طريق تحديث حالتها إلى "مرفوضة"
    // كما تقوم بتحديث حالة اليتيم بناءً على حالة الكفالات المرتبطة به

    public function reject($id)
    {

        // جلب الكفالة مع الكافل والمستخدم اليتيم المرتبط بها
        $sponsorship = Sponsorship::with(['donor', 'orphanUser'])->findOrFail($id);

        $sponsorship->update(['status' => 'مرفوضة']);

        //  تحديث حالة اليتيم
        $orphan = Orphan::find($sponsorship->orphan_id);

        // تحديث حالة الكفالة لليتيم في قاعدة البيانات (مثلاً جعله "غير مكفول" إذا لم يعد له كفالات نشطة)
        if ($orphan) {
            \App\Models\Sponsorship::updateOrphanSponsorshipStatus($orphan->user_id);
        }

        return back()->with('success', 'تم رفض الكفالة.');
    }


    // تقوم هذه الدالة بإنشاء كفالة جديدة من قبل الكافل ليتيم معين
    // كما تنشئ سجلًا للدفع المرتبط بالكفالة، وتُرسل إشعارًا للمدير، ثم توجه الكافل إلى صفحة الدفع

    public function store(Request $request)
    {

        // التحقق من صحة البيانات المطلوبة من النموذج
        $request->validate([
            'orphan_id' => 'required|exists:orphans,id',
            'type' => 'required|string',
            'amount' => 'required|numeric',
            'payment_method' => 'required|string',
        ]);

        // جلب هوية الكافل واليتيم
        $kafelId = Auth::id();
        $orphan = Orphan::findOrFail($request->orphan_id);
        $donor = Auth::user();

        //  إنشاء الكفالة
        $sponsorship = Sponsorship::create([
            'orphan_id' => $orphan->id,
            'kafel_id' => $kafelId,
            'type' => $request->type,
            'amount' => $request->amount,
            'payment_method' => $request->payment_method,
            'status' => 'قيد الانتظار',
            'start_date' => now(),
        ]);

        //  تحديث حالة اليتيم إلى "مكفول"
        Sponsorship::updateOrphanSponsorshipStatus($orphan->id);

        //  إنشاء سجل الدفع
        $payment = \App\Models\Payment::create([
            'user_id' => $kafelId,
            'sponsorship_id' => $sponsorship->id,
            'amount' => $request->amount,
            'method' => $request->payment_method,
            'status' => 'قيد الانتظار',
            'payment_date' => now(),
            'notified' => false,
        ]);

        // إرسال إشعار إلى المدير بوجود كفالة جديدة بانتظار الموافقة أو الدفع
        $admin = User::where('role', 'admin')->first();
        if ($admin) {
            $admin->notify(new NewSponsorshipRequestNotification(
                $donor->name,
                $orphan->name,
                $sponsorship->id
            ));
        }

        //  إرسال المستخدم لصفحة الدفع
        return redirect()->route('payment.checkoutPage', $payment->id);
    }




    // هذه الدالة تعرض صفحة "كفالاتي" للكافل، حيث تُجلب جميع الكفالات المرتبطة به مع تفاصيل اليتيم لكل كفالة.
    public function mySponsorships()
    {

        // جلب المستخدم الحالي (الكافل)
        $donor = auth()->user();

        // تأكد أن العلاقة موجودة: user -> sponsorships
        $sponsorships = $donor->sponsorships()->with('orphan')->get();

        // عرضها في صفحة الكفالات
        return view('kafel.guarantee', compact('sponsorships'));
    }

    // هذه الدالة تعرض تفاصيل كفالة واحدة فقط للكافل، حسب معرف الكفالة (id)، وذلك بتمريرها إلى نفس صفحة العرض العامة للكفالات.
    public function show($id)
    {
        $sponsorship = Sponsorship::with('orphan')->findOrFail($id);
        return view('kafel.guarantee', ['sponsorships' => [$sponsorship]]);
    }


    // هذه الدالة تُستخدم لإنهاء كفالة معيّنة (تغيير حالتها إلى "منتهية") وتحديث حالة اليتيم المرتبط بها.
    public function end($id)
    {
        // جلب الكفالة المطلوبة
        $sponsorship = Sponsorship::findOrFail($id);

        // تحديث حالة الكفالة إلى "منتهية" وتسجيل تاريخ الانتهاء
        $sponsorship->status = 'منتهية';
        $sponsorship->end_date = now();
        $sponsorship->save();

        // تحديث حالة اليتيم إلى غير مكفول
        if ($sponsorship->orphan) {
            $orphan = $sponsorship->orphan;
            Sponsorship::updateOrphanSponsorshipStatus($sponsorship->orphan_id);
        }

        return back()->with('success', 'تم إنهاء الكفالة بنجاح.');
    }


    // هذه الدالة تقوم بتجديد كفالة منتهية أو موقوفة عن طريق إعادة تفعيلها وتحديث تاريخ البداية وإزالة تاريخ الانتهاء.
    public function renew($id)
    {
        $sponsorship = Sponsorship::findOrFail($id);
        $sponsorship->status = 'نشطة';
        $sponsorship->start_date = now(); // اختياري: إعادة تعيين تاريخ البداية
        $sponsorship->end_date = null;   // إذا عندك عمود نهاية الكفالة
        $sponsorship->save();

        return back()->with('success', 'تم تجديد الكفالة بنجاح.');
    }


    // هذه الدالة تُستخدم داخل لوحة تحكم اليتيم لعرض تفاصيل كفالته الحالية (النشطة فقط).
    // تعتمد على أن معرف المستخدم هو نفسه معرف اليتيم في جدول الكفالات (orphan_id).
    public function myOrphanSponsorship()
    {
        $orphanUserId = auth()->id();

        // الحصول على الكفالة النشطة الخاصة بهذا اليتيم
        $sponsorship = Sponsorship::with('donor')
            ->where('orphan_id', $orphanUserId)
            ->where('status', 'نشطة')
            ->latest()
            ->first();

        return view('orphan.Myguarantee', compact('sponsorship'));
    }


    // هذه الدالة تُستخدم عندما يقدّم الكافل طلب كفالة ليتيم معيّن.
    // يتم إنشاء سجل جديد في جدول المرشحين للكفالة (candidate_sponsorships) بحالة "قيد الانتظار".
    // ثم يتم إرسال إشعار إلى المدير لإعلامه بوجود طلب كفالة جديد.

    public function storeCandidate(Request $request)
    {
        $candidate = CandidateSponsorship::create([
            'orphan_id' => $request->orphan_id,
            'donor_id' => auth()->id(),
            'status' => 'قيد الانتظار',
        ]);

        // إرسال إشعار للمدير
        $admin = User::where('email', 'admin@example.com')->first();
        $donor = auth()->user();
        $orphan = \App\Models\Orphan::find($request->orphan_id);

        if ($admin && $donor && $orphan) {
            $admin->notify(new \App\Notifications\SponsorshipRequestNotification($donor, $orphan, $candidate));
        }

        return back()->with('success', 'تم إرسال طلب الكفالة بنجاح.');
    }


    //لحذف طلب الكفالة
    public function destroyCandidate($id)
    {
        $candidate = CandidateSponsorship::findOrFail($id);
        $candidate->delete();

        return redirect()->back()->with('success', 'تم حذف طلب الكفالة.');
    }

    // هذه الدالة تستخدم لتغير حالة الطلب الى مرفوض
    public function rejectCandidate($id)
    {
        $candidate = CandidateSponsorship::findOrFail($id);
        $candidate->update(['status' => 'مرفوض']);

        return redirect()->back()->with('success', 'تم رفض الطلب بنجاح.');
    }
}
