@extends('settings.layout')

@section('title', __('Email Settings'))

@section('page')
    <form>
        <div class="card shadow-sm">
            <div class="card-header border-bottom">
                <h6 class="mb-0 text-muted font-weight-bold">{{ __('Email Settings') }}</h6>
            </div>

            <div class="card-body">
                <div class="form-group">
                    {{
                        form()->checkbox()
                            ->name('enabled')
                            ->value(true)
                            ->id('enable-email')
                            ->label(__('Enable sending email'))
                    }}
                </div>
            </div>
        </div>
    </form>
@endsection
