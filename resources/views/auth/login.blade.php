@extends('layouts.auth')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-4">
            @component('components.card', ['class' => 'bg-white'])
                @if ($register)
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
                            <label for="email" class="font-weight-bold">{{ __('Email Address') }}</label>

                            <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required autofocus>

                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="password" class="font-weight-bold">{{ __('Password') }}</label>

                            <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <div class="custom-control custom-checkbox">
                                <input name="remember" type="checkbox" class="custom-control-input" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                <label class="custom-control-label" for="remember">{{ __('Keep me logged in') }}</label>
                            </div>
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
