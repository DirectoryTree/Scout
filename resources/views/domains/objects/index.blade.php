@extends('domains.layout')

@section('title', __('Domain Objects'))

@section('breadcrumbs', Breadcrumbs::render('domains.objects.index', $domain))

@section('page')
    <div class="card bg-white shadow-sm">
        <div class="card-header border-bottom">
            <div class="d-flex justify-content-between align-items-center">
                <h6 class="mb-0 text-muted font-weight-bold">
                    <i class="fa fa-cubes"></i> {{ __('Domain Objects') }}
                </h6>

                <div class="btn-group btn-group-sm">
                    <a
                        href="{{ route('domains.objects.index', [$domain, 'view' => 'tree']) }}"
                        class="btn btn-secondary {{ request('view') === 'tree' ? 'active' : null }}"
                    >
                        <i class="fa fa-sitemap"></i> Tree
                    </a>

                    <a
                        href="{{ route('domains.objects.index', [$domain, 'view' => 'list']) }}"
                        class="btn btn-secondary {{ request('view', 'list') === 'list' ? 'active' : null }}"
                    >
                        <i class="fa fa-list"></i> List
                    </a>
                </div>
            </div>
        </div>

        @if(request('view') === 'tree')
            <div class="card-body py-0">
                <div class="overflow-x py-2">
                    @include('domains.objects.partials.tree')
                </div>
            </div>
        @else
            <div class="card-body p-0">
                @include('domains.objects.partials.list')
            </div>
        @endif
    </div>
@endsection
