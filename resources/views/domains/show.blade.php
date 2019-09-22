@extends('domains.layout')

@section('breadcrumbs', Breadcrumbs::render('domains.show', $domain))

@section('page')
    <div class="row">
        <div class="col-md-4 col-sm-6">
            @component('components.card')
                @slot('header')
                    <h5 class="mb-0">Synchronization</h5>
                @endslot

                <h6 class="d-inline">Last Sync:</h6>

                @if($domain->synchronized_at)
                    <span title="{{ $domain->synchronized_at }}">
                        {{ $domain->synchronized_at->diffForHumans() }}
                    </span>
                @else
                    <em class="text-muted">Never</em>
                @endif

                @slot('footer')
                    <form method="post" action="{{ route('domains.synchronize', $domain) }}">
                        @csrf

                        <button type="submit" class="btn btn-block btn-sm btn-primary">
                            <i class="fa fa-sync"></i> Sync Now
                        </button>
                    </form>
                @endslot
            @endcomponent
        </div>
    </div>
@endsection
