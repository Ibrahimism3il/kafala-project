<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Sponsorship;
use Illuminate\Support\Facades\Auth;
use App\Models\CandidateSponsorship;
use Illuminate\Support\Facades\Hash;


class AdminController extends Controller
{

    // تعرض لوحة تحكم المدير مع إحصائيات: عدد الأيتام، الكفلاء، الأيتام المكفولين، والأيتام المتاحين للكفالة.
    // كما تُحمّل آخر إشعار غير مقروء وعدد الإشعارات غير المقروءة للمدير.

    public function dashboard()
    {
        $orphansCount = User::where('role', 'orphan')->count();
        $donorsCount = User::where('role', 'kafel')->count();
        $sponsoredOrphansCount = Sponsorship::where('status', 'نشطة')->count();
        $availableOrphansCount = $orphansCount - $sponsoredOrphansCount;

        // الإشعارات غير المقروءة
        $unreadCount = Auth::user()->unreadNotifications()->count();
        $unreadNotifications = Auth::user()->unreadNotifications()->latest()->take(1)->get();

        return view('admin.dashboard', compact(
            'orphansCount',
            'donorsCount',
            'sponsoredOrphansCount',
            'availableOrphansCount',
            'unreadCount',
            'unreadNotifications'
        ));
    }

    // تقوم هذه الدالة بتحديث الملف الشخصي للمستخدم (المدير) بما في ذلك الاسم، البريد، الصورة، وكلمة المرور إذا تم إدخالها

    public function updateProfile(Request $request)
    {
        $admin = auth()->user();

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $admin->id,
            'photo' => 'nullable|image|max:2048',
            'password' => 'nullable|min:6', // كلمة المرور اختيارية
        ]);

        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('photos', 'public');
            $data['photo'] = $path;
        }

        // تحديث كلمة المرور فقط إذا تم إدخالها
        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']); // لا تحدثها إذا ما أرسلها المستخدم
        }

        $admin->update($data);

        auth()->login($admin); // لإعادة تسجيل الدخول في حال تغير البريد

        return back()->with('success', 'تم حفظ التعديلات بنجاح');
    }


    // تعرض صفحة إدارة الكفالات للمدير، بما في ذلك:
    // - كل الكفالات الجارية (مع الكافل واليتيم)
    // - الكفالات المقبولة التي لم يتم دفعها بعد (من جدول مرشحي الكفالة)
    // - عدد الإشعارات غير المقروءة وآخر إشعار

    public function guaranteeManagement()
    {
        $sponsorships = Sponsorship::with(['donor', 'orphan'])->get();

        $candidates = CandidateSponsorship::with(['orphan', 'donor'])
            ->where('status', 'مقبول')
            ->doesntHave('payment') // هذه العلاقة يجب تعريفها في الموديل CandidateSponsorship
            ->get();

        $unreadCount = Auth::user()->unreadNotifications()->count();
        $unreadNotifications = Auth::user()->unreadNotifications()->latest()->take(1)->get();

        return view('admin.GuaranteeManagement', compact(
            'sponsorships',
            'candidates',
            'unreadCount',
            'unreadNotifications'
        ));
    }
}
