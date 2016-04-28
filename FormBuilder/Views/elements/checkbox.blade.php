<div class="form-group ">
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
            <div class="checkbox">
                @endif

                <label class="checkbox-inline">
                    <input
                            {{ (isset($button['checked']) && $button['checked'] === true ? 'checked' : null) }}
                            type="checkbox"

                            {{ \libraries\Helpers\FormHelper::optionCheckedMulti(
                                        $button['value'], Input::old($field->fieldName()), false, 'checked'
                                        ) }}

                            value="{{ $button['value'] }}"
                            name="{{ $field->fieldName() }}[]"

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