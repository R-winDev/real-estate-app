@props(['name', 'label', 'checked' => false])

<label class="flex items-center gap-3 p-3 rounded-xl border border-surface-200 bg-white hover:bg-surface-50 hover:border-surface-300 cursor-pointer transition-all duration-200 group has-[:checked]:bg-brand-50 has-[:checked]:border-brand-300 has-[:checked]:shadow-glow-brand">
    <input name="{{ $name }}" id="{{ $name }}" type="checkbox" value="1"
           @checked(old($name, $checked))
           class="form-checkbox">
    <span class="text-sm font-medium text-surface-700 select-none group-has-[:checked]:text-brand-700 transition-colors duration-200">{{ $label }}</span>
</label>
