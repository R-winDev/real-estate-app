@props(['active' => false])

<a {{ $attributes->merge(['class' => 'inline-flex items-center px-3 py-2 rounded-lg text-sm font-medium transition-all duration-200 ' . ($active ? 'bg-primary-50 text-primary-700 shadow-sm' : 'text-neutral-500 hover:text-neutral-800 hover:bg-neutral-100/60')]) }}>
    {{ $slot }}
</a>
