@props(['active' => false])

<a {{ $attributes->merge(['class' => 'inline-flex items-center px-3 py-2 rounded-lg text-sm font-medium transition-all duration-200 ' . ($active ? 'bg-brand-50 text-brand-700 shadow-sm' : 'text-surface-500 hover:text-surface-800 hover:bg-surface-100/60')]) }}>
    {{ $slot }}
</a>
