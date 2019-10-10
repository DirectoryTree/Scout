@foreach (session('flash_notification', collect())->toArray() as $message)
    <div
        data-controller="alert"
        data-alert-level="{{ $message['level'] }}"
        data-alert-message="{{ $message['message'] }}"
    ></div>
@endforeach

{{ session()->forget('flash_notification') }}
