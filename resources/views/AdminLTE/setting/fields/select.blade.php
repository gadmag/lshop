@if(!empty($field['title_separated']))
    <div class="separated pt-2">
        <h5>{{$field['title_separated']}}</h5>
        <hr>
    </div>
@endif
<div class="form-group">
    <label for="{{ $field['name'] }}">{{ $field['label'] }}</label>
    <select name="{{ $field['name'] }}" class="form-control {{ array_get( $field, 'class') }} {{ $errors->has($field['name']) ? ' has-error' : '' }}" id="{{ $field['name'] }}">
        @foreach(array_get($field, 'options', []) as $val => $label)
            <option @if( old($field['name'], \setting($field['name'])) == $val ) selected  @endif value="{{ $val }}">{{ $label }}</option>
        @endforeach
    </select>
    @if ($errors->has($field['name']))
        <div class="invalid-feedback">{{ $errors->first($field['name']) }}</div>
    @endif
</div>
