@extends('layouts.auth')

@section('content')
    <div class="row justify-content-center">
        <div class="card shadow-sm col-lg-4 text-center">
            <div class="card-body">
                <form method="POST" action="{{ route('install.migrate') }}" data-controller="form">
                    @csrf

                    @if(session('error'))
                        <div class="row">
                            <div class="col">
                                <div class="alert alert-danger">{{ session('error') }}</div>
                            </div>
                        </div>
                    @endif

                    <h4 class="mb-4 alert alert-success">
                        <i class="far fa-check-circle"></i> Great, we're almost there.
                    </h4>

                    <p>
                        Now that we've connected to your database, we need to set it up.
                        Simply click the button below to begin the process.
                    </p>

                    <hr/>

                    <button type="submit" class="btn btn-block btn-primary mt-4">
                        Setup Database
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection
