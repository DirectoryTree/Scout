@extends('layouts.auth')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-4">
            @component('components.card', ['class' => 'bg-white'])
                @if($register)
                    <h4>Welcome</h4>

                    <hr/>

                    <p>Thanks for installing Scout.</p>

                    <p>
                        To get started, click the register button to create an administrator account.
                    </p>

                    <hr/>

                    <a class="btn btn-block btn-primary" href="{{ route('register') }}">Register</a>
                @else
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="form-group">
                            {{ Form::scoutLabel('email', __('Email Address')) }}

                            {{ Form::scoutText('email', null, ['required', 'autofocus']) }}

                            {{ Form::scoutError('email') }}
                        </div>

                        <div class="form-group">
                            {{ Form::scoutLabel('password', __('Password')) }}

                            {{ Form::scoutPassword('password', ['required']) }}

                            {{ Form::scoutError('password') }}
                        </div>

                        <div class="form-group">
                            {{
                                Form::scoutCheckbox('remember', true, old('remember') != null, [
                                    'id' => 'remember',
                                    'label' => __('Keep me logged in'),
                                ])
                            }}
                        </div>

                        <div class="form-group {{ Route::has('password.request') ? null : 'mb-0' }}">
                            <button type="submit" class="btn btn-block btn-primary">
                                {{ __('Login') }}
                            </button>
                        </div>

                        @if (Route::has('password.request'))
                            <div class="text-center">
                                <a href="{{ route('password.request') }}">
                                    {{ __('Forgot Your Password?') }}
                                </a>
                            </div>
                        @endif
                    </form>
                @endif
            @endcomponent
        </div>
    </div>
@endsection
