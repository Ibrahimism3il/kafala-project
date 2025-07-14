@extends('layouts.app')

@section('title', 'لوحة التحكم')

@section('content')
<div class="container py-5">
    <h2 class="mb-4">👋 مرحباً {{ Auth::user()->name }}</h2>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="row g-4">
        <div class="col-md-4">
            <div class="card text-white bg-primary h-100">
                <div class="card-body">
                    <h5 class="card-title">📄 عدد الطلبات</h5>
                    <p class="card-text fs-3">{{ $applications_count }}</p>
                </div>
                <div class="card-footer bg-transparent border-0">
                    <a href="{{ route('user.applications') }}" class="btn btn-light btn-sm">عرض الطلبات</a>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card h-100">
                <div class="card-body">
              <h5 class="card-title">🕒 آخر وظيفة تم التقديم عليها</h5>
                    @if($last_application)
                        <p class="mb-1"><strong>الوظيفة:</strong> {{ $last_application->job->title ?? '-' }}</p>
                        <p class="mb-1"><strong>الشركة:</strong> {{ $last_application->job->company ?? '-' }}</p>
                        <p class="mb-1"><strong>التاريخ:</strong> {{ $last_application->created_at->format('Y-m-d') }}</p>
                        <p class="mb-1"><strong>الحالة:</strong> {{ $last_application->status }}</p>
                        <a href="{{ asset('storage/' . $last_application->cv_path) }}" class="btn btn-outline-primary btn-sm mt-2" target="_blank">عرض السيرة الذاتية</a>
                    @else
                        <p>لم يتم التقديم على أي وظيفة حتى الآن.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
