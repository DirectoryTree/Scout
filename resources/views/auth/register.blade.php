@extends('layouts.auth')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            @component('components.card', ['class' => 'bg-white'])
                <h4 class="text-center">Create an Administrator Account</h4>

                <hr/>

                <form method="POST" action="{{ route('register') }}" data-controller="form">
                    @csrf

                    <div class="form-group row justify-content-center">
                        <div class="col-md-6">
                            {{
                                Form::scoutText('name', null, [
                                    'required',
                                    'autofocus',
                                    'placeholder' => 'Name',
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
                        <div class="col-md-6">
                            {{
                                Form::scoutEmail('email', null, [
                                    'required',
                                    'placeholder' => 'Email',
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
                        <div class="col-md-6">
                            {{
                                Form::scoutPassword('password', [
                                    'required',
                                    'placeholder' => 'Password',
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
                        <div class="col-md-6">
                            {{ Form::scoutPassword('password_confirmation', ['required', 'autocomplete' => 'new-password', 'placeholder' => 'Confirm Password']) }}
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
