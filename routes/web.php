<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\OrphanController;
use App\Http\Controllers\DonorController;
use App\Http\Controllers\SponsorshipController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\AdminNotificationController;
use App\Http\Controllers\AdminController;


//  الصفحة الرئيسية
Route::get('/', fn() => view('index'))->name('index');

//  صفحات عامة
Route::get('/login', fn() => view('auth.login'))->name('login.form');
Route::get('/register', fn() => view('auth.register'))->name('register.form');
Route::get('/details', fn() => view('details'))->name('details');

//  تسجيل الدخول والخروج
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::put('/orphans/{id}', [OrphanController::class, 'update'])->name('admin.orphans.update');
Route::put('/notifications/mark-all-read', [NotificationController::class, 'markAllAsRead'])->name('notifications.markAllAsRead');

//  مسارات المدير
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/GuaranteeManagement', fn() => view('admin.GuaranteeManagement'));
    Route::get('/DonorsManagement', fn() => view('admin.DonorsManagement'));
    Route::get('/editProfile', fn() => view('admin.editProfile'));
    Route::get('/orphans/create', fn() => view('admin.newOrphan'))->name('admin.orphans.create');
    Route::post('/orphans', [OrphanController::class, 'store'])->name('admin.orphans.store');
    Route::get('/DonorsManagement', [OrphanController::class, 'donorsIndex'])->name('admin.donors.index');
    Route::post('/orphans', [OrphanController::class, 'store'])->name('admin.orphans.store');
    Route::get('/GuaranteeManagement', [SponsorshipController::class, 'index'])->name('admin.sponsorships.index');
    Route::get('/sponsorships/{id}/edit', [SponsorshipController::class, 'edit'])->name('admin.sponsorships.edit');
    Route::get('/admin/payments', [PaymentController::class, 'index'])->name('admin.payments.index');
    Route::get('admin/paymentsManagement', [PaymentController::class, 'index'])->name('admin.paymentsManagement');
    Route::get('/paymentsManagement', [PaymentController::class, 'index'])->name('admin.paymentsManagement');
    Route::post('/payments/{id}/notify', [PaymentController::class, 'notify'])->name('admin.payments.notify');
    Route::put('/notifications/{id}/read', [NotificationController::class, 'markAsRead'])->name('notifications.markAsRead');
    Route::delete('/notifications/{id}', [NotificationController::class, 'destroy'])->name('notifications.delete');
    Route::get('/payments', [PaymentController::class, 'index'])->name('admin.payments.index');
    Route::put('/payments/{id}/accept', [PaymentController::class, 'accept'])->name('admin.payments.accept');
    Route::put('/payments/{id}/reject', [PaymentController::class, 'reject'])->name('admin.payments.reject');
    Route::post('/admin/payments/{payment}/notify', [NotificationController::class, 'notifyKafel'])->name('admin.payments.notify');
    Route::post('/admin/payments/{id}/notify', [NotificationController::class, 'notifyKafel'])->name('admin.payments.notify');
    Route::post('/admin/payments/{payment}/notify', [NotificationController::class, 'notifyKafel'])->name('admin.payments.notify');
    Route::post('/payments/{payment}/notify')->name('admin.payments.notify');
    Route::get('/admin/notifications', [AdminNotificationController::class, 'index'])->name('admin.notifications');
    Route::get('/notifications', [AdminNotificationController::class, 'index'])->name('admin.notifications.index');
    Route::post('/notifications', [AdminNotificationController::class, 'store'])->name('admin.notifications.store');
    Route::put('/profile/update', [AdminController::class, 'updateProfile'])->name('admin.profile.update');
    Route::put('/admin/candidate-sponsorships/{id}/accept', [SponsorshipController::class, 'acceptCandidate'])->name('candidate-sponsorship.accept');
    Route::put('/admin/candidate-sponsorships/{id}/reject', [SponsorshipController::class, 'rejectCandidate'])->name('candidate-sponsorship.reject');
    Route::put('/admin/sponsorships/{id}/accept', [SponsorshipController::class, 'accept'])->name('admin.sponsorships.accept');


    // إدارة الكافلين
    Route::get('/donors', [DonorController::class, 'index'])->name('admin.DonorsManagement.index');
    Route::delete('/donors/{id}', [DonorController::class, 'destroy'])->name('admin.DonorsManagement.destroy');
    Route::get('/donors', [DonorController::class, 'index'])->name('admin.DonorsManagement.index');
    Route::delete('/donors/{id}', [DonorController::class, 'destroy'])->name('admin.DonorsManagement.destroy');
    Route::get('/donors/create', fn() => view('admin.newDonor'))->name('admin.donors.create');
    Route::post('/donors', [DonorController::class, 'store'])->name('admin.donors.store');
    Route::delete('/candidate-sponsorships/{id}', [SponsorshipController::class, 'destroyCandidate'])->name('candidate-sponsorship.destroy');
    Route::put('/sponsorships/{id}/accept', [SponsorshipController::class, 'accept'])->name('admin.sponsorships.accept');

    // عرض نموذج التعديل
    Route::get('/donors/{id}/edit', [DonorController::class, 'edit'])->name('admin.donors.edit');
    // تنفيذ التعديل
    Route::put('/donors/{id}', [DonorController::class, 'update'])->name('admin.donors.update');

    // إدارة الكفالات
    Route::get('/sponsorships', [SponsorshipController::class, 'index'])->name('admin.sponsorships.index');
    Route::put('/sponsorships/{id}', [SponsorshipController::class, 'update'])->name('admin.sponsorships.update');
    Route::delete('/sponsorships/{id}', [SponsorshipController::class, 'destroy'])->name('admin.sponsorships.destroy');
    Route::put('/sponsorships/{id}/accept', [SponsorshipController::class, 'accept'])->name('admin.sponsorships.accept');
    Route::put('/sponsorships/{id}/reject', [SponsorshipController::class, 'reject'])->name('admin.sponsorships.reject');


    // إدارة الأيتام (OrphanController)
    Route::get('/orphans', [OrphanController::class, 'index'])->name('admin.orphans.index');
    Route::get('/orphans/{id}', [OrphanController::class, 'show'])->name('admin.orphans.show');
    Route::get('/orphans/{id}/edit', [OrphanController::class, 'edit'])->name('admin.orphans.edit');
    Route::put('/orphans/{id}', [OrphanController::class, 'update'])->name('admin.orphans.update');
    Route::delete('/orphans/{id}', [OrphanController::class, 'destroy'])->name('admin.orphans.destroy');
    Route::get('/admin/orphans/{id}', [OrphanController::class, 'show'])->name('admin.orphans.show');
});


//  مسارات الكافل
Route::middleware(['auth', 'kafel'])->prefix('kafel')->group(function () {
    Route::get('/dashboard', [DonorController::class, 'dashboard'])->name('kafel.dashboard');

    Route::get('/notifications', fn() => view('kafel.notifications'));
    Route::get('/editProfile', fn() => view('kafel.editProfile'));
    Route::get('/kafel/guarantee', [DonorController::class, 'guarantees'])->name('kafel.guarantee');
    Route::get('/guarantee', [SponsorshipController::class, 'mySponsorships'])->name('kafel.guarantee');
    Route::get('/showOrphan', [DonorController::class, 'showAvailableOrphans'])->name('kafel.showOrphan');
    Route::post('/sponsorships', [SponsorshipController::class, 'store'])->name('sponsorships.store');
    Route::get('/sponsorships/{id}', [SponsorshipController::class, 'show'])->name('sponsorships.show');
    Route::post('/sponsorships/{id}/end', [SponsorshipController::class, 'end'])->name('sponsorships.end');
    Route::post('/sponsorships/{id}/renew', [SponsorshipController::class, 'renew'])->name('sponsorships.renew');
    Route::post('kafel/sponsorships/{id}/end', [SponsorshipController::class, 'end'])->name('kafel.sponsorships.end');
    Route::post('/kafel/sponsorships/{id}/renew', [SponsorshipController::class, 'renew'])->name('sponsorships.renew');
    Route::post('/payments', [PaymentController::class, 'store'])->name('payments.store');
    Route::get('/guarantee', [SponsorshipController::class, 'mySponsorships'])->name('kafel.guarantee');
    Route::put('/kafel/profile/update', [DonorController::class, 'updateProfile'])->name('profile.update');
    Route::post('/checkout', [PaymentController::class, 'checkout'])->name('payment.checkout');
    Route::post('/create-stripe-session', [PaymentController::class, 'createStripeSession'])->name('payment.createStripeSession');
    Route::get('/payment/success', [PaymentController::class, 'stripeSuccess'])->name('payment.success');
    Route::get('/payment/cancel', [PaymentController::class, 'stripeCancel'])->name('payment.cancel');
    Route::get('/payment/checkout/{payment}', [PaymentController::class, 'checkoutPage'])->name('payment.checkoutPage');
    Route::post('/payment/create-stripe-session', [PaymentController::class, 'createStripeSession'])->name('payment.createStripeSession');
    Route::delete('/sponsorships/{id}', [SponsorshipController::class, 'destroy'])->name('sponsorships.destroy');
    Route::get('/kafel/notifications/unread', [DonorController::class, 'getUnreadNotifications'])->name('kafel.notifications.unread');
    Route::post('/candidate-sponsorship', [SponsorshipController::class, 'storeCandidate'])->name('candidate-sponsorship.store');
    Route::get('/payment/create', [PaymentController::class, 'create'])->name('payment.create');
    Route::post('/payment/prepare', [PaymentController::class, 'prepare'])->name('payment.prepare');
});

//  مسارات اليتيم
Route::middleware(['auth', 'orphan'])->prefix('orphan')->group(function () {
    Route::get('/dashboard', fn() => view('orphan.dashboard'));
    Route::get('/notifications', fn() => view('orphan.notifications'));
    Route::get('/editProfile', fn() => view('orphan.editProfile'));
    Route::get('/Myguarantee', [OrphanController::class, 'myGuarantee'])->name('orphan.myguarantee');
    Route::get('/dashboard', [OrphanController::class, 'dashboard'])->name('orphan.dashboard');
    Route::put('/updateProfile', [OrphanController::class, 'updateProfile'])->name('orphan.updateProfile');
    Route::get('/editProfile', [OrphanController::class, 'editProfile'])->name('orphan.editProfile');
    Route::put('/orphans/{id}', [OrphanController::class, 'update'])->name('orphans.update');
    Route::get('/documents', [OrphanController::class, 'documentsPage'])->name('orphan.documents');
    Route::get('/orphan/Myguarantee', [SponsorshipController::class, 'myOrphanSponsorship'])->name('orphan.myguarantee');

    // عرض بيانات اليتيم المسجل حالياً
    Route::get('/detailesOrphan', [OrphanController::class, 'showProfile'])->name('orphan.profile');
    Route::post('/documents/upload', [DocumentController::class, 'upload'])->name('orphan.document.upload');
    Route::delete('/documents/{id}', [DocumentController::class, 'destroy'])->name('orphan.document.delete');
});

Route::middleware(['auth'])->group(function () {

    Route::put('/notifications/{id}/read', [NotificationController::class, 'markAsRead'])->name('notifications.markAsRead');

    Route::get('/orphan/documents', [DocumentController::class, 'index'])->name('orphan.documents');
    Route::post('/orphan/documents', [DocumentController::class, 'store'])->name('orphan.document.upload');
    Route::get('/orphan/documents/{doc}', [DocumentController::class, 'show'])->name('orphan.document.show');
    Route::get('/orphan/documents/{doc}/edit', [DocumentController::class, 'edit'])->name('orphan.document.edit');
    Route::put('/orphan/documents/{doc}', [DocumentController::class, 'update'])->name('orphan.document.update');
    Route::delete('/orphan/documents/{doc}', [DocumentController::class, 'destroy'])->name('orphan.document.delete');
    Route::delete('/orphan/documents/{id}', [DocumentController::class, 'destroy'])->name('orphan.document.delete');
    Route::get('/orphan/Myguarantee', [OrphanController::class, 'myGuarantee'])->name('orphan.myguarantee');
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::get('/notifications/{id}/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');
    Route::delete('/notifications/{id}', [NotificationController::class, 'destroy'])->name('notifications.delete');
});
