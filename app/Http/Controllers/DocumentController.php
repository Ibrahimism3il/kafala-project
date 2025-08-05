<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use App\Models\Document;

class DocumentController extends Controller
{

    // تعرض صفحة الوثائق الخاصة باليتيم، وتقوم بتجميع الوثائق حسب النوع المحدد في Document::TYPES.
    // يتم إرجاع كل نوع وثيقة مع الوثيقة المقابلة له (إن وجدت) لعرضها في جدول أو نموذج.
    public function index()
    {
        $user = auth()->user();
        $docsByType = $user->documents()->get()->keyBy('type');

        $rows = [];
        foreach (Document::TYPES as $key => $label) {
            $rows[] = [
                'type_key' => $key,
                'label'    => $label,
                'doc'      => $docsByType->get($key),
            ];
        }

        return view('orphan.documents', compact('rows'));
    }


    // تقوم هذه الدالة برفع وثيقة جديدة أو تحديث وثيقة موجودة للمستخدم الحالي (اليتيم)،
    // بحيث يتم التحقق من نوع الوثيقة وصيغة الملف، ثم حفظه أو تحديثه في جدول documents.

    public function store(Request $request)
    {
        $request->validate([
            'type' => ['required', Rule::in(array_keys(Document::TYPES))],
            'file' => 'required|file|max:10000',
        ]);

        $path = $request->file('file')->store('documents', 'public');

        Document::updateOrCreate(
            ['user_id' => auth()->id(), 'type' => $request->type],
            ['file' => $path]
        );

        return redirect()->back()->with('success', 'تم رفع الوثيقة بنجاح.');
    }

    public function destroy($id)
    {
        $doc = Document::where('id', $id)
            ->where('user_id', auth()->id())   // يتأكد من الملكيّة فى الاستعلام
            ->firstOrFail();

        Storage::disk('public')->delete($doc->file);
        $doc->delete();

        return back()->with('success', 'تم حذف الوثيقة.');
    }

    public function edit(Document $doc)
    {
        if ($doc->user_id !== auth()->id()) {
            abort(403);
        }

        // return view('orphan.edit_document', compact('doc'));
    }

    public function update(Request $request, Document $doc)
    {
        if ($doc->user_id !== auth()->id()) {
            abort(403);
        }

        $request->validate([
            'file' => 'nullable|file|max:10000',
        ]);

        if ($request->hasFile('file')) {
            Storage::disk('public')->delete($doc->file);
            $path = $request->file('file')->store('documents', 'public');
            $doc->update(['file' => $path]);
        }

        return redirect()->route('orphan.documents')->with('success', 'تم تعديل الوثيقة.');
    }
}
