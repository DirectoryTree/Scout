@foreach($results as $result)
    <div class="card border">
        <div class="card-header">
            <h6 class="mb-0 text-muted font-weight-bold">{{ $result['domain']->name }}</h6>
        </div>

        <div class="card-body p-0">
            @include('domains.objects.partials.list', ['domain' => $result['domain'], 'objects' => $result['objects']])
        </div>
    </div>
@endforeach
