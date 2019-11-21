@extends('layouts.auth')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-12 col-sm-8 col-md-6 col-lg-4">
            <div class="card shadow-sm">
                <div class="card-header bg-light">
                    <h5 class="mb-0 text-center">
                        {{ __('Reset Password') }}
                    </h5>
                </div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.email') }}" data-controller="form">
                        @csrf

                        <div class="form-group">
                            {{ form()->label()->for('email')->text(__('Email Address')) }}

                            {{
                                form()->input()
                                    ->name('email')
                                    ->autofocus()
                                    ->data('target', 'form.input')
                                    ->data('action', 'change->form#clearError')
                            }}

                            {{
                                form()->error()
                                    ->data('input', 'email')
                                    ->data('target', 'form.error')
                            }}
                        </div>

                        <button type="submit" class="btn btn-block btn-primary">
                            {{ __('Send Password Reset Link') }}
                        </button>
                    </form>
                </div>

                <div class="card-footer bg-light text-center">
                    <a href="{{ route('login') }}">
                        {{ __('Did you remember?') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
