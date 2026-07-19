@props(['active' => false])

<a {{ $attributes->merge(['class' => 'inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium leading-5 focus:outline-none transition duration-150 ease-in-out ' . ($active ? 'border-brand-500 text-surface-900 focus:border-brand-700' : 'border-transparent text-surface-500 hover:text-surface-700 hover:border-surface-300 focus:text-surface-700 focus:border-surface-300')]) }}>
    {{ $slot }}
</a>
