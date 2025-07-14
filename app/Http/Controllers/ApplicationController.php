<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\Application;
use Illuminate\Http\Request;

class ApplicationController extends Controller
{
    // عرض نموذج التقديم (غير مستخدم حالياً لأن النموذج داخل المودال)
    public function create($id)
    {
        $job = Job::findOrFail($id);
        return view('applications.apply', compact('job'));
    }

    // تخزين الطلب المرسل من الفورم
    public function store(Request $request)
    {
        // ✅ هذا السطر يعرض جميع البيانات المُرسلة للفورم


        $request->validate([
            'job_id' => 'required|exists:jobs,id',
            'full_name' => 'required|string|max:255',
            'age' => 'required|integer|min:18|max:100',
            'major' => 'required|string|max:255',
            'cv_file' => 'required|file|mimes:pdf|max:10000',
        ]);

        $cvPath = $request->file('cv_file')->store('cvs', 'public');

        Application::create([
            'job_id'   => $request->job_id,
            'user_id'  => auth()->id(),
          'full_name' => $request->full_name,
             'age'      => $request->age,
            'major'    => $request->major,
            'cv_path'  => $cvPath,
            'status'   => 'قيد المراجعة',
        ]);

        return redirect()->back()->with('success', '✅ تم إرسال طلبك بنجاح!');
    }



    // عرض الطلبات الخاصة بالمستخدم
    public function userApplications()
    {
        $applications = Application::with('job')
            ->where('user_id', auth()->id())
            ->latest()
            ->get();

        return view('dashboard.applications', compact('applications'));
    }

    // عرض جميع الطلبات للمشرف
    public function all()
    {
        $applications = Application::with('job')->latest()->get();
        return view('admin.applications', compact('applications'));
    }
}
