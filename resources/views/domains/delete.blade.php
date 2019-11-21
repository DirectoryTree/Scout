@extends('domains.layout')

@section('title', __('Delete Domain'))

@section('breadcrumbs', Breadcrumbs::render('domains.delete', $domain))

@section('page')
    <div class="card shadow-sm">
        <div class="card-header">
            <h6 class="mb-0 font-weight-bold text-secondary">{{ __('Delete Domain') }}</h6>
        </div>

        <div class="card-body bg-light">
            <p>
                Deleting a domain will purge the following data:
            </p>

            <ul>
                <li>All objects</li>
                <li>All scans</li>
                <li>All connection data</li>
                <li>All change history</li>
                <li>All notifications and notification history</li>
            </ul>

            <p>Once you delete, there is no going back. Please be certain.</p>
        </div>

        <div class="card-footer">
            <form
                method="post"
                action="{{ route('domains.destroy', $domain) }}"
                data-controller="form-confirmation"
                data-form-confirmation-title="Delete domain?"
                data-form-confirmation-message="This action cannot be undone. All domain data will be deleted."
            >
                @csrf
                @method('delete')

                <div class="d-flex justify-content-between">
                    <a href="{{ route('domains.show', $domain) }}" class="btn btn-secondary">
                        <i class="fa fa-times"></i> Cancel
                    </a>

                    <button type="submit" class="btn btn-danger">
                        <i class="far fa-trash-alt"></i> I'm sure, delete domain
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
