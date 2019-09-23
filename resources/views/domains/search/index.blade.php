@extends('domains.layout')

@section('breadcrumbs', Breadcrumbs::render('domains.search.index', $domain))

@section('page')
    @component('components.card', ['class' => 'mb-4'])
        @slot('header')
            <h5 class="mb-0">Search Domain</h5>
        @endslot

        <form>
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
        </form>
    @endcomponent

    @if($objects)
        @include('domains.objects.partials.list')
    @endif
@endsection
