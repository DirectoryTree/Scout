@extends('layouts.app')

@section('title', __('Dashboard'))

@section('content')
    <div class="row mb-4">
        <div class="col">
            <div class="card shadow-sm">
                <div class="card-header">
                    <h5 class="font-weight-bold text-secondary mb-0">Dashboard</h5>
                </div>

                <div class="card-body">
                    Welcome to Scout!
                </div>
            </div>
        </div>
    </div>

    @include('dashboard.partials.pinning')

    @include('dashboard.partials.calendar')
@endsection
