@extends('layouts.app')

@section('content')
<div class="container">
    <h2>تقديم طلب على وظيفة: {{ $job->title }}</h2>

    <form method="POST" action="{{ route('job.apply') }}" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="job_id" value="{{ $job->id }}">

        <div class="mb-3">
            <label for="full_name" class="form-label">الاسم الكامل</label>
            <input type="text" name="full_name" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="age" class="form-label">العمر</label>
            <input type="number" name="age" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="major" class="form-label">التخصص</label>
            <input type="text" name="major" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="cv_file" class="form-label">السيرة الذاتية (PDF فقط)</label>
            <input type="file" name="cv_file" class="form-control" accept=".pdf" required>
        </div>

        <button type="submit" class="btn btn-success">إرسال الطلب</button>
    </form>
</div>
@endsection
