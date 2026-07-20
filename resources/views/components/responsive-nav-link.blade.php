@props(['active' => false])

<a {{ $attributes->merge(['class' => 'block w-full pr-3 pl-4 py-2.5 border-r-4 text-start text-base font-medium transition-all duration-200 rounded-l-lg ' . ($active ? 'border-brand-500 text-brand-700 bg-brand-50/80' : 'border-transparent text-surface-600 hover:text-surface-800 hover:bg-surface-50 hover:border-surface-300')]) }}>
    {{ $slot }}
</a>
