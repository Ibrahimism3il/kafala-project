@extends('layouts.app')

@section('title', 'لوحة تحكم المسؤول')

@section('content')
<div class="container py-5">
    <h2 class="mb-4">👨‍💼 لوحة تحكم المسؤول</h2>

    <div class="row g-4 mb-4">
        <div class="col-md-4">
            <div class="card bg-primary text-white h-100">
                <div class="card-body">
                    <h5>📄 عدد الطلبات</h5>
                    <p class="fs-3">{{ $applications_count }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-success text-white h-100">
                <div class="card-body">
                    <h5>💼 عدد الوظائف</h5>
                    <p class="fs-3">{{ $jobs_count }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-dark text-white h-100">
                <div class="card-body">
                    <h5>👥 عدد المستخدمين</h5>
                    <p class="fs-3">{{ $users_count }}</p>
                </div>
            </div>
        </div>
    </div>

    <h4 class="mb-3">🕓 آخر الطلبات المقدمة</h4>
    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>المستخدم</th>
                    <th>الوظيفة</th>
                    <th>تاريخ التقديم</th>
                    <th>الحالة</th>
                </tr>
            </thead>
            <tbody>
                @forelse($latest_applications as $app)
                <tr>
                    <td>{{ $app->user->name ?? '-' }}</td>
                    <td>{{ $app->job->title ?? '-' }}</td>
                    <td>{{ $app->created_at->format('Y-m-d') }}</td>
                    <td>{{ $app->status }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="4">لا توجد طلبات حتى الآن.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
