@extends('domains.layout')

@section('breadcrumbs', Breadcrumbs::render('domains.notifiers.logs.index', $domain, $notifier))

@section('page')
    <div class="card shadow-sm">
        <div class="card-header">
            <h6 class="font-weight-bold text-muted mb-0">
                {{ $notifier->notifiable_name }} - Logs
            </h6>
        </div>

        <div class="card-body p-0">
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
                        <tr>
                            <td colspan="4" class="text-center text-secondary">There are no logs for this notifier.</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
