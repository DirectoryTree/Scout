<input-selector initial-selection="{{ old('type', $notifier->type) ?? 'dn' }}">
    <template slot-scope="scope">
        <div class="form-row">
            <div class="col">
                <div class="form-group">
                    <label for="type">{{ __('Attribute Type') }}</label>

                    <select name="type" class="form-control{{ $errors->has('type') ? ' is-invalid' : '' }}" id="type" @change="scope.select($event.target.value)">
                        @foreach($types as $value => $name)
                            <option value="{{ $value }}" {{ old('type', $notifier->type) == $value ? 'selected' : null }}>
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

                    <select id="operator" name="operator" class="form-control{{ $errors->has('operator') ? ' is-invalid' : '' }}" id="type">
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
        </div>

        <div class="form-group">
            <label for="value">{{ __('Value') }}</label>

            <date-picker
                v-if="scope.isSelected('timestamp')"
                name="value"
                value="{{ old('value', now()) }}"
                class="form-control{{ $errors->has('value') ? ' is-invalid' : '' }}"
            >
            </date-picker>

            <input
                v-if="scope.isSelected('string')"
                name="value"
                type="text"
                value="{{ old('value', $notifier->value) }}"
                class="form-control{{ $errors->has('value') ? ' is-invalid' : '' }}"
                placeholder="Attribute value"
            >

            <select
                v-if="scope.isSelected('bool')"
                name="value"
                class="form-control{{ $errors->has('value') ? ' is-invalid' : '' }}"
            >
                <option value="1">TRUE</option>
                <option value="0">FALSE</option>
            </select>

            <input
                v-if="scope.isSelected('integer')"
                name="value"
                type="number"
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
    </template>
</input-selector>
