@extends('layouts.app')

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

    <div class="row">
        <div class="col-sm-12 col-md-6 col-lg-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    @include('calendar', ['date' => now()->subMonths(2)])
                </div>
            </div>
        </div>

        <div class="col-sm-12 col-md-6 col-lg-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    @include('calendar', ['date' => now()->subMonth()])
                </div>
            </div>
        </div>

        <div class="col-sm-12 col-md-6 col-lg-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    @include('calendar', ['date' => now()])
                </div>
            </div>
        </div>
    </div>
@endsection
