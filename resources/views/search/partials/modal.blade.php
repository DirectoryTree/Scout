<div class="modal fade" id="search-modal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header py-2">
                <h6 class="modal-title text-muted font-weight-bold">Search Domains</h6>

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i class="fa fa-xs fa-times-circle"></i>
                </button>
            </div>

            <div class="modal-body">
                <form method="get" action="{{ route('partials.search.index') }}" data-controller="form">
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
                </form>

                <div id="search-results"></div>
            </div>
        </div>
    </div>
</div>

