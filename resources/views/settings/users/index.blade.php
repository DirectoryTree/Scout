@extends('settings.layout')

@section('title', __('Users'))

@section('page')
    <div class="card shadow-sm">
        <div class="card-header border-bottom">
            <h6 class="mb-0 text-muted font-weight-bold">{{ __('Users') }}</h6>
        </div>

        <div class="card-body p-0">
            <div class="list-group list-group-flush">
                @foreach($users as $user)
                    <div class="list-group-item">
                        <a href="{{ route('settings.users.edit', $user) }}" class="h5 font-weight-bold">
                            {{ $user->name }}
                        </a>

                        <p class="text-muted font-weight-bold m-0">
                            {{ $user->email }}
                        </p>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
