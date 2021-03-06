@if(setting('app.pinning', true))
    @inject('pinned', 'App\Http\Injectors\PinnedObjectInjector')

    <div class="row">
        <div class="col">
            <h6 class="text-center text-uppercase text-muted font-weight-bold">
                <i class="fa fa-thumbtack"></i> {{ __('Pins') }}
            </h6>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col">
            <div class="card shadow-sm">
                <div class="card-body mb-n3">
                    <div class="row">
                        @foreach($pinned->get() as $object)
                            <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-3">
                                <div class="card border rounded">
                                    <div class="card-header">
                                        <div class="row">
                                            <div class="col"></div>

                                            <div class="col ml-auto">
                                                <h3 class="text-center my-2">
                                                    @include('domains.objects.partials.icon', ['object' => $object])
                                                </h3>
                                            </div>

                                            <div class="col text-right">
                                                @include('domains.objects.partials.options', [
                                                    'object' => $object,
                                                    'domain' => $object->domain
                                                ])
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card-body pt-0 pb-2">
                                        <h6 class="text-center text-muted font-weight-bold">{{ $object->name }}</h6>

                                        <hr class="my-2"/>

                                        <a
                                            href="{{ route('domains.objects.show', [$object->domain, $object]) }}"
                                            class="btn btn-block btn-sm btn-primary mb-2"
                                        >
                                            <i class="fa fa-eye"></i> View
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                        <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-3">
                            <div class="card border bg-light rounded h-100">
                                <div class="card-body d-flex flex-column justify-content-center h-100">
                                    <div class="text-center">
                                        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#search-modal">
                                            <i class="fa fa-plus-circle"></i> Add
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif
