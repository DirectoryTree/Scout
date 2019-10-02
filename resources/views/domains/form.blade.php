<div class="form-group">
    <label class="pr-2 font-weight-bold">Connection Encryption</label>

    <div class="custom-control custom-radio d-inline pr-2">
        <input
            class="custom-control-input{{ $errors->has('encryption') ? ' is-invalid' : '' }}"
            type="radio"
            name="encryption"
            id="none"
            value=""
            {{ old('encryption', $domain->encryption) == '' ? 'checked' : null }}
        >
        <label class="custom-control-label" for="none">
            No Encryption
        </label>
    </div>

    <div class="custom-control custom-radio d-inline pr-2">
        <input
            class="custom-control-input{{ $errors->has('encryption') ? ' is-invalid' : '' }}"
            type="radio"
            name="encryption"
            id="radio-use-tls"
            value="tls"
            {{ old('encryption', $domain->encryption) == 'tls' ? 'checked' : null }}
        >
        <label class="custom-control-label" for="radio-use-tls">
            Use TLS
        </label>
    </div>

    <div class="custom-control custom-radio d-inline pr-2">
        <input
            class="custom-control-input{{ $errors->has('encryption') ? ' is-invalid' : '' }}"
            type="radio"
            name="encryption"
            id="radio-use-ssl"
            value="ssl"
            {{ old('encryption', $domain->encryption) == 'ssl' ? 'checked' : null }}
        >
        <label class="custom-control-label" for="radio-use-ssl">
            Use SSL
        </label>
    </div>

    @error('encryption')
        <span class="invalid-feedback d-block" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror

    <small class="form-text text-muted">
        <strong>Note:</strong> You must select TLS or SSL encryption to be able to perform all password related LDAP tasks.
    </small>
</div>

<div class="form-row">
    <div class="col">
        <div class="form-group">
            <label for="type" class="font-weight-bold">{{ __('Connection Type') }}</label>

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
            <label for="name" class="font-weight-bold">{{ __('Connection Name') }}</label>
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
            <label for="hosts" class="font-weight-bold">{{ __('Hosts / Controllers') }}</label>
            <input
                name="hosts"
                type="text"
                value="{{ old('hosts', implode(',', $domain->hosts ?? [])) }}"
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
            <label for="port" class="font-weight-bold">{{ __('Port') }}</label>
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
            <label for="timeout" class="font-weight-bold">{{ __('Timeout') }}</label>
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

<div class="form-row">
    <div class="col">
        <div class="form-group">
            <label for="base_dn" class="font-weight-bold">{{ __('Search Base DN') }}</label>
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
    </div>

    <div class="col">
        <div class="form-group">
            <label for="base_dn" class="font-weight-bold">{{ __('Global Search Filter') }}</label>
            <input
                name="filter"
                type="text"
                value="{{ old('filter', $domain->filter) }}"
                class="form-control{{ $errors->has('filter') ? ' is-invalid' : '' }}"
                id="filter"
                placeholder="(example=value)"
            >

            @error('filter')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror

            <small class="form-text text-muted">
                This filter is applied on <strong>every scan</strong> on your directory.
            </small>
        </div>
    </div>
</div>

<hr/>

<div class="alert alert-primary">
    <i class="fa fa-exclamation-circle"></i>

    {{ __('The username and password fields are encrypted using OpenSSL and the AES-256-CBC cipher. ') }}
</div>

<div class="form-row">
    <div class="col">
        <div class="form-group">
            <label for="username" class="font-weight-bold">{{ __('Username') }}</label>
            <input
                name="username"
                type="text"
                value="{{ old('username', $domain->username ? decrypt($domain->username) : null) }}"
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
            <label for="password" class="font-weight-bold">{{ __('Password') }}</label>
            <input
                name="password"
                type="password"
                class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}"
                id="password"
                placeholder="secret"
            >

            @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>
</div>
