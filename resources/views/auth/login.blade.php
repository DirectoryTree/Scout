@extends('layouts.auth')

@section('title', 'Login')

@section('content')
    <div class="row justify-content-center">
        <div class="col-12 col-md-6 col-lg-4">
            <div class="card shadow-sm">
                @if($register)
                    <div class="card-body">
                        <div class="text-center">
                            <h4 class="text-muted font-weight-bold">Welcome</h4>

                            <hr/>

                            <p>Thanks for installing Scout.</p>

                            <p>
                                To get started, click the register button to create an administrator account.
                            </p>

                            <hr/>

                            <a class="btn btn-block btn-primary" href="{{ route('register') }}">Register</a>
                        </div>
                    </div>
                @else
                    <div class="card-header bg-light border-bottom border-2">
                        <h5 class="mb-0 text-center text-muted">
                            {{ __('Login') }}
                        </h5>
                    </div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('login') }}" data-controller="form">
                            @csrf

                            <div class="form-group">
                                {{ form()->label()->for('email')->text(__('Email Address')) }}

                                {{
                                    form()->input()
                                        ->name('email')
                                        ->required()
                                        ->autofocus()
                                        ->data('target', 'form.input')
                                        ->data('action', 'keyup->form#clearError')
                                }}

                                {{
                                    form()->error()
                                        ->data('input', 'email')
                                        ->data('target', 'form.error')
                                }}
                            </div>

                            <div class="form-group">
                                {{ form()->label()->for('password')->text(__('Password')) }}

                                {{
                                    form()->password()
                                        ->name('password')
                                        ->required()
                                        ->data('target', 'form.input')
                                        ->data('action', 'keyup->form#clearError')
                                }}

                                {{
                                    form()->error()
                                        ->data('input', 'password')
                                        ->data('target', 'form.error')
                                }}
                            </div>

                            <div class="form-group">
                                {{
                                    form()->checkbox()
                                        ->name('remember')
                                        ->value(true)
                                        ->id('remember')
                                        ->label('Keep me logged in')
                                }}
                            </div>

                            <button type="submit" class="btn btn-block btn-primary">
                                {{ __('Login') }}
                            </button>
                        </form>
                    </div>

                    @if(\App\Scout::email()->enabled())
                        <div class="card-footer bg-light">
                            <div class="text-center">
                                <a href="{{ route('password.request') }}">
                                    {{ __('Forgot Your Password?') }}
                                </a>
                            </div>
                        </div>
                    @endif
                @endif
            </div>
        </div>
    </div>
@endsection
