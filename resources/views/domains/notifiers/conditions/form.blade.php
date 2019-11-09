<div class="form-row">
    <div class="col">
        <div class="form-group">
            {{ Form::scoutLabel('boolean', __('Boolean')) }}

            {{
                Form::scoutSelect('boolean', \App\LdapNotifierCondition::booleans(), $condition->boolean, [
                    'data-target' => 'forms--condition.input',
                    'data-action' => 'keyup->forms--condition#clearError',
                ])
            }}

            {{
                Form::scoutError([
                    'data-input' => 'boolean',
                    'data-target' => 'forms--condition.error',
                ])
            }}
        </div>
    </div>

    <div class="col">
        <div class="form-group">
            {{ Form::scoutLabel('type', __('Type')) }}

            {{
                Form::scoutSelect('type', \App\LdapNotifierCondition::types(), $condition->type, [
                    'data-target' => 'forms--condition.input',
                    'data-action' => 'keyup->forms--condition#clearError',
                ])
            }}

            {{
                Form::scoutError([
                    'data-input' => 'type',
                    'data-target' => 'forms--condition.error',
                ])
            }}
        </div>
    </div>

    <div class="col">
        <div class="form-group">
            {{ Form::scoutLabel('attribute', __('Attribute')) }}

            {{
                Form::scoutText('attribute', $condition->attribute, [
                    'placeholder' => 'Attribute name',
                    'data-target' => 'forms--condition.input',
                    'data-action' => 'keyup->forms--condition#clearError',
                ])
            }}

            {{
                Form::scoutError([
                    'data-input' => 'attribute',
                    'data-target' => 'forms--condition.error',
                ])
            }}
        </div>
    </div>

    <div class="col">
        <div class="form-group">
            {{ Form::scoutLabel('operator', __('Operator')) }}

            {{
                Form::scoutSelect('operator', \App\LdapNotifierCondition::operators(), $condition->operator, [
                    'data-target' => 'forms--condition.input',
                    'data-action' => 'keyup->forms--condition#clearError change->forms--condition#hideValueInput',
                    'data-nullable-operators' => json_encode(\App\LdapNotifierCondition::nullableOperators())
                ])
            }}

            {{
                Form::scoutError([
                    'data-input' => 'operator',
                    'data-target' => 'forms--condition.error',
                ])
            }}
        </div>
    </div>
</div>

<div class="form-group">
    {{ Form::scoutLabel('value', __('Value')) }}

    {{
        Form::scoutText('value', $condition->value, [
            'placeholder' => 'Attribute value',
            'data-target' => 'forms--condition.input',
            'data-action' => 'keyup->forms--condition#clearError',
        ])
    }}

    {{
        Form::scoutError([
            'data-input' => 'value',
            'data-target' => 'forms--condition.error',
        ])
    }}
</div>
