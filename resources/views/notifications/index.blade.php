@extends('notifications.layout')

@section('page')
    @if($notifications->isNotEmpty())
        @component('components.card', ['flush' => true])
            <div class="list-group list-group-flush">
                @foreach($notifications as $notification)
                    <div class="list-group-item d-flex align-items-center" data-controller="notification">
                        <div class="mr-3">
                            <div class="dropdown">
                                <button class="btn btn-sm border rounded-pill" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fas fa-ellipsis-v"></i>
                                </button>

                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    @if ($notification->read())
                                        <button class="dropdown-item" data-action="click->notification#markUnread">
                                            <i class="far fa-envelope"></i> Mark Unread
                                        </button>
                                    @else
                                        <button class="dropdown-item" data-action="click->notification#markRead">
                                            <i class="far fa-envelope-open"></i> Mark Read
                                        </button>
                                    @endif

                                    <div class="dropdown-divider"></div>

                                    <a class="dropdown-item" href="#">
                                        <i class="far fa-trash-alt"></i> Delete
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div>
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
