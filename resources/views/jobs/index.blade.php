@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">قائمة الوظائف المتاحة</h2>

    @foreach($jobs as $job)
    <div class="card mb-3 p-3 shadow-sm">
        <h5>{{ $job->title }}</h5>
        <p>{{ $job->description }}</p>
   <a href="{{ route('jobs.apply', $job->id) }}" class="btn btn-primary">تقديم الآن</a>
    </div>
    @endforeach
</div>

<!-- Modal: نموذج التقديم -->
<div class="modal fade" id="applicationModal" tabindex="-1" aria-labelledby="applicationModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form method="POST" action="{{ route('job.apply') }}" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="job_id" id="job_id">

        <div class="modal-header">
          <h5 class="modal-title" id="applicationModalLabel">نموذج التقديم</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="إغلاق"></button>
        </div>

        <div class="modal-body">
          <div class="mb-3">
            <label for="full_name" class="form-label">الاسم الكامل</label>
            <input type="text" name="full_name" id="full_name" class="form-control" required>
          </div>

          <div class="mb-3">
            <label for="age" class="form-label">العمر</label>
            <input type="number" name="age" id="age" class="form-control" required>
          </div>

          <div class="mb-3">
            <label for="major" class="form-label">التخصص</label>
            <input type="text" name="major" id="major" class="form-control" required>
          </div>

          <div class="mb-3">
            <label for="cv_file" class="form-label">السيرة الذاتية (PDF فقط)</label>
            <input type="file" name="cv_file" id="cv_file" class="form-control" accept=".pdf" required>
          </div>
        </div>

        <div class="modal-footer">
          <button type="submit" class="btn btn-success">إرسال</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إغلاق</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
  function setJobId(jobId) {
    document.getElementById('job_id').value = jobId;
  }
</script>
@endsection
