<div class="form-group {{ $errors->has($field['name']) ? ' has-error' : '' }}">
    <label for="{{ $field['name'] }}">{{ $field['label'] }}</label>
    <textarea class="form-control  {{ array_get( $field, 'class') }}"
              placeholder="{{ $field['label'] }}" name="{{ $field['name'] }}" id="{{ $field['name'] }}" cols="15" rows="5">
        {{ old($field['name'], \setting($field['name'])) }}
    </textarea>

    @if ($errors->has($field['name']))
        <small class="help-block">{{ $errors->first($field['name']) }}</small>
    @endif
</div>