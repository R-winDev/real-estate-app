@props(['name', 'label', 'value' => ''])

<div class="mb-5">
    <label for="{{ $name }}" class="block mb-1.5 text-sm font-medium text-surface-700">{{ $label }}</label>
    <textarea id="{{ $name }}" name="{{ $name }}" rows="4"
              class="form-textarea"
              placeholder="{{ $label }}">{{ old($name, $value) }}</textarea>
    @error($name)
        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
    @enderror
</div>
