<div class="form-group" style="margin-bottom:17px;">
    <label class="control-label">
        {{ $field->title() }}

        @if($field->hasValidation('required'))

            <span class="symbol required"></span>

        @endif
    </label>
    <input
            id="field_{{ $field->fieldName() }}"
            type="text"
            value="{{ $field->processBeforeShow(Input::old($field->fieldName()),
                    (isset($dbFields->{$field->dbField()}) ? $dbFields->{$field->dbField()} : null)) }}"
            placeholder="{{ $field->placeholder() }}"
            class="form-control datetimepicker field_{{ $field->fieldName() }}"
            name="{{ $field->fieldName() }}"
    >

    @if(isset($field->getFieldInfo()['help']) && !empty($field->getFieldInfo()['help']))

        <span style="display:block; font-size:11px;padding-top:5px;">{{ $field->getFieldInfo()['help'] }}</span>

    @endif

</div>