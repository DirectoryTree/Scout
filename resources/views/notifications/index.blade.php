@extends('notifications.layout')

@section('page')
    @if($notifications->isNotEmpty())
        @component('components.card', ['flush' => true])
            <div class="list-group list-group-flush">
                @foreach($notifications as $notification)
                    <div class="list-group-item">
                        <h5>
                            {{ $notification->data['name'] }}
                            on
                            @include('domains.objects.partials.badge', ['object' => $notification->notifiable])
                        </h5>

                        <small>
                            Generated

                            {{ $notification->created_at->diffForHumans() }}

                            ({{ $notification->created_at }})
                        </small>
                    </div>
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
