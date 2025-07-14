<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Job;
use App\Models\User;
use App\Models\Application;

class AdminDashboardController extends Controller
{
    public function index()
    {
        return view('admin.dashboard', [
            'jobs_count' => Job::count(),
            'applications_count' => Application::count(),
            'users_count' => User::count(),
            'latest_applications' => Application::with('job', 'user')->latest()->take(5)->get(),
        ]);
    }
}
