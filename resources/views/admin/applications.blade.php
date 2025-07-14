
@extends('layouts.app')

@section('title', 'إدارة الطلبات')

@section('content')
<div class="container" style="padding: 2rem;">
    <h2 class="mb-4">جميع الطلبات المقدمة</h2>

    @if($applications->isEmpty())
        <div class="alert alert-info">لا توجد طلبات حالياً.</div>
    @else
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>المستخدم</th>
                    <th>المسمى الوظيفي</th>
                    <th>البريد الإلكتروني</th>
                    <th>تاريخ التقديم</th>
                    <th>الرسالة</th>
                    <th>السيرة الذاتية</th>
                </tr>
            </thead>
            <tbody>
                @foreach($applications as $app)
                    <tr>
                        <td>{{ $app->name }}</td>
                        <td>{{ $app->job->title ?? '-' }}</td>
                        <td>{{ $app->email }}</td>
                        <td>{{ $app->created_at->format('Y-m-d') }}</td>
                        <td>{{ $app->message ?? '---' }}</td>
                        <td>
                            <a href="{{ asset('storage/' . $app->cv_path) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                عرض / تحميل
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
