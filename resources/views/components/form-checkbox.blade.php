@props(['name', 'label', 'checked' => false])

<div class="flex items-center mb-3">
    <input name="{{ $name }}" id="{{ $name }}" type="checkbox" value="1"
           @checked(old($name, $checked))
           class="form-checkbox">
    <label for="{{ $name }}" class="mr-2 text-sm font-medium text-surface-700 select-none cursor-pointer">{{ $label }}</label>
</div>
