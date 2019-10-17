@extends('domains.layout')

@section('menu')
    @include('domains.objects.menu')
@endsection

@section('name')
    <span class="mr-2">
        @include('domains.objects.partials.icon')
    </span>

    {{ $object->name }}

    @if($object->trashed())
        <small class="text-muted">(deleted)</small>
    @endif
@endsection

@section('dn', $object->dn)
