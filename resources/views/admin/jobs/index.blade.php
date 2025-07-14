@extends('layouts.app')

@section('title', 'إدارة الوظائف')

@section('content')
<div class="container py-4">
    <h2 class="mb-4">💼 الوظائف</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <a href="{{ route('admin.jobs.create') }}" class="btn btn-success mb-3">➕ إضافة وظيفة</a>

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>العنوان</th>
                <th>الشركة</th>
                <th>الموقع</th>
                <th>تاريخ الإضافة</th>
                <th>الإجراءات</th>
            </tr>
        </thead>
        <tbody>
            @foreach($jobs as $job)
                <tr>
                    <td>{{ $job->title }}</td>
                    <td>{{ $job->company }}</td>
                    <td>{{ $job->location }}</td>
                    <td>{{ $job->created_at->format('Y-m-d') }}</td>
                    <td>
                        <a href="{{ route('admin.jobs.edit', $job->id) }}" class="btn btn-sm btn-primary">✏️ تعديل</a>
                        <form action="{{ route('admin.jobs.destroy', $job->id) }}" method="POST" class="d-inline-block" onsubmit="return confirm('هل أنت متأكد من الحذف؟')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger">🗑️ حذف</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{ $jobs->links() }}
</div>
@endsection
