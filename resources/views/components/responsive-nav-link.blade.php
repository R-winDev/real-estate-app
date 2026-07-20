@props(['active' => false])

<a {{ $attributes->merge(['class' => 'block w-full pr-3 pl-4 py-2.5 border-r-4 text-start text-base font-medium transition-all duration-200 rounded-l-lg ' . ($active ? 'border-primary-500 text-primary-700 bg-primary-50/80' : 'border-transparent text-neutral-600 hover:text-neutral-800 hover:bg-neutral-50 hover:border-neutral-300')]) }}>
    {{ $slot }}
</a>
