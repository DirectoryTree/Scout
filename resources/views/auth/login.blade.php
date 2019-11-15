@extends('layouts.auth')

@section('content')
    <div class="row justify-content-center">
        <div class="col-12 col-md-6 col-lg-4">
            <div class="card shadow-sm">
                <div class="card-header bg-light border-bottom border-2">
                    <h5 class="mb-0 text-center text-muted">
                        {{ __('Login') }}
                    </h5>
                </div>

                <div class="card-body">
                    @if($register)
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
                    @else
                        <form method="POST" action="{{ route('login') }}" data-controller="form">
                            @csrf

                            <div class="form-group">
                                {{ Form::scoutLabel('email', __('Email Address')) }}

                                {{
                                    Form::scoutText('email', null, [
                                        'required',
                                        'autofocus',
                                        'data-target' => 'form.input',
                                        'data-action' => 'keyup->form#clearError'
                                    ])
                                }}

                                {{
                                    Form::scoutError([
                                        'data-input' => 'email',
                                        'data-target' => 'form.error'
                                    ])
                                }}
                            </div>

                            <div class="form-group">
                                {{ Form::scoutLabel('password', __('Password')) }}

                                {{
                                    Form::scoutPassword('password', [
                                        'required',
                                        'data-target' => 'form.input',
                                        'data-action' => 'keyup->form#clearError'
                                    ])
                                }}

                                {{
                                     Form::scoutError([
                                         'data-input' => 'password',
                                         'data-target' => 'form.error'
                                     ])
                                 }}
                            </div>

                            <div class="form-group">
                                {{
                                    Form::scoutCheckbox('remember', true, old('remember') != null, [
                                        'id' => 'remember',
                                        'label' => __('Keep me logged in'),
                                    ])
                                }}
                            </div>

                            <button type="submit" class="btn btn-block btn-primary">
                                {{ __('Login') }}
                            </button>
                        </form>
                    @endif
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
            </div>
        </div>
    </div>
@endsection
