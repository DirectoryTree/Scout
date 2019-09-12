@foreach (session('flash_notification', collect())->toArray() as $message)
    <notification message="{{ $message['message'] }}" level="{{ $message['level'] }}"></notification>
@endforeach

{{ session()->forget('flash_notification') }}
