@extends('domains.layout')

@section('title', __(':notifier Notifier', ['notifier' => $notifier->notifiable_name]))

@section('breadcrumbs', Breadcrumbs::render('domains.notifiers.show', $domain, $notifier))

@section('page')
    <div class="modal fade" id="select-users-modal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header py-2">
                    <h6 class="modal-title text-muted font-weight-bold">Select Users to Notify</h6>

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i class="fa fa-xs fa-times-circle"></i>
                    </button>
                </div>

                <div class="modal-body">

                </div>
            </div>
        </div>
    </div>

    @if($notifier->system)
        <div class="alert alert-warning shadow-sm">
            <strong>System Notifier -</strong>
            This is a built-in system notifier. You cannot make changes to it.
        </div>
    @endif

    <div class="row mb-4">
        <div class="col">
            <div class="card shadow-sm">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h6 class="mb-0 font-weight-bold text-secondary">
                            <i class="far fa-bell"></i> Notifier
                        </h6>

                        @can('notifier.edit', $notifier)
                            <a href="{{ route('domains.notifiers.edit', [$domain, $notifier]) }}" class="btn btn-sm btn-primary">
                                <i class="far fa-edit"></i> Edit
                            </a>
                        @endcan
                    </div>
                </div>

                <div class="card-body"></div>
            </div>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header">
                    <h6 class="mb-0 font-weight-bold text-secondary">
                        <i class="fas fa-users"></i> Users to Notify
                    </h6>
                </div>

                <div class="card-body">
                    @if($notifier->all_users)
                        <div class="alert alert-info mb-0">
                            <strong>All Scout Users</strong> will be notified.
                        </div>
                    @else

                    @endif
                </div>

                <div class="card-footer">
                    <button
                        type="button"
                        class="btn btn-block btn-primary btn-sm"
                        data-toggle="modal"
                        data-target="#select-users-modal"
                    >Select Users</button>
                </div>
            </div>
        </div>

        @can('notifier.edit', $notifier)
            <div class="col-md-6">
                <div class="card shadow-sm">
                    <div class="card-header">
                        <h6 class="mb-0 font-weight-bold text-secondary">
                            <i class="fa fa-check-double"></i> Conditions
                        </h6>
                    </div>

                    <div class="card-body">
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
                    </div>

                    <div class="card-footer">
                        <a
                            href="{{ route('domains.notifiers.conditions.edit', [$domain, $notifier]) }}"
                            class="btn btn-sm btn-primary btn-block"
                        >
                            @if($conditions->isEmpty())
                                <i class="fas fa-plus-circle"></i> Add Conditions
                            @else
                                <i class="far fa-edit"></i> Modify Conditions
                            @endif
                        </a>
                    </div>
                </div>
            </div>
        @endcan
    </div>
@endsection
