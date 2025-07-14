@extends('layouts.app')

@section('title', 'طلباتي')

@section('content')
<div class="container" style="padding: 2rem;">
    <h2 class="mb-4">📄 الوظائف التي قدمت عليها</h2>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($applications->isEmpty())
        <div class="alert alert-info">لم تقم بالتقديم على أي وظيفة حتى الآن.</div>
    @else
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>الوظيفة</th>
                    <th>الشركة</th>
                    <th>تاريخ التقديم</th>
                    <th>الحالة</th>
                    <th>السيرة الذاتية</th>
                </tr>
            </thead>
            <tbody>
                @foreach($applications as $app)
                  <tr>
                       <td>{{ $app->job->title ?? 'غير متوفر' }}</td>
                       <td>{{ $app->job->company ?? '-' }}</td>
                       <td>{{ $app->created_at->format('Y-m-d') }}</td>
                       <td>{{ $app->status }}</td>
                       <td>
                       <a href="{{ asset('storage/' . $app->cv_path) }}" class="btn btn-sm btn-outline-primary" target="_blank">عرض السيرة الذاتية</a>
              </td>
</tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
