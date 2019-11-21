@extends('layouts.app')

@section('title', __('Domains'))

@section('content')
    <div class="row py-2">
        <div class="col">
            <h2>{{ __('Domains') }}</h2>
        </div>
    </div>

    <div class="row">
        @foreach($domains as $domain)
            <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-3">
                <div class="card shadow-sm bg-white">
                    <div class="card-body">
                        <div class="row justify-content-between align-items-center mb-3" data-controller="visit" data-url="{{ route('domains.show', $domain) }}">
                            <div class="col">
                                <h3 class="mb-0">{{ $domain->name }}</h3>
                            </div>

                            <div class="col-auto">
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-light border rounded-pill" type="button" data-toggle="dropdown">
                                        <i class="fas fa-ellipsis-v"></i>
                                    </button>

                                    <div class="dropdown-menu">
                                        <a href="{{ route('domains.notifiers.index', $domain) }}" class="dropdown-item">
                                            <i class="fa fa-bell"></i> Notifications
                                        </a>

                                        <a href="{{ route('domains.search.index', $domain) }}" class="dropdown-item">
                                            <i class="fa fa-search"></i> Search
                                        </a>

                                        <a href="{{ route('domains.objects.index', $domain) }}" class="dropdown-item">
                                            <i class="fa fa-cubes"></i> Objects
                                        </a>

                                        <div class="dropdown-divider"></div>

                                        <a href="{{ route('domains.edit', $domain) }}" class="dropdown-item">
                                            <i class="fa fa-edit"></i> Edit
                                        </a>

                                        <a href="{{ route('domains.delete', $domain) }}" class="dropdown-item">
                                            <i class="fa fa-trash"></i> Delete
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col text-center">
                                <h2 class="rounded-pill text-muted bg-light">{{ $domain->objects_count }}</h2>
                                <h5 class="d-inline text-muted">objects</h5>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col">
                                <a href="{{ route('domains.show', $domain) }}" class="btn btn-block btn-primary">
                                    <i class="far fa-eye"></i> Overview
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach

        <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-3">
            <div class="card shadow-sm bg-light mb-4 h-100">
                <div class="card-body d-flex flex-column justify-content-center h-100">
                    <div class="text-center">
                        <a href="{{ route('domains.create') }}" class="btn btn-success">
                            <i class="fa fa-plus-circle"></i> {{ __('Add') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
