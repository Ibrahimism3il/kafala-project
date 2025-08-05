@extends('layouts.app')

@section('content')
<div class="container">
    <h3>الإشعارات</h3>

    @forelse ($notifications as $notification)
        <div class="card mb-2 @if(is_null($notification->read_at)) bg-light @endif">
            <div class="card-body">
                <h5>{{ $notification->data['title'] }}</h5>
                <p>{{ $notification->data['message'] }}</p>
                <small class="text-muted">{{ $notification->created_at->diffForHumans() }}</small>
                <div class="mt-2">
                    <a href="{{ route('notifications.read', $notification->id) }}" class="btn btn-sm btn-primary">تحديد كمقروء</a>
                    <form method="POST" action="{{ route('notifications.delete', $notification->id) }}" class="d-inline">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-danger">حذف</button>
                    </form>
                </div>
            </div>
        </div>
    @empty
        <p>لا يوجد إشعارات.</p>
    @endforelse
</div>
@endsection
