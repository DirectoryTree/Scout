@extends('settings.layout')

@section('title', __('Add User'))

@section('page')
    <div class="row">
        <div class="col-12 col-sm-12 col-md-10 col-lg-8">
            <form method="post" action="{{ route('settings.users.store') }}" data-controller="form">
                <div class="card shadow-sm">
                    <div class="card-header border-bottom">
                        <h6 class="mb-0 text-muted font-weight-bold">
                            <i class="fas fa-user-friends"></i> Add User
                        </h6>
                    </div>

                    <div class="card-body">
                        <div class="form-group">
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

                        <div class="form-group">
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

                        <div class="form-group">
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

                        <div class="form-group">
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

                    <div class="card-footer d-flex justify-content-center bg-light">
                        <button type="submit" class="btn btn-primary">
                            <i class="fa fa-save"></i> Save
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
