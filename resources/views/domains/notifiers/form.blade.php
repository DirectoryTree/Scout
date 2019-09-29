<div class="form-group">
    <label for="type">{{ __('Attribute Type') }}</label>

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

<div class="form-row">
    <div class="col">
        <div class="form-group">
            <label for="attribute">{{ __('Attribute') }}</label>

            <input
                name="attribute"
                type="text"
                value="{{ old('attribute', $notifier->attribute) }}"
                class="form-control{{ $errors->has('attribute') ? ' is-invalid' : '' }}"
                placeholder="Attribute name"
            >

            @error('attribute')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>

    <div class="col">
        <div class="form-group">
            <label for="operator">{{ __('Operator') }}</label>

            <select name="operator" class="form-control{{ $errors->has('operator') ? ' is-invalid' : '' }}" id="type">
                @foreach($operators as $value => $name)
                    <option value="{{ $value }}" {{ old('operator', $notifier->operator) == $value ? 'selected' : null }}>
                        {{ $name }}
                    </option>
                @endforeach
            </select>

            @error('operator')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>

    <div class="col">
        <div class="form-group">
            <label for="value">{{ __('Value') }}</label>

            <input
                name="value"
                type="text"
                value="{{ old('value', $notifier->value) }}"
                class="form-control{{ $errors->has('value') ? ' is-invalid' : '' }}"
                placeholder="Attribute value"
            >

            @error('value')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>
</div>
