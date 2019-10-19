@extends('notifications.layout')

@section('page')
    @if($notifications->isNotEmpty())
        @component('components.card', ['class' => 'overflow-hidden', 'flush' => true])
            <div class="list-group list-group-flush">
                @foreach($notifications as $notification)
                    <form method="post" action="{{ route('api.notifications.mark.update', $notification) }}" data-controller="form">
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
