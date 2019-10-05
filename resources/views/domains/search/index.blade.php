@extends('domains.layout')

@section('breadcrumbs', Breadcrumbs::render('domains.search.index', $domain))

@section('page')
    @component('components.card', ['class' => 'mb-4'])
        @slot('header')
            <h5 class="mb-0">Search Domain</h5>
        @endslot

        <form method="get" action="{{ route('domains.search.index', $domain) }}">
            <div class="form-group">
                <div class="input-group">
                    <input
                        name="term"
                        type="search"
                        value="{{ request('term') }}"
                        class="form-control"
                        placeholder="Search..."
                    >

                    <div class="input-group-append">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>
            </div>

            <details>
                <summary onselectstart="return false">Search Options</summary>

                <div class="ml-3 mt-2">
                    <div class="custom-control custom-checkbox">
                        <input
                            type="checkbox"
                            name="deleted"
                            value="1"
                            class="custom-control-input"
                            id="checkbox-include-deleted"
                            {{ request('deleted') == '1' ? 'checked' : null }}
                        >

                        <label class="custom-control-label" for="checkbox-include-deleted">Include Deleted</label>
                    </div>
                </div>
            </details>
        </form>
    @endcomponent

    @if($objects)
        @include('domains.objects.partials.list')
    @endif
@endsection
