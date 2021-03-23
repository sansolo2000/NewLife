@if ($errors->has($control))
<small class="form-text text-danger">
    {{ $errors->first($control) }}
</small>
@endif