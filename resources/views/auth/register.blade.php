@extends('layouts.auth')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            @component('components.card', ['class' => 'bg-white'])
                <h4 class="text-center">Create an Administrator Account</h4>

                <hr/>

                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <div class="form-group row justify-content-center">
                        <div class="col-md-6">
                            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" placeholder="Name" required autocomplete="name" autofocus>

                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row justify-content-center">
                        <div class="col-md-6">
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" placeholder="Email Address" required autocomplete="email">

                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row justify-content-center">
                        <div class="col-md-6">
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="Password" required autocomplete="new-password">

                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row justify-content-center">
                        <div class="col-md-6">
                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" placeholder="Confirm Password" required autocomplete="new-password">
                        </div>
                    </div>

                    <hr/>

                    <div class="form-group row justify-content-center mb-0">
                        <div class="col-md-4">
                            <button type="submit" class="btn btn-block btn-primary">
                                {{ __('Register') }}
                            </button>
                        </div>
                    </div>
                </form>
            @endcomponent
        </div>
    </div>
@endsection
