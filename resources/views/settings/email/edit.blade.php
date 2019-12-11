@extends('settings.layout')

@section('title', __('Email Settings'))

@inject('drivers', 'App\Http\Injectors\EmailDriverInjector')

@section('page')
    <form method="post" action="{{ route('settings.email.update') }}" data-controller="form">
        @csrf
        @method('patch')

        <div class="card shadow-sm">
            <div class="card-header border-bottom">
                <h6 class="mb-0 text-muted font-weight-bold">{{ __('Email Settings') }}</h6>
            </div>

            <div class="card-body">
                <div data-controller="expandable">
                    <div class="form-group">
                        {{
                            form()->checkbox()
                                ->name('enabled')
                                ->value(true)
                                ->checked(setting('app.email.enabled', false))
                                ->id('enable-email')
                                ->label(__('Enable sending email notifications'))
                                ->data('target', 'expandable.toggle')
                        }}
                    </div>

                    <div data-controller="email" data-target="expandable.container">
                        <hr/>

                        <div class="form-row">
                            <div class="col-12 col-md-3">
                                <div class="form-group">
                                    {{ form()->label()->for('driver')->text('Driver') }}

                                    {{
                                        form()->select()
                                            ->name('driver')
                                            ->value(setting('app.email.driver', 'smtp'))
                                            ->options($drivers->get())
                                            ->data('target', 'form.input email.selector')
                                            ->data('action', 'change->form#clearError')
                                    }}

                                    {{ form()->error()->data('input', 'driver')->data('target', 'form.error') }}
                                </div>
                            </div>

                            <div class="col-12 col-md-3">
                                <div class="form-group">
                                    {{ form()->label()->for('host')->text('Host') }}

                                    {{
                                        form()->input()
                                            ->name('host')
                                            ->value(setting('app.email.host'))
                                            ->placeholder('Enter email host')
                                            ->data('target', 'form.input')
                                            ->data('action', 'keyup->form#clearError')
                                    }}

                                    {{ form()->error()->data('input', 'host')->data('target', 'form.error') }}
                                </div>
                            </div>

                            <div class="col-12 col-md-3">
                                <div class="form-group">
                                    {{ form()->label()->for('port')->text('Port') }}

                                    {{
                                        form()->number()
                                            ->name('port')
                                            ->value(setting('app.email.port', 587))
                                            ->placeholder('Enter port number')
                                            ->data('target', 'form.input')
                                            ->data('action', 'keyup->form#clearError')
                                    }}

                                    {{ form()->error()->data('input', 'port')->data('target', 'form.error') }}
                                </div>
                            </div>

                            <div class="col-12 col-md-3">
                                <div class="form-group">
                                    {{ form()->label()->for('encryption')->text('Encryption') }}

                                    {{
                                        form()->input()
                                            ->name('encryption')
                                            ->value(setting('app.email.encryption', 'tls'))
                                            ->placeholder('Enter mail encryption')
                                            ->data('target', 'form.input')
                                            ->data('action', 'keyup->form#clearError')
                                    }}

                                    {{ form()->error()->data('input', 'encryption')->data('target', 'form.error') }}
                                </div>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="col-12 col-md-4">
                                <div class="form-group">
                                    {{ form()->label()->for('username')->text('Username') }}

                                    {{
                                        form()->input()
                                            ->name('username')
                                            ->value(setting('app.email.username'))
                                            ->placeholder('Enter username')
                                            ->data('target', 'form.input')
                                            ->data('action', 'keyup->form#clearError')
                                    }}

                                    {{ form()->error()->data('input', 'username')->data('target', 'form.error') }}
                                </div>
                            </div>

                            <div class="col-12 col-md-4">
                                <div class="form-group">
                                    {{ form()->label()->for('password')->text('Password') }}

                                    {{
                                        form()->password()
                                            ->name('password')
                                            ->placeholder('Enter password')
                                            ->data('target', 'form.input')
                                            ->data('action', 'keyup->form#clearError')
                                    }}

                                    {{ form()->error()->data('input', 'password')->data('target', 'form.error') }}
                                </div>
                            </div>

                            <div class="col-12 col-md-4">
                                <div class="form-group">
                                    {{ form()->label()->for('password_confirmation')->text('Confirm Password') }}

                                    {{
                                        form()->password()
                                            ->name('password_confirmation')
                                            ->placeholder('Confirm above password')
                                            ->data('target', 'form.input')
                                            ->data('action', 'keyup->form#clearError')
                                    }}

                                    {{ form()->error()->data('input', 'password_confirmation')->data('target', 'form.error') }}
                                </div>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    {{ form()->label()->for('from_name')->text('From Name') }}

                                    {{
                                        form()->input()
                                            ->name('from_name')
                                            ->value(setting('app.email.from.name', 'Scout'))
                                            ->placeholder('John Doe')
                                            ->data('target', 'form.input')
                                            ->data('action', 'keyup->form#clearError')
                                    }}

                                    {{ form()->error()->data('input', 'from_name')->data('target', 'form.error') }}
                                </div>
                            </div>

                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    {{ form()->label()->for('from_address')->text('From Address') }}

                                    {{
                                        form()->email()
                                            ->name('from_address')
                                            ->value(setting('app.email.from.address'))
                                            ->placeholder('jdoe@email.com')
                                            ->data('target', 'form.input')
                                            ->data('action', 'keyup->form#clearError')
                                    }}

                                    {{ form()->error()->data('input', 'from_address')->data('target', 'form.error') }}
                                </div>
                            </div>
                        </div>

                        <div data-target="email.driver" data-type="mailgun">
                            <hr/>

                            <div class="form-row">
                                <div class="col-12 col-md-4">
                                    <div class="form-group">
                                        {{ form()->label()->for('mailgun_domain')->text('Mailgun Domain') }}

                                        {{
                                            form()->email()
                                                ->name('mailgun_domain')
                                                ->value(setting('app.email.mailgun.domain'))
                                                ->placeholder('Your domain name')
                                                ->data('target', 'form.input')
                                                ->data('action', 'keyup->form#clearError')
                                        }}

                                        {{ form()->error()->data('input', 'mailgun_domain')->data('target', 'form.error') }}
                                    </div>
                                </div>

                                <div class="col-12 col-md-4">
                                    <div class="form-group">
                                        {{ form()->label()->for('mailgun_secret')->text('Mailgun Secret') }}

                                        {{
                                            form()->email()
                                                ->name('mailgun_secret')
                                                ->value(setting('app.email.mailgun.secret'))
                                                ->placeholder('Your mailgun secret')
                                                ->data('target', 'form.input')
                                                ->data('action', 'keyup->form#clearError')
                                        }}

                                        {{ form()->error()->data('input', 'mailgun_secret')->data('target', 'form.error') }}
                                    </div>
                                </div>

                                <div class="col-12 col-md-4">
                                    <div class="form-group">
                                        {{ form()->label()->for('mailgun_endpoint')->text('Mailgun Endpoint') }}

                                        {{
                                            form()->email()
                                                ->name('mailgun_endpoint')
                                                ->value(setting('app.email.mailgun.endpoint'))
                                                ->placeholder('Your mailgun endpoint')
                                                ->data('target', 'form.input')
                                                ->data('action', 'keyup->form#clearError')
                                        }}

                                        {{ form()->error()->data('input', 'mailgun_endpoint')->data('target', 'form.error') }}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div data-target="email.driver" data-type="ses">
                            <hr/>

                            <div class="form-row">
                                <div class="col-12 col-md-6">
                                    <div class="form-group">
                                        {{ form()->label()->for('ses_key')->text('SES Key') }}

                                        {{
                                            form()->email()
                                                ->name('ses_key')
                                                ->value(setting('app.email.ses.key'))
                                                ->placeholder('Your SES key')
                                                ->data('target', 'form.input')
                                                ->data('action', 'keyup->form#clearError')
                                        }}

                                        {{ form()->error()->data('input', 'ses_key')->data('target', 'form.error') }}
                                    </div>
                                </div>

                                <div class="col-12 col-md-6">
                                    <div class="form-group">
                                        {{ form()->label()->for('ses_secret')->text('SES Secret') }}

                                        {{
                                            form()->email()
                                                ->name('ses_secret')
                                                ->value(setting('app.email.ses.secret'))
                                                ->placeholder('Your SES secret')
                                                ->data('target', 'form.input')
                                                ->data('action', 'keyup->form#clearError')
                                        }}

                                        {{ form()->error()->data('input', 'ses_secret')->data('target', 'form.error') }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-footer bg-light text-center">
                <button type="submit" class="btn btn-primary">
                    Save
                </button>
            </div>
        </div>
    </form>

    @if(setting('app.email.enabled'))
        <form method="post" action="{{ route('settings.email.test') }}" class="mt-4" data-controller="form">
            @csrf

            <div class="card shadow-sm">
                <div class="card-header border-bottom">
                    <h6 class="mb-0 text-muted font-weight-bold">{{ __('Send Test Email') }}</h6>
                </div>

                <div class="card-body">
                    <div class="form-group">
                        {{ form()->label()->for('email')->text('Email Address') }}

                        {{
                            form()->email()
                                ->name('email')
                                ->placeholder('Enter an email address')
                                ->data('target', 'form.input')
                                ->data('action', 'keyup->form#clearError')
                        }}

                        {{ form()->error()->data('input', 'email')->data('target', 'form.error') }}
                    </div>
                </div>

                <div class="card-footer bg-light text-center">
                    <button type="submit" class="btn btn-outline-primary">
                        <i class="far fa-paper-plane"></i> Send
                    </button>
                </div>
            </div>
        </form>
    @endif
@endsection
