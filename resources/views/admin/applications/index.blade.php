@extends('layouts.app')

@section('title', 'إدارة الطلبات')

@section('content')
<div class="container py-4">
    <h2 class="mb-4">📄 جميع الطلبات</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>المستخدم</th>
                <th>الوظيفة</th>
                <th>تاريخ التقديم</th>
                <th>الحالة</th>
                <th>السيرة الذاتية</th>
                <th>تحديث الحالة</th>
            </tr>
        </thead>
        <tbody>
            @foreach($applications as $app)
                <tr>
                    <td>{{ $app->user->name ?? '-' }}</td>
                    <td>{{ $app->job->title ?? '-' }}</td>
                    <td>{{ $app->created_at->format('Y-m-d') }}</td>
                    <td>{{ $app->status }}</td>
                    <td>
                        <a href="{{ asset('storage/' . $app->cv_path) }}" class="btn btn-sm btn-outline-primary" target="_blank">عرض</a>
                    </td>
                    <td>
                        <form method="POST" action="{{ route('admin.applications.updateStatus', $app->id) }}">
                            @csrf
                            @method('PUT')
                            <select name="status" class="form-select form-select-sm" onchange="this.form.submit()">
                                <option value="قيد المراجعة" {{ $app->status == 'قيد المراجعة' ? 'selected' : '' }}>قيد المراجعة</option>
                                <option value="مقبول" {{ $app->status == 'مقبول' ? 'selected' : '' }}>مقبول</option>
                                <option value="مرفوض" {{ $app->status == 'مرفوض' ? 'selected' : '' }}>مرفوض</option>
                            </select>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{ $applications->links() }}
</div>
@endsection
