@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2>التقديم على وظيفة: {{ $job->title }}</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('job.apply') }}" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="job_id" value="{{ $job->id }}">

        <div class="mb-3">
            <label class="form-label">الاسم الكامل</label>
            <input type="text" name="full_name" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">العمر</label>
            <input type="number" name="age" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">التخصص</label>
            <input type="text" name="major" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">رفع السيرة الذاتية (PDF فقط)</label>
            <input type="file" name="cv_file" class="form-control" accept=".pdf" required>
        </div>

        <button type="submit" class="btn btn-success">إرسال الطلب</button>
    </form>
</div>
@endsection
