@extends('domains.layout')

@section('breadcrumbs', Breadcrumbs::render('domains.show', $domain))

@section('page')
    <div class="row">
        <div class="col-lg-4 col-md-6 col-sm-12 mb-4 mb-md-0">
            <div class="card shadow-sm">
                <div class="card-header">
                    <h6 class="mb-0 text-muted font-weight-bold">
                        Domain Status
                    </h6>
                </div>

                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <h4 class="mb-0 pr-2">
                            @component('components.status', [
                                'status' => $domain->status == \App\LdapDomain::STATUS_ONLINE
                            ])@endcomponent
                        </h4>

                        <div class="flex-column">
                            <h4 class="mb-n2">
                                @switch($domain->status)
                                    @case(\App\LdapDomain::STATUS_OFFLINE)
                                    Offline
                                    @break
                                    @case(\App\LdapDomain::STATUS_INVALID_CREDENTIALS)
                                    Invalid Credentials
                                    @break
                                    @default
                                    Online
                                    @break
                                @endswitch
                            </h4>

                            <small class="text-muted">
                                @if($domain->attempted_at)
                                    {{ $domain->attempted_at->diffForHumans() }}
                                @else
                                    <em>Never</em>
                                @endif
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-6 col-sm-12 mb-4 mb-md-0">
            <div class="card shadow-sm">
                <div class="card-header">
                    <h6 class="font-weight-bold text-muted mb-0">Last Synchronization</h6>
                </div>

                <div class="card-body py-2">
                    <h4 class="mb-0">
                        @if($synchronizedAt && $synchronizedAt->completed_at)
                            <span title="{{ $synchronizedAt->completed_at }}">
                            {{ $synchronizedAt->completed_at->diffForHumans() }}
                        </span>
                        @else
                            <em class="text-muted">Never</em>
                        @endif
                    </h4>
                </div>

                <div class="card-footer">
                    <form method="post" action="{{ route('domains.synchronize', $domain) }}" data-controller="form">
                        @csrf

                        <button type="submit" class="btn btn-block btn-sm btn-primary">
                            <i class="fa fa-sync"></i> Sync Now
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-6 col-sm-12 mb-4 mb-md-0">
            <div class="card shadow-sm">
                <div class="card-header">
                    <h6 class="font-weight-bold text-muted mb-0">Changes Today</h6>
                </div>

                <div class="card-body py-2">
                    <h4 class="mb-0">{{ $changesToday }}</h4>
                </div>

                <div class="card-footer">
                    <a href="#" class="btn btn-block btn-sm btn-primary">
                        <i class="fas fa-search"></i> View Changes
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
