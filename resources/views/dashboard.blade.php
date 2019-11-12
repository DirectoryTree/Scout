@extends('layouts.app')

@inject('pinned', 'App\Http\Injectors\PinnedObjectInjector')

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
        <div class="col">
            <h6 class="text-center text-uppercase text-muted font-weight-bold">
                <i class="fa fa-thumbtack"></i> Pins
            </h6>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="row">
                        @foreach($pinned->get() as $object)
                            <div class="col-sm-6 col-md-4 col-lg-3">
                                <div class="card border rounded">
                                    <div class="card-header">
                                        <div class="row">
                                            <div class="col"></div>

                                            <div class="col ml-auto">
                                                <h3 class="text-center my-2">
                                                    @include('domains.objects.partials.icon', ['object' => $object])
                                                </h3>
                                            </div>

                                            <div class="col text-right">
                                                @include('domains.objects.partials.options', [
                                                    'object' => $object,
                                                    'domain' => $object->domain
                                                ])
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card-body pt-0">
                                        <h6 class="text-center text-muted font-weight-bold">{{ $object->name }}</h6>

                                        <hr class="my-2"/>

                                        <a
                                            href="{{ route('domains.objects.show', [$object->domain, $object]) }}"
                                            class="btn btn-block btn-sm btn-dark mb-2"
                                        >
                                            <i class="fa fa-eye"></i> View
                                        </a>

                                        @if($object->pinned)
                                            <form method="post" action="{{ route('objects.pin.destroy', $object) }}" data-controller="form">
                                                @csrf
                                                @method('delete')
                                                <button type="submit" class="btn btn-sm btn-block btn-primary">
                                                    <i class="fa fa-thumbtack"></i> Unpin from Dashboard
                                                </button>
                                            </form>
                                        @else
                                            <form method="post" action="{{ route('objects.pin.store', $object) }}" data-controller="form">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-block btn-primary">
                                                    <i class="fa fa-thumbtack"></i> Pin to Dashboard
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col">
            <h6 class="text-center text-uppercase text-muted font-weight-bold">
                <i class="fa fa-calendar"></i> Change Calendar
            </h6>
        </div>
    </div>

    <div class="row">
        <div class="col">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="row">
                        @foreach($months as $month)
                            <div class="col-sm-12 col-md-6 col-lg-4">
                                @include('calendar', ['date' => $month, 'events' => $changes])
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
