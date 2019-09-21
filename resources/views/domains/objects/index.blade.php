@extends('domains.layout')

@section('breadcrumbs', Breadcrumbs::render('domains.objects.index', $domain))

@section('page')
    @include('domains.objects.partials.list')
@endsection
