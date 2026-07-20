@props(['name', 'label', 'checked' => false])

<label class="flex items-center gap-3 p-3 rounded-xl border border-neutral-200 bg-white hover:bg-neutral-50 hover:border-neutral-300 cursor-pointer transition-all duration-200 group has-[:checked]:bg-primary-50 has-[:checked]:border-primary-300 has-[:checked]:shadow-glow-brand">
    <input name="{{ $name }}" id="{{ $name }}" type="checkbox" value="1"
           @checked(old($name, $checked))
           class="form-checkbox">
    <span class="text-sm font-medium text-neutral-700 select-none group-has-[:checked]:text-primary-700 transition-colors duration-200">{{ $label }}</span>
</label>
