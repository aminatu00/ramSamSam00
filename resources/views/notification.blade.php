@extends('layouts.template')
@section('content')
<div class="col-md-8">
    <div class="card">
        <div class="card-header">Notifications</div>
        <div class="card-body">
            @if(auth()->user()->user_type === 'admin')
            <ul>
                @foreach($notifications as $notification)
                <li>
                    <a href="{{ route('admin.notification.show', $notification->data['question_id']) }}">
                        {{ $notification->data['message'] ?? 'Notification sans message' }}
                    </a>
                </li>
                @endforeach
            </ul>
            @else
            @if($notifications->isEmpty())
            <div class="alert alert-info" role="alert">
                Aucune notification pour le moment.
            </div>
            @else
            @foreach ($notifications as $notification)
            <div class="alert alert-info" role="alert">
                @if(isset($notification->data['message']))
                <a href="{{ $notification->data['link'] ?? '#' }}">
                    {{ $notification->data['message'] }}
                </a>
                @else
                Notification sans message.
                @endif
            </div>
            @endforeach
            @endif
            @endif
        </div>
    </div>
</div>
@endsection