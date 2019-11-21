@extends('layouts.auth')

@section('title', 'Create an Account')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h4 class="text-center">Create an Administrator Account</h4>

                    <hr/>

                    <form method="POST" action="{{ route('register') }}" data-controller="form">
                        @csrf

                        <div class="form-group row justify-content-center">
                            <div class="col-sm-12 col-md-8 col-lg-6">
                                {{ form()->label()->for('name')->text(__('Name')) }}

                                {{
                                    form()->input()
                                        ->name('name')
                                        ->required()
                                        ->autofocus()
                                        ->placeholder('Enter your name')
                                        ->data('target', 'form.input')
                                        ->data('action', 'keyup->form#clearError')
                                }}

                                {{ form()->error()->data('input', 'name')->data('target', 'form.error') }}
                            </div>
                        </div>

                        <div class="form-group row justify-content-center">
                            <div class="col-sm-12 col-md-8 col-lg-6">
                                {{ form()->label()->for('email')->text(__('Email')) }}

                                {{
                                    form()->input()
                                        ->name('email')
                                        ->required()
                                        ->placeholder('Enter your email')
                                        ->data('target', 'form.input')
                                        ->data('action', 'keyup->form#clearError')
                                }}

                                {{ form()->error()->data('input', 'email')->data('target', 'form.error') }}
                            </div>
                        </div>

                        <div class="form-group row justify-content-center">
                            <div class="col-sm-12 col-md-8 col-lg-6">
                                {{ form()->label()->for('password')->text(__('Password')) }}

                                {{
                                    form()->password()
                                        ->name('password')
                                        ->required()
                                        ->placeholder('Enter a password')
                                        ->attribute('autocomplete', 'new-password')
                                        ->data('target', 'form.input')
                                        ->data('action', 'keyup->form#clearError')
                                }}

                                {{ form()->error()->data('input', 'password')->data('target', 'form.error') }}
                            </div>
                        </div>

                        <div class="form-group row justify-content-center">
                            <div class="col-sm-12 col-md-8 col-lg-6">
                                {{ form()->label()->for('password_confirmation')->text(__('Confirm Password')) }}

                                {{
                                    form()->password()
                                        ->name('password_confirmation')
                                        ->required()
                                        ->placeholder('Confirm your above password')
                                        ->attribute('autocomplete', 'new-password')
                                        ->data('target', 'form.input')
                                        ->data('action', 'keyup->form#clearError')
                                }}
                            </div>
                        </div>

                        <hr/>

                        <div class="form-group row justify-content-center mb-0">
                            <div class="col-12 col-sm-8 col-md-6">
                                <button type="submit" class="btn btn-block btn-primary">
                                    {{ __('Register') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
