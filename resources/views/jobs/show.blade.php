
@extends('layouts.app')

@section('title', $job->title)

@section('content')
<div class="container" style="padding: 2rem;">

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <h2 class="mb-3">{{ $job->title }}</h2>
    <h5 class="text-muted">{{ $job->company }} - {{ $job->location }}</h5>

    <div class="mt-4">
        <h6 class="fw-bold">الوصف الوظيفي:</h6>
        <p>{{ $job->description }}</p>
    </div>

    <div class="mt-5">
        <a href="{{ route('jobs.apply', $job->id) }}" class="btn btn-success">تقديم الآن</a>
        <a href="{{ route('jobs.index') }}" class="btn btn-secondary">رجوع إلى قائمة الوظائف</a>
    </div>
</div>
@endsection
