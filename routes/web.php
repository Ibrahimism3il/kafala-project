<?php

use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminJobController;
use App\Http\Controllers\Admin\AdminApplicationController;
use App\Http\Controllers\Admin\AdminUserController;
use Illuminate\Support\Facades\Route;
use App\Models\Application;
use App\Models\User;
use App\Models\Job;
use App\Http\Controllers\Auth\CustomAuthController;


Route::middleware('guest')->group(function () {
    Route::get('/login', [CustomAuthController::class, 'showLoginForm'])->name('custom.login');
    Route::post('/login', [CustomAuthController::class, 'login']);

    Route::get('/register', [CustomAuthController::class, 'showRegisterForm'])->name('custom.register');
    Route::post('/register', [CustomAuthController::class, 'register']);
});

Route::post('/logout', [CustomAuthController::class, 'logout'])->name('custom.logout');

// الصفحة الرئيسية تعرض آخر 3 وظائف
Route::get('/', function () {
    $jobs = Job::latest()->take(3)->get();
    return view('landing', compact('jobs'));
})->name('home');

// الوظائف العامة
Route::get('/jobs', [JobController::class, 'index'])->name('jobs.index');
Route::get('/jobs/{id}', [JobController::class, 'show'])->name('jobs.show');

// تقديم الطلب
Route::post('/job/apply', [ApplicationController::class, 'store'])->name('job.apply');
Route::get('/job/apply/{id}', [ApplicationController::class, 'create'])->name('job.apply.form');
Route::get('/jobs/{id}/apply', [ApplicationController::class, 'create'])->name('jobs.apply');
Route::post('/job/apply', [ApplicationController::class, 'store'])->name('job.apply');
// الطلبات الخاصة بالمستخدم
Route::get('/my-applications', [ApplicationController::class, 'userApplications'])->name('user.applications');

// حساب المستخدم
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // لوحة تحكم المستخدم
    Route::get('/dashboard', function () {
        $userId = auth()->id();
        $applications_count = Application::where('user_id', $userId)->count();
        $last_application = Application::with('job')
            ->where('user_id', $userId)
            ->latest()
            ->first();

        return view('dashboard', compact('applications_count', 'last_application'));
    })->middleware(['verified'])->name('dashboard');
});

// لوحة تحكم المدير
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // لوحة تحكم المدير الرئيسية
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    // إدارة الوظائف (resource)
    Route::resource('jobs', AdminJobController::class);

    // إدارة الطلبات
    Route::get('applications', [AdminApplicationController::class, 'index'])->name('applications.index');
    Route::put('applications/{id}/status', [AdminApplicationController::class, 'updateStatus'])->name('applications.updateStatus');

    // إدارة المستخدمين
    Route::resource('users', AdminUserController::class);
});




// require __DIR__ . '/auth.php';
