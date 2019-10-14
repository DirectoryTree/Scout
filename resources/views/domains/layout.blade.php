@extends('layouts.app')

@section('content')
    <div class="d-flex flex-column justify-content-between mb-2">
        <h3 class="mb-0">
            @isset($object)
                @include('domains.objects.partials.icon', ['object' => $object])

                {{ $object->name }}

                @if($object->trashed())
                    <small class="text-muted">(deleted)</small>
                @endif
            @else
                {{ $domain->name }}
            @endif
        </h3>

        <div class="text-muted">
            @isset($object) {{ $object->dn }} @else {{ $domain->base_dn }} @endif
        </div>
    </div>

    <div class="row">
        <div class="col-lg-3 col-md-4 col-12">
            @isset($object)
                @include('domains.objects.menu')
            @endisset

            @include('domains.menu')
        </div>

        <div class="col-lg-9 col-md-8 col-12">
            @yield('page')
        </div>
    </div>
@endsection
