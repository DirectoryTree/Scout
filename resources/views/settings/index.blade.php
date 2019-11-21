@extends('settings.layout')

@section('title', __('Application Settings'))

@section('page')
    <form>
        <div class="card shadow-sm">
            <div class="card-header border-bottom">
                <h6 class="mb-0 text-muted font-weight-bold">{{ __('Application Settings') }}</h6>
            </div>

            <div class="card-body">
                <div class="form-group">
                    {{
                        Form::scoutCheckbox('pinning', true, old('pinning', setting('app.pinning', true)) != null, [
                            'id' => 'pinning',
                            'label' => __('Enable pinning objects to dashboard'),
                        ])
                    }}

                    <small class="text-muted">
                        Disabling pinning will only hide the pin buttons and remove the pinning section from all user dashboards.
                    </small>
                </div>

                <div class="form-group">
                    {{
                        Form::scoutCheckbox('calendar', true, old('calendar', setting('app.calendar', true)) != null, [
                            'id' => 'calendar',
                            'label' => __('Enable dashboard change calendar'),
                        ])
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
