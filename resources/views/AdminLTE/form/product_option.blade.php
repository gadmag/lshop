<tr id="option-value-row">
    <td>
        <div class="form-group">
            <input type="hidden" name="productOptions[][id]" @if($option != null) value="{{$option->id}}" @endif>
            {!! Form::select('productOptions[][color]', $product->getFieldOptions('coating'), $option? $option->color : null, ['class' => 'form-control', 'placeholder' => 'Цвет покрытия:']) !!}
        </div>
    </td>

    <td>

        <div class="form-group">
            {!! Form::select('productOptions[][color_stone]', $product->getFieldOptions('stone'), $option? $option->color_stone : null, ['class' => 'form-control', 'placeholder' => 'Цвет камня:']) !!}
        </div>
    </td>

    <td>
    @if($option && $option->files()->exists())
        <div id="file-item-{{$option->files()->first()->id}}" class="remove-file"
             data-id="{{$option->files()->first()->id}}"><span
                    href="#"><i class="fa fa-remove fa-lg"></i></span><img class="thumbnail"
                                                                           src="{{asset('storage/files/thumbnail/'.$option->files()->first()->filename)}}"
                                                                           alt="Картинка">
        </div>
    @endif
    <div class="form-group">
        {!! Form::label('productOptions[][image_option]', 'Фото продукта') !!}
        {!! Form::file('productOptions[][image_option]', array('multiple'=> false), ['class' => 'form-control' ]) !!}
        <p class="help-block">Выберите файл для добавления</p>
    </div>

    </td>
    <td>
        <div class="form-group">
            {!! Form::select('productOptions[][price_prefix]', ['+' => '+', '-' => '-'], $option? $option->price_prefix : null, ['id'=> 'price_prefix', 'class' => 'form-control']) !!}
            {!! Form::text('productOptions[][price]', $option? $option->price : null, ['class' => 'form-control', 'placeholder' => 'Цена:']) !!}
        </div>
    </td>
    <td>
        <div class="form-group">
            {!! Form::select('productOptions[][weight_prefix]', ['+' => '+', '-' => '-'], $option? $option->weight_prefix : null, ['id'=> 'weight_prefix', 'class' => 'form-control']) !!}
            {!! Form::text('productOptions[][weight]', $option? $option->weight : null, ['class' => 'form-control', 'placeholder' => 'Вес:']) !!}
        </div>
    </td>
    <td>
        <div class="form-group">
            {!! Form::number('productOptions[][quantity]', $option? $option->quantity : 1, ['class' => 'form-control', 'placeholder' => 'Кол-во:']) !!}

        </div>
    </td>
    <td>
        <button @if($option != null) data-id="{{$option->id}}" @endif type="button" data-toggle="tooltip"
                class="remove-options btn btn-danger"><i
                    class="fa fa-minus-circle"></i></button>
    </td>
</tr>