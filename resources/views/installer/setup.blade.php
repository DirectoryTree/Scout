<div class="row justify-content-center">
    @component('components.card', ['class' => 'bg-white col-lg-8'])
        <form method="POST" action="{{ route('install.store') }}">
            @csrf

            @if(session('error'))
                <div class="row">
                    <div class="col">
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    </div>
                </div>
            @endif

            <div class="row">
                <div class="col-md-6 border-right">
                    <h2 class="text-center mb-0">Welcome to Scout</h2>

                    <p class="text-center text-muted">Scout audits your LDAP directory so you don't have to.</p>

                    <div class="list-group mb-3">
                        @foreach($requirements->get() as $requirement)
                            <div class="list-group-item">
                                <div class="d-flex align-items-center justify-content-between mb-1">
                                    <h5 class="mb-0">{{ $requirement->name() }}</h5>

                                    @component('components.status', ['status' => $requirement->passes()])
                                        {{ $requirement->passes() ? 'Passes' : 'Fails' }}
                                    @endcomponent
                                </div>

                                <small class="text-muted">{{ $requirement->description() }}</small>
                            </div>
                        @endforeach
                    </div>

                    @if($requirements->passes())
                        <p>
                            Your server passes all of the installation requirements.
                        </p>

                        <p>
                            To get started with installation, we're going to need
                            your database information to start storing things.
                        </p>
                    @else
                        <p>
                            It looks like your server does not have one of the above requirements.
                        </p>

                        <p>
                            Verify your server installation and refresh this page once you've corrected the issues.
                        </p>
                    @endif
                </div>

                <div class="col-md-6">
                    @include('installer.form')
                </div>
            </div>

            <hr/>

            <div class="row justify-content-center">
                <div class="col-md-6">
                    <button
                        type="submit"
                        class="btn btn-primary btn-block"
                        {{ !$requirements->passes() ? 'disabled' : null }}
                    >
                        Connect
                    </button>
                </div>
            </div>
        </form>
    @endcomponent
</div>
