@extends('layouts.app')

@section('content')

    <h3>{{ $domain->name }}</h3>

    <hr/>

    @component('components.card', ['flush' => true])
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Last Updated</th>
                    </tr>
                </thead>

                <tbody>
                @forelse($objects as $object)
                    <tr>
                        <td>{{ $object->name }}</td>
                        <td></td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5">
                            {{ __('There are no objects to list.') }}
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    @endcomponent

    <div class="row my-4">
        <div class="col">
            <div class="d-flex justify-content-center">
                {{ $objects->appends(request()->query())->links() }}
            </div>
        </div>
    </div>
@endsection
