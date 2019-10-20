@extends('domains.layout')

@section('breadcrumbs', Breadcrumbs::render('domains.notifiers.show', $domain, $notifier))

@section('page')

@endsection
