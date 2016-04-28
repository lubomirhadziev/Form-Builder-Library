<div class="form-group">
    <label class="control-label">
        {{ $field->title() }}

                <!-- SET SYMBOL FOR REQUIRED VALIDATION -->
        @if($field->hasValidation('required'))

            <span class="symbol required"></span>

        @endif
    </label>
    <div style="clear:both;"></div>

    @foreach($field->radioButtons() as $button)

        @if($field->radioConfig()['type'] == 'newline')
            <div class="radio">
                @endif

                <label class="radio-inline">
                    <input
                            type="radio"
                            {{ \libraries\Helpers\FormHelper::checkboxChecked($button['value'], $field->processBeforeShow(Input::old($field->fieldName()),
                        (isset($dbFields->{$field->dbField()}) ? $dbFields->{$field->dbField()} : null))) }}
                            value="{{ $button['value'] }}"
                            name="{{ $field->fieldName() }}"
                            class="{{ (isset($field->radioConfig()['color'])
                    && !empty($field->radioConfig()['color']) ? $field->radioConfig()['color'] : 'grey') }}"
                    >
                    {{ $button['title'] }}
                </label>

                @if($field->radioConfig()['type'] == 'newline')
            </div>
        @endif

    @endforeach

</div>