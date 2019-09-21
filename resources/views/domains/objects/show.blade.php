@extends('domains.layout')

@section('breadcrumbs', Breadcrumbs::render('domains.objects.show', $domain, $object))

@section('page')
    @include('domains.objects.partials.list')
@endsection
