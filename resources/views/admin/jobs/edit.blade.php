@extends('layouts.app')

@section('title', 'تعديل وظيفة')

@section('content')
<div class="container py-4">
    <h2 class="mb-4">✏️ تعديل وظيفة</h2>

    <form action="{{ route('admin.jobs.update', $job->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>المسمى الوظيفي</label>
            <input type="text" name="title" class="form-control" value="{{ $job->title }}" required>
        </div>
        <div class="mb-3">
            <label>اسم الشركة</label>
            <input type="text" name="company" class="form-control" value="{{ $job->company }}" required>
        </div>
        <div class="mb-3">
            <label>الموقع</label>
            <input type="text" name="location" class="form-control" value="{{ $job->location }}" required>
        </div>
        <div class="mb-3">
            <label>الوصف الوظيفي</label>
            <textarea name="description" class="form-control" rows="4" required>{{ $job->description }}</textarea>
        </div>
        <button class="btn btn-primary">تحديث الوظيفة</button>
    </form>
</div>
@endsection
