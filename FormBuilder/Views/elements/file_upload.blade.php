<div class="form-group">
    <label class="control-label">
        {{ $field->title() }}

                <!-- SET SYMBOL FOR REQUIRED VALIDATION -->
        @if($field->hasValidation('required'))

            <span class="symbol required"></span>

        @endif
    </label>
    <div style="clear:both;"></div>

    <a
            href="#example-subview-1"
            data-id="fileUpload_{{ $field->fieldName() }}"
            class="fileUpload_{{ $field->fieldName() }} openFileUpload btn btn-primary show-sv">
        избери снимки
    </a>

    <input type="text"
           value="{{ $field->processBeforeShow(Input::old('fileUpload_'.$field->fieldName())) }}"
           class="no-display"
           id="fileUpload_{{ $field->fieldName() }}"
           name="fileUpload_{{ $field->fieldName() }}"/>

</div>