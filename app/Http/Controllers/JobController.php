<?php

namespace App\Http\Controllers;
use App\Models\Application;
use App\Models\Job;
use Illuminate\Http\Request;

class JobController extends Controller
{
    public function index()
    {
        $jobs = Job::latest()->get();
        return view('jobs.index', compact('jobs'));
    }


    public function show($id)
    {
        $job = Job::findOrFail($id);
        return view('jobs.show', compact('job'));
    }
    public function adminIndex()
    {
        $jobs = Job::latest()->get();
        return view('admin.jobs.index', compact('jobs'));
    }
    public function create()
    {
        return view('admin.jobs.create');
    }

    public function store(Request $request)
    {
        Job::create([
            'title' => $request->title,
            'company' => $request->company,
            'location' => $request->location,
            'description' => $request->description,
            'user_id' => auth()->id(), // ✅ ربط الوظيفة بالمستخدم
        ]);


        return redirect()->route('admin.jobs.index')->with('success', 'تمت إضافة الوظيفة بنجاح');
    }
    public function edit($id)
    {
        $job = Job::findOrFail($id);
        return view('admin.jobs.edit', compact('job'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'company' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        $job = Job::findOrFail($id);
        $job->update($request->all());

        return redirect()->route('admin.jobs.index')->with('success', '✅ تم تحديث الوظيفة بنجاح');
    }
    public function destroy($id)
    {
        $job = Job::findOrFail($id);
        $job->delete();

        return redirect()->route('admin.jobs.index')->with('success', '✅ تم حذف الوظيفة بنجاح');
    }

}
