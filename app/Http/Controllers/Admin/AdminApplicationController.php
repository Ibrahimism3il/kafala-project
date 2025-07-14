<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Application;
use Illuminate\Http\Request;

class AdminApplicationController extends Controller
{
    public function index()
    {
        $applications = Application::with('job', 'user')->latest()->paginate(10);
        return view('admin.applications.index', compact('applications'));
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:قيد المراجعة,مقبول,مرفوض',
        ]);

        $application = Application::findOrFail($id);
        $application->status = $request->status;
        $application->save();

        return redirect()->route('admin.applications.index')->with('success', 'تم تحديث حالة الطلب بنجاح.');
    }
}
