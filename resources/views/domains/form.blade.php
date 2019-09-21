<div class="form-row">
    <div class="col">
        <div class="form-group">
            <label for="type">{{ __('Connection Type') }}</label>

            <select name="type" class="form-control{{ $errors->has('type') ? ' is-invalid' : '' }}" id="type">
                @foreach($types as $value => $name)
                    <option value="{{ $value }}" {{ old('type', $domain->type) == $value ? 'selected' : null }}>
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
                value="{{ old('name', $domain->name) }}"
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

<div class="form-row">
    <div class="col">
        <div class="form-group">
            <label for="hosts">{{ __('Hosts / Controllers') }}</label>
            <input
                name="hosts"
                type="text"
                value="{{ old('hosts', implode(',', $domain->hosts)) }}"
                class="form-control{{ $errors->has('hosts') ? ' is-invalid' : '' }}"
                id="hosts"
                placeholder="10.0.0.1,10.0.0.2"
            >

            @error('hosts')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror

            <small class="form-text text-muted">
                Enter each host separated by a comma.
            </small>
        </div>
    </div>

    <div class="col">
        <div class="form-group">
            <label for="port">{{ __('Port') }}</label>
            <input
                name="port"
                type="text"
                value="{{ old('port', $domain->port ?? 389) }}"
                class="form-control{{ $errors->has('port') ? ' is-invalid' : '' }}"
                id="port"
                placeholder="389"
            >

            @error('port')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>

    <div class="col">
        <div class="form-group">
            <label for="timeout">{{ __('Timeout') }}</label>
            <input
                name="timeout"
                type="text"
                value="{{ old('timeout', $domain->timeout ?? 5) }}"
                class="form-control{{ $errors->has('timeout') ? ' is-invalid' : '' }}"
                id="timeout"
                placeholder="5"
            >

            @error('timeout')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>
</div>

<div class="form-group">
    <label for="base_dn">{{ __('Search Base DN') }}</label>
    <input
        name="base_dn"
        type="text"
        value="{{ old('base_dn', $domain->base_dn) }}"
        class="form-control{{ $errors->has('base_dn') ? ' is-invalid' : '' }}"
        id="base_dn"
        placeholder="dc=local,dc=com"
    >

    @error('base_dn')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror

    <small class="form-text text-muted">
        The <strong>Search Base DN</strong> is critical to scanning your directory.
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
                value="{{ old('username', decrypt($domain->username)) }}"
                class="form-control{{ $errors->has('username') ? ' is-invalid' : '' }}"
                id="username"
                placeholder="admin"
            >

            @error('username')
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
