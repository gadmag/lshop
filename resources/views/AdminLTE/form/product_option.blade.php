<tr @if($option == null) class="hide" @endif id="option-value-row{{$option?$loop->index:''}}">
    <td>
        <div class="form-group">
            <input type="hidden" name="productOptions[][id]" @if($option != null) value="{{$option->id}}" @endif>
            {!! Form::text('productOptions[][color]', $option? $option->color : null, ['class' => 'form-control', 'placeholder' => 'Цвет:']) !!}
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
        <button @if($option != null) data-id="{{$option->id}}" @endif type="button" data-toggle="tooltip" class="remove-options btn btn-danger"><i
                    class="fa fa-minus-circle"></i></button>
    </td>
</tr>