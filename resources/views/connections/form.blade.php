<div class="form-row">
    <div class="col">
        <div class="form-group">
            <label for="type">{{ __('Connection Type') }}</label>

            <select name="type" class="form-control{{ $errors->has('type') ? ' is-invalid' : '' }}" id="type">
                @foreach($types as $value => $name)
                    <option value="{{ $value }}" {{ old('type', $connection->type) == $value ? 'selected' : null }}>
                        {{ $name }}
                    </option>
                @endforeach
            </select>

            @error('type')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>

    <div class="col">
        <div class="form-group">
            <label for="name">{{ __('Connection Name') }}</label>
            <input
                name="name"
                type="text"
                value="{{ old('name', $connection->name) }}"
                class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}"
                id="name"
                placeholder="Domain Name / Company"
            >

            @error('name')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>
</div>

<div class="form-group">
    <label for="hosts">{{ __('Hosts / Controllers') }}</label>
    <input
        name="hosts"
        type="text"
        value="{{ old('hosts', $connection->hosts) }}"
        class="form-control{{ $errors->has('hosts') ? ' is-invalid' : '' }}"
        id="hosts"
        placeholder="10.0.0.1,10.0.0.2"
    >

    @error('hosts')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror

    <small id="hostHelpBlock" class="form-text text-muted">
        Enter each host separated by a comma.
    </small>
</div>

<hr/>

<div class="alert alert-primary">
    <i class="fa fa-exclamation-circle"></i>

    {{ __('The username and password fields are encrypted using OpenSSL and the AES-256-CBC cipher. ') }}
</div>

<div class="form-row">
    <div class="col">
        <div class="form-group">
            <label for="username">{{ __('Username') }}</label>
            <input
                name="username"
                type="text"
                value="{{ old('username', $connection->username) }}"
                class="form-control{{ $errors->has('username') ? ' is-invalid' : '' }}"
                id="username"
                placeholder="admin"
            >

            @error('name')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>

    <div class="col">
        <div class="form-group">
            <label for="password">{{ __('Password') }}</label>
            <input
                name="password"
                type="password"
                class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}"
                id="password"
                placeholder="secret"
            >
        </div>
    </div>
</div>

