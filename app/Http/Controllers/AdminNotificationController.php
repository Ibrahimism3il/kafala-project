<?php

namespace App\Http\Controllers;

use Illuminate\Notifications\DatabaseNotification;
use App\Models\User;
use App\Models\Notification;
use App\Models\Kafel;
use App\Models\Orphan;
use Illuminate\Http\Request;
use App\Notifications\ManualNotification;

class AdminNotificationController extends Controller
{
    public function index()
    {
        $kafels = User::where('role', 'kafel')->get();
        $orphans = Orphan::with('user')->get();

        return view('admin.notifications', compact('kafels', 'orphans'));
    }


    // ترسل إشعارًا يدويًا من المدير إلى كافل أو يتيم بناءً على نوع المستقبل ومعرّفه.
    // يتم التحقق من صحة البيانات ثم إرسال الإشعار باستخدام Notification مخصصة.

    public function store(Request $request)
    {
        $request->validate([
            'receiver_type' => 'required|in:kafel,orphan',
            'receiver_id' => 'required|integer',
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        $user = User::findOrFail($request->receiver_id);
        $user->notify(new ManualNotification($request->title, $request->content));

        return redirect()->back()->with('success', 'تم إرسال الإشعار بنجاح');
    }
}
