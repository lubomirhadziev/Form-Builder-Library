<div class="form-group">
    <label class="control-label">
        {{ $field->title() }}

                <!-- SET SYMBOL FOR REQUIRED VALIDATION -->
        @if($field->hasValidation('required'))

            <span class="symbol required"></span>

        @endif
    </label>
    <div style="clear:both;"></div>

    <select class="form-control {{ ($field->selectConfig()['type'] == 'search' ? 'search-select' : null) }}"
            name="{{ $field->fieldName() }}">
        <option value="">&nbsp;</option>

        @foreach($field->selectOptions() as $option)

            <option
                    {{ (isset($option['checked']) && $option['checked'] == true ? 'selected' : null) }}

                    {{ \libraries\Helpers\FormHelper::optionChecked(
                    $option['value'],
                    (isset($dbFields->{$field->dbField()}) ? $dbFields->{$field->dbField()} : Input::old($field->fieldName()))
                    ) }}

                    value="{{ $option['value'] }}">
                {{ $option['title'] }}
            </option>

        @endforeach
    </select>

</div>