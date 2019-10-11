<div data-controller="conditions">
    <div class="form-row">
        <div class="col">
            <div class="form-group">
                {{ Form::scoutLabel('type', __('Type')) }}

                {{ Form::scoutSelect('type', $types) }}
            </div>
        </div>

        <div class="col">
            <div class="form-group">
                    {{ Form::scoutLabel('attribute', __('Attribute')) }}

                    {{ Form::scoutText('attribute', null, ['placeholder' => 'Attribute name']) }}

                    {{ Form::scoutError('attribute') }}
            </div>
        </div>

        <div class="col">
            <div class="form-group">
                {{ Form::scoutLabel('operator', __('Operator')) }}

                {{ Form::scoutSelect('type', $types) }}
            </div>
        </div>
    </div>

    <div class="form-group">
        {{ Form::scoutLabel('value', __('Value')) }}

        {{ Form::scoutText('value', null, ['placeholder' => 'Attribute value']) }}
    </div>
</div>
