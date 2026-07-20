@props(['label', 'value', 'color' => 'brand', 'icon' => null])

@php
    $colorClasses = match($color) {
        'brand' => 'bg-brand-100 text-brand-600',
        'emerald' => 'bg-emerald-100 text-emerald-600',
        'amber' => 'bg-amber-100 text-amber-600',
        'violet' => 'bg-violet-100 text-violet-600',
        'red' => 'bg-red-100 text-red-600',
        'blue' => 'bg-blue-100 text-blue-600',
        default => 'bg-surface-100 text-surface-600',
    };
@endphp

<div {{ $attributes->merge(['class' => 'card p-5 group hover:shadow-elevated transition-all duration-300']) }}>
    <div class="flex items-center gap-4">
        @if($icon || $slot->isNotEmpty())
            <div class="w-12 h-12 {{ $colorClasses }} rounded-xl flex items-center justify-center shrink-0 group-hover:scale-110 transition-transform duration-300">
                {{ $icon ?? $slot }}
            </div>
        @endif
        <div>
            <div class="text-2xl font-extrabold text-surface-900">{{ number_format($value) }}</div>
            <div class="text-xs text-surface-500 font-medium">{{ $label }}</div>
        </div>
    </div>
</div>
