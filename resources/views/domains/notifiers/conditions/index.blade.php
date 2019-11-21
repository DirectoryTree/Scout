@extends('domains.layout')

@section('title', __(':notifier Conditions', ['notifier' => $notifier->notifiable_name]))

@section('breadcrumbs', Breadcrumbs::render('domains.notifiers.conditions.index', $domain, $notifier))

@section('page')
    <div data-controller="conditions">
        <div class="card shadow-sm">
            <div class="card-header border-bottom d-flex justify-content-between align-items-center">
                <h6 class="mb-0 font-weight-bold text-secondary">
                    <i class="far fa-flag"></i> Notifier Conditions
                </h6>

                <button
                    type="button"
                    class="btn btn-sm btn-primary"
                    data-action="click->conditions#open"
                    data-target="conditions.button"
                >
                    <i class="fa fa-plus-circle"></i> Add New Condition
                </button>
            </div>

            <div class="card-body bg-light">
                <div class="mb-4" data-target="conditions.container">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <form
                                method="post"
                                action="{{ route('notifiers.conditions.store', $notifier) }}"
                                data-controller="forms--condition"
                            >
                                @include('domains.notifiers.conditions.form', ['condition' => new \App\LdapNotifierCondition()])

                                <hr/>

                                <div class="form-row">
                                    <div class="col">
                                        <button type="button" class="btn btn-sm btn-secondary" data-action="click->conditions#close">
                                            <i class="fa fa-times-circle"></i> {{ __('Cancel') }}
                                        </button>
                                    </div>

                                    <div class="col-auto">
                                        <button type="submit" class="btn btn-sm btn-success">
                                            <i class="fa fa-save"></i> {{ __('Save') }}
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                @forelse($notifier->conditions->groupBy('boolean') as $boolean => $conditions)
                    <div class="row {{ $loop->last && $loop->iteration != 1 ? 'mt-4' : '' }}">
                        <div class="col">
                            @switch($boolean)
                                @case('and')
                                <h6 class="text-uppercase text-muted font-weight-bold">
                                    Generate notification when the following is matched:
                                </h6>
                                @break
                                @case('or')
                                <h6 class="text-uppercase text-muted font-weight-bold">
                                    Or when one of the following is matched:
                                </h6>
                                @break
                            @endswitch
                        </div>
                    </div>

                    @foreach($conditions as $condition)
                        <div class="{{ $loop->last ? '' : 'mb-4' }}" data-controller="expand">
                            <div class="card shadow-sm">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col">
                                            <h5>
                                        <span class="badge badge-primary text-uppercase">
                                            {{ $condition->boolean }}
                                        </span>

                                                <span class="badge badge-success">
                                            {{ $condition->attribute }}
                                        </span>

                                                <span class="badge badge-pill badge-secondary">
                                            {{ $condition->operator_name }}
                                        </span>

                                                @if($condition->value)
                                                    <span class="badge badge-info">
                                               {{ $condition->value }}
                                            </span>
                                                @endif
                                            </h5>
                                        </div>

                                        <div class="col-auto">
                                            <form
                                                class="d-inline"
                                                method="post"
                                                action="{{ route('conditions.destroy', $condition) }}"
                                                data-controller="form-confirmation"
                                                data-form-confirmation-title="Delete Condition?"
                                                data-form-confirmation-message="This cannot be undone."
                                            >
                                                @csrf
                                                @method('delete')
                                                <button type="submit" class="btn btn-sm btn-danger">
                                                    <i class="fa fa-trash-alt"></i>
                                                    Delete
                                                </button>
                                            </form>

                                            <button
                                                type="button"
                                                class="btn btn-sm btn-primary"
                                                data-action="click->expand#open"
                                                data-target="expand.button"
                                            >
                                                <i class="fa fa-plus-circle"></i> Edit Condition
                                            </button>
                                        </div>
                                    </div>

                                    <div data-target="expand.container">
                                        <hr/>

                                        <form
                                            method="post"
                                            action="{{ route('conditions.update', $condition) }}"
                                            data-controller="forms--condition"
                                        >
                                            @csrf
                                            @method('patch')

                                            @include('domains.notifiers.conditions.form')

                                            <hr/>

                                            <div class="form-row justify-content-between">
                                                <div class="col">
                                                    <button
                                                        type="button"
                                                        class="btn btn-sm btn-secondary"
                                                        data-action="click->expand#close"
                                                    >
                                                        <i class="fa fa-times-circle"></i> {{ __('Cancel') }}
                                                    </button>
                                                </div>

                                                <div class="col-auto">
                                                    <button type="submit" class="ml-auto btn btn-sm btn-success">
                                                        <i class="fa fa-save"></i> {{ __('Save') }}
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @empty
                    <div id="alert-no-notifiers" class="alert alert-warning shadow-sm">
                        There are no conditions for this notifier.
                    </div>
                @endforelse
            </div>
        </div>
    </div>
@endsection
