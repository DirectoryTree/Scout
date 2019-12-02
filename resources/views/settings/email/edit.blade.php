@extends('settings.layout')

@section('title', __('Email Settings'))

@section('page')
    <form method="post" action="#" data-controller="form">
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
                                ->id('enable-email')
                                ->label(__('Enable sending email notifications'))
                                ->data('target', 'expandable.toggle')
                        }}
                    </div>

                    <div data-target="expandable.container">
                        <hr/>

                        <div class="form-group">
                            {{ form()->label()->for('driver')->text('Driver') }}

                            {{
                                form()->select()
                                    ->name('driver')
                                    ->options(['smtp' => 'SMTP'])
                            }}
                        </div>

                        <div class="form-group">
                            {{ form()->label()->for('port')->text('Port') }}

                            {{
                                form()->number()
                                    ->name('port')
                                    ->value('')
                                    ->placeholder('Enter port number')
                            }}
                        </div>

                        <div class="form-group">
                            {{ form()->label()->for('encryption')->text('Encryption') }}

                            {{
                                form()->input()
                                    ->name('encryption')
                                    ->value('')
                                    ->placeholder('Enter mail encryption')
                            }}
                        </div>

                        <div class="form-group">
                            {{ form()->label()->for('username')->text('Username') }}

                            {{
                                form()->input()
                                    ->name('username')
                                    ->value('')
                                    ->placeholder('Enter username')
                            }}
                        </div>

                        <div class="form-group">
                            {{ form()->label()->for('password')->text('Password') }}

                            {{
                                form()->password()
                                    ->name('password')
                                    ->placeholder('Enter password')
                            }}
                        </div>

                        <div class="form-group">
                            {{ form()->label()->for('password_confirmation')->text('Confirm Password') }}

                            {{
                                form()->password()
                                    ->name('password_confirmation')
                                    ->placeholder('Confirm above password')
                            }}
                        </div>

                        <div class="form-group">
                            {{ form()->label()->for('from_name')->text('From Name') }}

                            {{
                                form()->input()
                                    ->name('from_name')
                                    ->value('')
                                    ->placeholder('John Doe')
                            }}
                        </div>

                        <div class="form-group">
                            {{ form()->label()->for('from_address')->text('From Address') }}

                            {{
                                form()->email()
                                    ->name('from_address')
                                    ->value('')
                                    ->placeholder('jdoe@email.com')
                            }}
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
@endsection
