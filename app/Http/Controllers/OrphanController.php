<?php

namespace App\Http\Controllers;

use App\Models\Document;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Orphan;
use App\Models\Sponsorship;
use Illuminate\Support\Facades\Hash;

class OrphanController extends Controller
{
    // عرض جميع الأيتام
    public function index()
    {
        $orphans = User::where('role', 'orphan')->get();
        return view('admin.Orphanage', compact('orphans'));
    }

    // إضافة يتيم جديد
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'age' => 'nullable|integer',
            'gender' => 'nullable|string|max:20',
            'area' => 'nullable|string|max:100',
            'health_status' => 'required|in:سليم,مريض',
            'social_status' => 'required|in:يتيم الأب,يتيم الأبوين',
            'document' => 'nullable|file|max:10000',
        ]);


        $documentPath = null;
        if ($request->hasFile('document')) {
            $documentPath = $request->file('document')->store('documents', 'public');
        }

        // إنشاء المستخدم اليتيم
        $user = User::create([
            'name' => $request->name,
            'email' => uniqid('orphan_') . '@example.com',
            'password' => Hash::make('12345678'),
            'age' => $request->age,
            'gender' => $request->gender,
            'area' => $request->area,
            'health_status' => $request->health_status,
            'social_status' => $request->social_status,
            'document' => $documentPath,
            'role' => 'orphan',
        ]);

        // ربطه بجدول الأيتام (إن كان موجودًا)
        Orphan::create([
            'user_id' => $user->id,
            'name' => $user->name,
            'age' => $user->age,
            'gender' => $user->gender,
            'area' => $user->area,
            'health_status' => $user->health_status,
            'social_status' => $user->social_status,
        ]);

        return redirect()->route('admin.orphans.index')->with('success', 'تمت إضافة اليتيم بنجاح.');
    }



    // عرض صفحة يتيم واحد (تفاصيل)
    public function show($id)
    {
        $orphan = User::where('role', 'orphan')->findOrFail($id);

        // جلب جميع الوثائق الخاصة باليتيم
        $documents = \App\Models\Document::where('user_id', $orphan->id)->get()->keyBy('type');

        return view('admin.ShowOrphan', compact('orphan', 'documents'));
    }


    // تعرض صفحة الملف الشخصي لليتيم، وتشمل بياناته الأساسية بالإضافة إلى حالة الكفالة (مكفول أو غير مكفول).
    // يتم التحقق من وجود كفالة نشطة له من جدول الكفالات المرتبطة بموديل Orphan.

    public function showProfile()
    {
        $user = auth()->user();
        $orphanModel = $user->orphan;

        // تحديد حالة الكفالة من جدول الكفالات
        $isSponsored = $orphanModel
            ? $orphanModel->sponsorships()->where('status', 'نشطة')->exists()
            : false;

        return view('orphan.detailesOrphan', [
            'orphan' => $user,        // نستخدم user حتى تبقى الصورة ظاهرة
            'isSponsored' => $isSponsored
        ]);
    }





    // عرض صفحة التعديل


    // تحديث بيانات اليتيم
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'age' => 'nullable|integer',
            'gender' => 'nullable|string|max:20',
            'area' => 'nullable|string|max:100',
            'health_status' => 'required|in:سليم,مريض',
            'social_status' => 'required|in:يتيم الأب,يتيم الأبوين',
        ]);

        $orphan = User::where('role', 'orphan')->findOrFail($id);

        // تحديث جدول users
        $orphan->update($request->only([
            'name',
            'age',
            'gender',
            'area',
            'health_status',
            'social_status'
        ]));

        // تحديث جدول orphans
        if ($orphan->orphan) {
            $orphan->orphan->update([
                'name' => $request->name,
                'age' => $request->age,
                'gender' => $request->gender,
                'area' => $request->area,
                'health_status' => $request->health_status,
                'social_status' => $request->social_status,
            ]);
        }

        return redirect()->back()->with('success', 'تم تعديل بيانات اليتيم بنجاح');
    }


    // حذف يتيم
    public function destroy($id)
    {
        $orphan = User::where('role', 'orphan')->findOrFail($id);
        $orphan->delete();

        return redirect()->route('admin.orphans.index')->with('success', 'تم حذف اليتيم.');
    }

    // الاكافل
    public function donorsIndex()
    {
        $donors = User::where('role', 'kafel')->withCount('sponsorships')->get();
        return view('admin.DonorsManagement', compact('donors'));
    }

    public function documentsPage()
    {
        $orphan = auth()->user();

        // جلب الوثائق الخاصة باليتيم الحالي
        $documents = Document::where('user_id', $orphan->id)->get();

        return view('orphan.documents', compact('documents'));
    }


    // تعرض تفاصيل الكفالات النشطة لليتيم الحالي، وتشمل اسم الكافل، نوع الكفالة، تاريخ البدء،
    // وتاريخ وقيمة آخر دفعة تم تسديدها، وذلك بعد التحقق من أن المستخدم فعلاً يتيم.

    public function myGuarantee()
    {
        $user = auth()->user();
        $orphan = $user->orphan;

        if (!$orphan) {
            return view('orphan.Myguarantee', ['sponsorships' => []]);
        }

        $sponsorships = $orphan->sponsorships()
            ->with(['donor', 'lastPayment']) // تأكد من جلب lastPayment
            ->where('status', 'نشطة')
            ->get()
            ->map(function ($sponsorship) {
                $lastPayment = optional($sponsorship->lastPayment);
                $lastPaidDate = $lastPayment->payment_date;
                $lastAmount = $lastPayment->amount;

                return [
                    'sponsor_name' => optional($sponsorship->donor)->name ?? '—',
                    'type' => $sponsorship->type ?? '—',
                    'status' => $sponsorship->status ?? '—',
                    'start_date' => $sponsorship->start_date
                        ? \Carbon\Carbon::parse($sponsorship->start_date)->format('Y-m-d')
                        : '—',
                    'last_paid' => $lastPaidDate
                        ? \Carbon\Carbon::parse($lastPaidDate)->format('Y-m-d')
                        : '—',
                    'last_amount' => $lastAmount ?? '—',
                    // 'next_due' => ... // تم حذفه
                ];
            });

        return view('orphan.Myguarantee', compact('sponsorships'));
    }



    // تعرض لوحة تحكم اليتيم، وإذا كان لديه كفالة نشطة تُعرض تفاصيلها مع الكافل.
    // وإن لم يكن لديه كفالة، يتم عرض معلوماته فقط دون الكفالة.

    public function dashboard()
    {
        $user = auth()->user();
        $orphan = $user->orphan;

        if (!$orphan) {
            return view('orphan.dashboard', ['orphan' => $user]); // بدون كفالة
        }

        $sponsorship = $orphan->sponsorships()
            ->with('donor')
            ->where('status', 'نشطة')
            ->first();

        return view('orphan.dashboard', compact('orphan', 'sponsorship'));
    }


    // تعرض نموذج تعديل الملف الشخصي لليتيم من جدول users

    public function editProfile()
    {
        $orphan = auth()->user(); // لأن بيانات اليتيم محفوظة داخل جدول users
        return view('orphan.editProfile', compact('orphan'));
    }


    // تحدّث بيانات اليتيم من جدول users وجدول orphans (إن وُجد)
    // تشمل التحقق من البيانات، رفع صورة جديدة، تعديل كلمة المرور، وتحديث الحقول المشتركة

    public function updateProfile(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'password' => 'nullable|string|min:6',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'age' => 'nullable|integer',
            'area' => 'nullable|string|max:255',
            'social_status' => 'nullable|string|max:50',
            'health_status' => 'nullable|string|max:50',
            'gender' => 'nullable|in:ذكر,أنثى',
        ]);

        // تحديث الصورة إن تم رفعها
        if ($request->hasFile('photo')) {
            $user->photo = $request->file('photo')->store('users', 'public');
        }

        // تحديث كلمة المرور إن وُجدت
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        // تحديث الحقول العامة
        $user->name = $request->name;
        $user->email = $request->email;
        $user->age = $request->age;
        $user->area = $request->area;
        $user->social_status = $request->social_status;
        $user->health_status = $request->health_status;
        $user->gender = $request->gender;
        $user->save();

        // تحديث جدول الأيتام إن كان موجودًا
        if ($user->orphan) {
            $user->orphan->update([
                'name' => $request->name,
                'age' => $request->age,
                'area' => $request->area,
                'social_status' => $request->social_status,
                'health_status' => $request->health_status,
                'user_id' => $user->id,
                'gender' => $request->gender,
            ]);
        }

        return back()->with('success', 'تم تحديث الملف الشخصي بنجاح.');
    }
}
