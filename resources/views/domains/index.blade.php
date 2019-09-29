@extends('layouts.app')

@section('content')
    <div class="row py-2">
        <div class="col">
            <h2>{{ __('Domains') }}</h2>
        </div>

        <div class="col text-right">
            <a href="{{ route('domains.create') }}" class="btn btn-success">
                <i class="fa fa-plus-circle"></i> {{ __('Add') }}
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col">
            @forelse($domains as $domain)
                @component('components.card', ['class' => 'bg-white mb-4'])
                    <a class="h4" href="{{ route('domains.show', $domain) }}">
                        {{ $domain->name }}
                    </a>

                    <hr/>

                    <hr/>

                    <small>
                        {{ __('Last Synchronized') }}:

                        @if ($domain->synchronized_at)
                            {{ $domain->synchronized_at->diffForHumans() }}
                        @else
                            <em>Never</em>
                        @endif

                        |

                        {{ __('Created By') }}:

                        {{ $domain->creator->name }}
                    </small>
                @endcomponent
            @empty
                @component('components.card', ['class' => 'bg-white'])
                    <div class="text-center text-muted">
                        {{ __("You don't have any domains configured. Click the 'Add' button to get started.") }}
                    </div>
                @endcomponent
            @endforelse
        </div>
    </div>
@endsection
