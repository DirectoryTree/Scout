@extends('notifications.layout')

@section('page')
    @if($notifications->isNotEmpty())
        @if(request('unread', 'yes') === 'yes')
            <div class="d-flex justify-content-end mb-2">
                <form method="post" action="{{ route('notifications.mark.all') }}" data-controller="form">
                    @csrf
                    @method('patch')

                    <button type="submit" class="btn t btn-sm btn-primary">
                        <i class="far fa-check-circle"></i>

                        Mark All As Read
                    </button>
                </form>
            </div>
        @endif

        @component('components.card', ['class' => 'overflow-hidden', 'flush' => true])
            <div class="list-group list-group-flush">
                @foreach($notifications as $notification)
                    <form method="post" action="{{ route('notifications.mark.update', $notification) }}" data-controller="form">
                        @csrf
                        @method('patch')

                        <input type="hidden" name="read" value="{{ $notification->read() ? '0' : '1' }}">

                        <div class="list-group-item d-flex align-items-center justify-content-between">

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
        @endcomponent
    @else
        @component('components.card', ['class' => 'bg-white'])
            <div class="text-center text-muted">
                {{ __("There are no notifications to list.") }}
            </div>
        @endcomponent
    @endif
@endsection
