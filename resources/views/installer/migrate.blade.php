@extends('layouts.auth')

@section('content')
    <div class="row justify-content-center">
        @component('components.card', ['class' => 'bg-white col-lg-4 text-center'])
            <form method="POST" action="{{ route('install.migrate') }}">
                @csrf

                @if(session('error'))
                    <div class="row">
                        <div class="col">
                            <div class="alert alert-danger">{{ session('error') }}</div>
                        </div>
                    </div>
                @endif

                <h4 class="mb-4">
                    <i class="far fa-check-circle"></i> Great, we're almost there.
                </h4>

                <p>
                    Now that we've connected to your database, we need to set it up. Simply click the button below.
                </p>

                <hr/>

                <button type="submit" class="btn btn-block btn-primary mt-4">
                    Setup Database
                </button>
            </form>
        @endcomponent
    </div>
@endsection
