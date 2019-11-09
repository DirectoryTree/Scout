@extends('layouts.auth')

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
                                {{ Form::scoutLabel('name', 'Name') }}

                                {{
                                    Form::scoutText('name', null, [
                                        'required',
                                        'autofocus',
                                        'placeholder' => 'Enter your name',
                                        'data-target' => 'form.input',
                                        'data-action' => 'keyup->form#clearError'
                                    ])
                                }}

                                {{
                                     Form::scoutError([
                                         'data-input' => 'name',
                                         'data-target' => 'form.error'
                                     ])
                                 }}
                            </div>
                        </div>

                        <div class="form-group row justify-content-center">
                            <div class="col-sm-12 col-md-8 col-lg-6">
                                {{ Form::scoutLabel('email', 'Email') }}

                                {{
                                    Form::scoutEmail('email', null, [
                                        'required',
                                        'placeholder' => 'Enter your email',
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
                        </div>

                        <div class="form-group row justify-content-center">
                            <div class="col-sm-12 col-md-8 col-lg-6">
                                {{ Form::scoutLabel('password', 'Password') }}

                                {{
                                    Form::scoutPassword('password', [
                                        'required',
                                        'placeholder' => 'Enter a password',
                                        'autocomplete' => 'new-password',
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
                        </div>

                        <div class="form-group row justify-content-center">
                            <div class="col-sm-12 col-md-8 col-lg-6">
                                {{ Form::scoutLabel('password_confirmation', 'Confirm Password') }}

                                {{
                                    Form::scoutPassword('password_confirmation', [
                                        'required',
                                        'autocomplete' => 'new-password',
                                        'placeholder' => 'Confirm your above password'
                                    ])
                                }}
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
                </div>
            </div>
        </div>
    </div>
@endsection
