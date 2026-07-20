@props(['name', 'label', 'type' => 'text', 'value' => ''])

<div class="mb-5">
    <label for="{{ $name }}" class="block mb-2 text-sm font-semibold text-surface-700">{{ $label }}</label>
    <input type="{{ $type }}" name="{{ $name }}" id="{{ $name }}"
           class="form-input"
           placeholder="{{ $label }}"
           value="{{ old($name, $value) }}"
           {{ $attributes }}>
    @error($name)
        <p class="mt-2 text-sm text-red-600 flex items-center gap-1.5">
            <svg class="w-4 h-4 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/></svg>
            {{ $message }}
        </p>
    @enderror
</div>
