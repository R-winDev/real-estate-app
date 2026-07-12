<div class="flex items-center mb-4">
    <input name="{{ $name }}" id="{{ $name }}" type="checkbox" value="1" @checked(old($name, $checked)) class="w-4 h-4 border border-default-medium rounded-xs bg-neutral-secondary-medium focus:ring-2 focus:ring-brand-soft">
    <label for="{{ $name }}" class="select-none ms-2 text-sm font-medium text-heading">{{ $label }}</label>
</div>
