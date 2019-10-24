@extends('domains.layout')

@section('breadcrumbs', Breadcrumbs::render('domains.objects.index', $domain))

@section('page')
    @component('components.card', ['class' => 'bg-white', 'flush' => request('view') === 'tree' ? false : true])
        @slot('header')
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0">{{ __('Domain Objects') }}</h5>

                <div class="btn-group">
                    <a
                        href="{{ route('domains.objects.index', [$domain, 'view' => 'tree']) }}"
                        class="btn btn-sm btn-secondary {{ request('view') === 'tree' ? 'active' : null }}"
                    >
                        <i class="fa fa-sitemap"></i> Tree
                    </a>

                    <a
                        href="{{ route('domains.objects.index', [$domain, 'view' => 'list']) }}"
                        class="btn btn-sm btn-secondary {{ request('view', 'list') === 'list' ? 'active' : null }}"
                    >
                        <i class="fa fa-list"></i> List
                    </a>
                </div>
            </div>
        @endslot

        @if(request('view') === 'tree')
            <div class="overflow-x">
                @include('domains.objects.partials.tree')
            </div>
        @else
            @include('domains.objects.partials.list')
        @endif
    @endcomponent
@endsection
