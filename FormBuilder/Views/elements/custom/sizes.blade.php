<div class="col-md-5">
    <div class="form-group" style="margin-bottom:17px;">
        <label class="control-label">
            {{ $field->title() }}
        </label>

        <table class="table table-striped table-hover">
            <tbody>


            @foreach($field->_sizeData as $size)

                <tr>
                    <td>{{ $size->title }}</td>
                    <td>
                        <input
                                type="text"
                                name="{{ $field->fieldName() }}[0][{{ $size->id }}]"
                                value="{{ $field->getSizeValue($size->id) }}"
                                placeholder="Цена"
                        />
                    </td>
                    <td>
                        <input
                                type="text"
                                name="{{ $field->fieldName() }}[1][{{ $size->id }}]"
                                value="{{ $field->getCmValue($size->id) }}"
                                placeholder="размер"
                        />
                        <small>мм.</small>
                    </td>
                </tr>

            @endforeach

            </tbody>
        </table>

        <!-- Help line -->
        @if(isset($field->getFieldInfo()['help']) && !empty($field->getFieldInfo()['help']))

            <span style="display:block; font-size:11px;padding-top:5px;">{{ $field->getFieldInfo()['help'] }}</span>

        @endif
    </div>
</div>
