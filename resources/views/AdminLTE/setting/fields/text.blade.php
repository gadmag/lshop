@if(!empty($field['title_separated']))
    <div class="separated pt-2">
        <h5>{{$field['title_separated']}}</h5>
        <hr>
    </div>
@endif
<div class="form-group">
    <label for="{{ $field['name'] }}">{{ $field['label'] }}</label>
    <input type="{{ $field['type'] }}" name="{{ $field['name'] }}"
           value="{{ old($field['name'], \setting($field['name'])) }}"
           class="form-control {{ array_get( $field, 'class') }} {{ $errors->has($field['name']) ? ' is-invalid' : '' }}" id="{{ $field['name'] }}"
           placeholder="{{ $field['label'] }}">

    @if ($errors->has($field['name']))
        <div class="invalid-feedback">{{ $errors->first($field['name']) }}</div>
    @endif
</div>