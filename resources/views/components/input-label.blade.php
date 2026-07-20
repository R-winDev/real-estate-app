@props(['value'])

<label {{ $attributes->merge(['class' => 'block mb-2 font-semibold text-sm text-surface-700']) }}>
    {{ $value ?? $slot }}
</label>
