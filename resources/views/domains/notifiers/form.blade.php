<div data-controller="conditions">
    <div class="form-row">
        <div class="col">
            <div class="form-group">
                @component('components.form.select', [
                    'name' => 'type',
                    'options' => $types,
                    'label' => __('Type'),
                    'default' => ''
                ])
                @endcomponent
            </div>
        </div>

        <div class="col">
            <div class="form-group">
                @component('components.form.input', [
                    'name' => 'attribute',
                    'label' => __('Attribute'),
                    'default' => '',
                    'placeholder' => 'Attribute Name',
                    'attributes' => [
                        'data-controller' => 'test',
                    ]
                ])
                @endcomponent
            </div>
        </div>

        <div class="col">
            <div class="form-group">
                @component('components.form.select', [
                    'name' => 'operator',
                    'options' => $operators,
                    'label' => __('Operator'),
                    'default' => ''
                ])
                @endcomponent
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


        @component('components.form.input', [
            'name' => 'value',
            'default' => '',
            'placeholder' => 'Attribute value',
        ])
        @endcomponent

        @component('components.form.select', [
            'options' => ['0' => 'FALSE', '1' => 'TRUE'],
            'name' => 'value',
        ])
        @endcomponent

        @component('components.form.input', [
            'name' => 'value',
            'type' => 'number',
            'default' => '',
            'placeholder' => 'Attribute value',
        ])
        @endcomponent
    </div>
</div>
