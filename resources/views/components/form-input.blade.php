@props(['name', 'label', 'type' => 'text', 'value' => ''])

<div class="mb-5">
    <label for="{{ $name }}" class="block mb-1.5 text-sm font-medium text-surface-700">{{ $label }}</label>
    <input type="{{ $type }}" name="{{ $name }}" id="{{ $name }}"
           class="form-input"
           placeholder="{{ $label }}"
           value="{{ old($name, $value) }}"
           {{ $attributes }}>
    @error($name)
        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
    @enderror
</div>
