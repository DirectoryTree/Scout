@extends('domains.layout')

@section('breadcrumbs', Breadcrumbs::render('domains.notifiers.show', $domain, $notifier))

@section('page')
    @if($notifier->system)
        <div class="alert alert-warning">
            <strong>System Notifier -</strong>

            This is a built-in system notifier. You cannot make changes to it.
        </div>
    @endif

    <div class="row">
        <div class="col">
            @component('components.card', ['class' => 'mb-4 bg-white'])
                @slot('header')
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0"><i class="far fa-bell"></i> Notifier</h5>

                        @can('notifier.edit', $notifier)
                            <a href="{{ route('domains.notifiers.edit', [$domain, $notifier]) }}" class="btn btn-sm btn-primary">
                                <i class="far fa-edit"></i> Edit
                            </a>
                        @endcan
                    </div>
                @endslot

                <div class="row">
                    <div class="col"></div>
                </div>
            @endcomponent
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            @component('components.card')
                @slot('header')
                    <h5 class="mb-0">
                        <i class="fas fa-users"></i> Users to Notify
                    </h5>
                @endslot

                @if($notifier->all_users)
                    <div class="alert alert-info mb-0">
                        <strong>All Scout Users</strong> will be notified.
                    </div>
                @else

                @endif

                @slot('footer')
                    <a href="#" class="btn btn-sm btn-block btn-primary">
                        Select Users
                    </a>
                @endslot
            @endcomponent
        </div>

        @can('notifier.edit', $notifier)
            <div class="col-md-6">
                @component('components.card')
                    @slot('header')
                        <h5 class="mb-0">
                            <i class="fa fa-check-double"></i> Conditions
                        </h5>
                    @endslot

                    @if($conditions->isEmpty())
                        <div class="alert alert-warning mb-0">
                            <strong>No Conditions</strong> have been added.
                        </div>
                    @else
                        <div class="alert alert-info mb-0">
                            <strong>{{ $conditions->count() }}</strong>

                            {{ \Illuminate\Support\Str::plural('condition', $conditions->count()) }} must pass.
                        </div>
                    @endif

                    @slot('footer')
                        <a
                            href="{{ route('domains.notifiers.conditions.edit', [$domain, $notifier]) }}"
                            class="btn btn-sm btn-primary btn-block"
                        >
                            @if($conditions->isEmpty())
                                Add Conditions
                            @else
                                Modify Conditions
                            @endif
                        </a>
                    @endslot
                @endcomponent
            </div>
        @endcan
    </div>
@endsection
