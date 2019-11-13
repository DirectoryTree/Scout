@extends('domains.layout')

@section('breadcrumbs', Breadcrumbs::render('domains.search.index', $domain))

@section('page')

    <div class="card shadow-sm">
        <div class="card-header border-bottom">
            <h6 class="mb-0 font-weight-bold text-secondary">Search Domain</h6>
        </div>

        <div class="card-body">
            <form method="get" action="{{ route('partials.domains.search.index', $domain) }}" data-controller="form">
                <div class="form-group">
                    <div class="input-group">
                        {{
                            Form::scoutSearch('term', request('term'), [
                                'data-target' => 'form.input',
                                'placeholder' => 'Search...',
                            ])
                        }}

                        <div class="input-group-append">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <details>
                    <summary class="font-weight-bold text-muted" onselectstart="return false">Search Options</summary>

                    <div class="ml-3 mt-2">
                        {{
                            Form::scoutCheckbox('deleted', '1', request('deleted') == '1', [
                                'id' => 'search-deleted',
                                'label' => 'Include Deleted',
                                'data-target' => 'form.input',
                            ])
                        }}
                    </div>
                </details>
            </form>
        </div>
    </div>

    <div id="search-results"></div>
@endsection
