@extends('domains.layout')

@section('title', __('Recent Scans'))

@section('breadcrumbs', Breadcrumbs::render('domains.scans.index', $domain))

@section('page')
    <div class="card shadow-sm bg-white">
        <div class="card-header border-bottom">
            <h6 class="mb-0 font-weight-bold text-secondary">
                <i class="fa fa-heartbeat"></i> {{ __('Recent Scans') }}
            </h6>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                @include('domains.scans.partials.table')
            </div>
        </div>
    </div>

    <div class="row my-4">
        <div class="col">
            <div class="d-flex justify-content-center">
                {{ $scans->appends(request()->query())->links() }}
            </div>
        </div>
    </div>
@endsection
