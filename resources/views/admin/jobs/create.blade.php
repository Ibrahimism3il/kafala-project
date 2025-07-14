@extends('layouts.app')

@section('title', 'إضافة وظيفة')

@section('content')
<div class="container py-4">
    <h2 class="mb-4">➕ إضافة وظيفة جديدة</h2>

    <form action="{{ route('admin.jobs.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label>المسمى الوظيفي</label>
            <input type="text" name="title" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>اسم الشركة</label>
            <input type="text" name="company" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>الموقع</label>
            <input type="text" name="location" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>الوصف الوظيفي</label>
            <textarea name="description" class="form-control" rows="4" required></textarea>
        </div>
        <button class="btn btn-success">حفظ الوظيفة</button>
    </form>
</div>
@endsection
