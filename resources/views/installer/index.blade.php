@extends('layouts.auth')

@section('content')
    <div class="row justify-content-center">
        @component('components.card', ['class' => 'bg-white col-lg-8'])
            <form method="POST" action="{{ route('install.store') }}">
                @csrf

                <div class="row">
                    <div class="col-md-6 border-right">
                        <h2 class="mb-0">Welcome to Scout</h2>

                        <p class="text-muted">Scout audits your LDAP directory so you don't have to.</p>

                        <h4>Requirements</h4>

                        <div class="list-group">
                            @foreach($requirements as $requirement)
                                <div class="list-group-item">
                                    {{ $requirement->name() }} - {{ $requirement->description() }}
                                </div>
                            @endforeach
                        </div>

                        <p>
                            To get started with installation, we're going to need
                            your database information to start storing things.
                        </p>
                    </div>

                    <div class="col-md-6">
                        @include('installer.form')
                    </div>
                </div>

                <hr/>

                <div class="row justify-content-center">
                    <div class="col-md-6">
                        <button type="submit" class="btn btn-primary btn-block">
                            Install
                        </button>
                    </div>
                </div>
            </form>
        @endcomponent
    </div>
@endsection
