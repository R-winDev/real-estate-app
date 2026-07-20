@props(['value'])

<label {{ $attributes->merge(['class' => 'block mb-2 font-semibold text-sm text-neutral-700']) }}>
    {{ $value ?? $slot }}
</label>
