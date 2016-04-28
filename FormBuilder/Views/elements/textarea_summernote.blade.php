<div class="form-group">
    <label class="control-label">
        {{ $field->title() }}

                <!-- SET SYMBOL FOR REQUIRED VALIDATION -->
        @if($field->hasValidation('required'))

            <span class="symbol required"></span>

        @endif
    </label>
    <div style="clear:both;"></div>

    @if(isset($field->getFieldInfo()['help']) && !empty($field->getFieldInfo()['help']))

        <span style="display:block; font-size:11px;padding-top:5px;">{{ $field->getFieldInfo()['help'] }}</span>

    @endif

    <textarea name="{{ $field->fieldName() }}" class="ckeditor">
    {{ $field->processBeforeShow(Input::old($field->fieldName()), 
                (isset($dbFields->{$field->dbField()}) ? $dbFields->{$field->dbField()} : null)) }}
    </textarea>

</div>