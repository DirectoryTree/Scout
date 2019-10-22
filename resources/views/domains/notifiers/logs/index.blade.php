@extends('domains.layout')

@section('breadcrumbs', Breadcrumbs::render('domains.notifiers.logs.index', $domain, $notifier))

@section('page')
    @component('components.card', ['flush' => true, 'class' => 'bg-white'])
        @slot('header')
            <h5 class="mb-0">
                {{ $notifier->notifiable_name }} - Logs
            </h5>
        @endslot

        <div class="table-responsive">
            <table class="table mb-0">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Object</th>
                        <th>Changed Attribute</th>
                        <th>Generated</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($logs as $log)
                        <tr>
                            <td>{{ $log->getKey() }}</td>
                            <td>
                                <h5 class="mb-0">
                                    @include('domains.objects.partials.badge', ['object' => $log->object])
                                </h5>
                            </td>
                            <td>{{ $log->attribute }}</td>
                            <td>
                                {{ $log->created_at->diffForHumans() }}

                                <small>({{ $log->created_at }})</small>
                            </td>
                        </tr>
                    @empty

                    @endforelse
                </tbody>
            </table>
        </div>
    @endcomponent
@endsection
