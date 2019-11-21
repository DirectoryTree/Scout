@extends('notifications.layout')

@section('title', __('Notifications'))

@section('page')
    @if($notifications->isNotEmpty())
        <div class="card shadow-sm overflow-hidden">
            <div class="card-body p-0">
                <div class="list-group list-group-flush">
                    @foreach($notifications as $notification)
                        <form method="post" action="{{ route('notifications.mark.update', $notification) }}" data-controller="form">
                            @csrf
                            @method('patch')

                            <input type="hidden" name="read" value="{{ $notification->read() ? '0' : '1' }}">

                            <div class="list-group-item border-0 d-flex align-items-center justify-content-between">
                                <div class="mr-2">
                                    <h5>
                                        {{ $notification->data['notifier']['notifiable_name'] }}
                                        on
                                        @include('domains.objects.partials.badge', ['object' => $notification->data['object']])
                                    </h5>

                                    <p>
                                        @if(array_key_exists('logs', $notification->data))
                                            @foreach($notification->data['logs'] as $log)
                                                <a href="#">Log # {{ $log }}</a>
                                            @endforeach
                                        @endif
                                    </p>

                                    <small>
                                        Generated

                                        {{ $notification->created_at->diffForHumans() }}

                                        ({{ $notification->created_at }})
                                    </small>
                                </div>

                                @if ($notification->read())
                                    <button type="submit" class="btn btn-sm btn-dark">
                                        <i class="far fa-envelope"></i>
                                        <span class="d-none d-md-inline">Mark Unread</span>
                                    </button>
                                @else
                                    <button type="submit" class="btn btn-sm btn-dark">
                                        <i class="far fa-envelope-open"></i>
                                        <span class="d-none d-md-inline">Mark Read</span>
                                    </button>
                                @endif
                            </div>
                        </form>
                    @endforeach
                </div>
            </div>
        </div>
    @else
        <div class="card shadow-sm">
            <div class="card-body">
                <div class="text-center text-muted">
                    {{ __("There are no notifications to list.") }}
                </div>
            </div>
        </div>
    @endif
@endsection
