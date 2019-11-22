@extends('settings.layout')

@section('title', $user->name)

@section('page')
    <div class="row">
        <div class="col-12 col-sm-12 col-md-10 col-lg-6">
            <form method="post" action="#" class="mb-4">
                <div class="card shadow-sm">
                    <div class="card-header border-bottom">
                        <h6 class="mb-0 text-muted font-weight-bold">
                            <i class="fas fa-user-circle"></i> Edit Profile
                        </h6>
                    </div>

                    <div class="card-body">
                        <div class="form-group">
                            {{ form()->label()->for('name')->text('Name') }}

                            {{
                                form()->input()
                                    ->name('name')
                                    ->value($user->name)
                                    ->autofocus()
                                    ->required()
                                    ->placeholder('Enter name')
                                    ->data('target', 'form.input')
                            }}

                            {{ form()->error()->data('input', 'name')->data('target', 'form.error') }}
                        </div>

                        <div class="form-group">
                            {{ form()->label()->for('email')->text('Email') }}

                            {{
                                form()->email()
                                    ->name('email')
                                    ->value($user->email)
                                    ->required()
                                    ->placeholder('Enter email')
                                    ->data('target', 'form.input')
                            }}

                            {{ form()->error()->data('input', 'email')->data('target', 'form.error') }}
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

        <div class="col-12 col-sm-12 col-md-10 col-lg-6">
            <form>
                <div class="card shadow-sm">
                    <div class="card-header border-bottom">
                        <h6 class="mb-0 text-muted font-weight-bold">
                            <i class="fas fa-key"></i> Change Password
                        </h6>
                    </div>

                    <div class="card-body">
                        <div class="form-group">
                            {{ form()->label()->for('password')->text('Password') }}

                            {{
                                form()->password()
                                    ->name('password')
                                    ->placeholder('Enter password')
                                    ->data('target', 'form.input')
                            }}

                            {{ form()->error()->data('input', 'password')->data('target', 'form.error') }}
                        </div>

                        <div class="form-group">
                            {{ form()->label()->for('password_confirmation')->text('Confirm Password') }}

                            {{
                                form()->password()
                                    ->name('password_confirmation')
                                    ->placeholder('Confirm above password')
                                    ->data('target', 'form.input')
                            }}

                            {{ form()->error()->data('input', 'password')->data('target', 'form.error') }}
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
