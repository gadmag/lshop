@if(!empty($field['title_separated']))
    <div class="separated pt-2">
        <h5>{{$field['title_separated']}}</h5>
        <hr>
    </div>
@endif
<div class="form-group">
    <label for="{{ $field['name'] }}">{{ $field['label'] }}</label>
    <textarea
            class="form-control  {{ array_get( $field, 'class') }}{{ $errors->has($field['name']) ? ' has-error' : '' }}"
            placeholder="{{ $field['label'] }}"
            name="{{ $field['name'] }}" id="{{ $field['name'] }}"
            cols="15" rows="5">{{ old($field['name'], \setting($field['name'])) }}</textarea>

    @if ($errors->has($field['name']))
        <div class="invalid-feedback">{{ $errors->first($field['name']) }}</div>
    @endif
</div>