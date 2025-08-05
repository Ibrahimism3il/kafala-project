<?php

namespace App\Http\Controllers;

use App\Models\Orphan;
use Illuminate\Support\Str;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Sponsorship;
use Illuminate\Support\Facades\Auth;
use App\Models\Notification;
use App\Models\CandidateSponsorship;

class DonorController extends Controller
{

    // تعرض صفحة إدارة الكفلاء في لوحة المدير، وتشمل كل كافل مع عدد كفالاته.

    public function index()
    {
        $donors = User::where('role', 'kafel')->withCount('sponsorships')->get();
        return view('admin.DonorsManagement', compact('donors'));
    }

    // تحذف كافلًا معينًا بناءً على معرفه بعد التحقق من أن دوره هو "كافل".

    public function destroy($id)
    {
        $donor = User::where('role', 'kafel')->findOrFail($id);
        $donor->delete();
        return back()->with('success', 'تم حذف الكافل بنجاح.');
    }


    // تضيف كافلًا جديدًا من قبل المدير، حيث يتم إدخال الاسم ونوع الكافل،
    // وإنشاء بريد إلكتروني عشوائي تلقائي، وتعيين كلمة مرور افتراضية.

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'kafel_type' => 'required|string|max:10',
        ]);

        $randomEmail = Str::slug($request->name) . rand(1000, 9999) . '@example.com';

        User::create([
            'name' => $request->name,
            'kafel_type' => $request->kafel_type,
            'email' => $randomEmail,
            'password' => bcrypt('12345678'),
            'role' => 'kafel',
        ]);

        return redirect()->route('admin.DonorsManagement.index')->with('success', 'تمت إضافة الكافل بنجاح.');
    }

    public function edit($id)
    {
        $donor = User::where('role', 'kafel')->findOrFail($id);
        return view('admin.editDonor', compact('donor'));
    }


    // تقوم بتحديث بيانات كافل معين (الاسم ونوع الكافل) بعد التحقق من أنه فعلاً كافل.

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'kafel_type' => 'required|string|max:10',
        ]);

        $donor = User::where('role', 'kafel')->findOrFail($id);
        $donor->update([
            'name' => $request->name,
            'kafel_type' => $request->kafel_type,
        ]);

        return redirect()->route('admin.DonorsManagement.index')->with('success', 'تم تعديل بيانات الكافل بنجاح.');
    }


    // تعرض للكافل قائمة الأيتام المتاحين للكفالة، مع الكفالات التي سبق له ترشيحها.

    public function showAvailableOrphans()
    {
        $orphans = Orphan::where('sponsorship_status', 'غير مكفول')->get();

        $candidates = CandidateSponsorship::with('orphan.user')
            ->where('donor_id', auth()->id())
            ->latest()
            ->get();

        return view('kafel.showOrphan', compact('orphans', 'candidates'));
    }
    public function updateProfile(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'password' => 'nullable|min:6|confirmed',
        ]);

        $user = auth()->user();

        if ($request->hasFile('photo')) {
            $imagePath = $request->file('photo')->store('users', 'public');
            $user->photo = $imagePath;
        }

        $user->name = $request->name;
        $user->email = $request->email;

        //  تحديث كلمة المرور إذا تم إدخالها
        if (!empty($request->password)) {
            $user->password = bcrypt($request->password);
        }

        $user->save();

        return back()->with('success', 'تم تحديث الملف الشخصي بنجاح.');
    }



    // تعرض لوحة تحكم الكافل وتتضمن عدد الأيتام المكفولين وغير المكفولين حاليًا،
    // بالإضافة إلى عدد الإشعارات غير المقروءة وآخر إشعار.

    public function dashboard()
    {
        $sponsoredOrphansCount = (int) Orphan::whereHas('sponsorships', function ($query) {
            $query->where('status', 'نشطة');
        })->distinct()->count();

        $unsponsoredOrphansCount = (int) Orphan::whereDoesntHave('sponsorships', function ($query) {
            $query->where('status', 'نشطة');
        })->count();

        //  الإشعارات غير المقروءة
        $unreadCount = Auth::user()->unreadNotifications()->count();
        $unreadNotifications = Auth::user()->unreadNotifications()->latest()->take(1)->get();

        return view('kafel.dashboard', compact(
            'sponsoredOrphansCount',
            'unsponsoredOrphansCount',
            'unreadCount',
            'unreadNotifications'
        ));
    }


    // تعرض صفحة الكفالات الخاصة بالكافل، وتجمع بين الكفالات المؤكدة (sponsorships)
    // وطلبات الترشح للكفالة (candidateSponsorships) المرتبطة به.

    public function guarantees()
    {
        $kafelId = Auth::id();

        $sponsorships = Sponsorship::with('orphan.user')
            ->where('kafel_id', $kafelId)
            ->get();

        $candidateSponsorships = CandidateSponsorship::with('orphan.user')
            ->where('donor_id', $kafelId)
            ->latest()
            ->get();

        return view('kafel.guarantee', compact('sponsorships', 'candidateSponsorships'));
    }
}
