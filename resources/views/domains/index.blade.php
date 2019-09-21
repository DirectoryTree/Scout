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
                @component('components.card', ['class' => 'bg-white'])
                    <div class="d-flex justify-content-between">
                        <a class="h4" href="{{ route('domains.show', $domain) }}">
                            {{ $domain->name }}
                        </a>

                        <div class="dropdown">
                            <button class="btn btn-sm btn-outline-secondary" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-ellipsis-v"></i>
                            </button>

                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="{{ route('domains.edit', $domain) }}">
                                    <i class="fa fa-edit"></i> Edit
                                </a>

                                <div class="dropdown-divider"></div>

                                <form-confirm
                                    action="{{ route('domains.destroy', $domain) }}"
                                    method="post"
                                    title="Delete domain?"
                                    message="You cannot undo this action."
                                >
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit" class="dropdown-item no-loading">
                                        <i class="fa fa-trash"></i> Delete
                                    </button>
                                </form-confirm>
                            </div>
                        </div>
                    </div>

                    <hr/>
                        Test
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
