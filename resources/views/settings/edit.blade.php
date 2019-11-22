@extends('settings.layout')

@section('title', __('Application Settings'))

@section('page')
    <form method="post" action="{{ route('settings.update') }}" data-controller="form">
        @csrf
        @method('patch')

        <div class="card shadow-sm">
            <div class="card-header border-bottom">
                <h6 class="mb-0 text-muted font-weight-bold">{{ __('Application Settings') }}</h6>
            </div>

            <div class="card-body">
                <div class="form-group">
                    {{
                        form()->checkbox()
                            ->name('pinning')
                            ->value(true)
                            ->checked(setting('app.pinning', true))
                            ->id('pinning')
                            ->label(__('Enable pinning objects to dashboard'))
                            ->data('target', 'form.input')
                    }}

                    <small class="text-muted">
                        Disabling pinning will only hide the pin buttons and remove the pinning section from all user dashboards.
                    </small>
                </div>

                <div class="form-group">
                    {{
                        form()->checkbox()
                            ->name('calendar')
                            ->value(true)
                            ->checked(setting('app.calendar', true))
                            ->id('calendar')
                            ->label(__('Enable dashboard change calendar'))
                            ->data('target', 'form.input')
                    }}

                    <small class="text-muted">
                        Disabling this option will remove the change calendar from all user dashboards.
                    </small>
                </div>
            </div>

            <div class="card-footer bg-light d-flex justify-content-center">
                <button type="submit" class="btn btn-primary">
                    <i class="fa fa-save"></i> Save
                </button>
            </div>
        </div>
    </form>
@endsection
